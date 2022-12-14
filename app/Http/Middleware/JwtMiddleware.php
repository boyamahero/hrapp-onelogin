<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use App\User;
use Exception;
use App\Position;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // get token from request
            $atkn = JWTAuth::getToken();

            // check token invalid at sso server
            // return json palyload and get preferred_username to be username
            // $url = "https://ssolb.egat.co.th/auth/realms/EGAT/protocol/openid-connect/userinfo";
            // $url = "https://ssolb.egat.co.th/auth/realms/EGAT/protocol/openid-connect/userinfo";
            // $ONELOGIN_SUBDOMAIN = config('oidc-client.onelogin.subdomain');
            $url = config('onelogin.subdomain')."me";

            $json = $this->KeycloakIntrospectToken($url, $atkn);
            $employeeID = (int) json_decode($json)->preferred_username;

            // $employeeID  = "592997";

            // create user if it is not exist.
            $this->createUserNotExist($employeeID);

            // login by username
            $user = User::where('username', $employeeID)->first();
            $token = auth()->login($user);

            // dd($user);
            // $user = JWTAuth::parseToken()->authenticate();
            // // $refreshed = JWTAuth::refresh(JWTAuth::getToken());
            // // header('Authorization: Bearer ' . $refreshed);

        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                // If the token is expired, then it will be refreshed and added to the headers
                try {
                    $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                    $user = JWTAuth::setToken($refreshed)->toUser();
                    header('Authorization: Bearer ' . $refreshed);
                } catch (JWTException $e) {
                    return response()->json(['status' => 'Token is not refreshable '], 401);
                }
            } else {
                return response()->json(['status' => 'Authorization Token not found'], 403);
            }
        }
        return $next($request);
    }

    public function KeycloakIntrospectToken($url, $atkn)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: Bearer $atkn",
                "Content-Type: application/x-www-form-urlencoded"
            )
        );
        $response = curl_exec($ch);
        echo curl_error($ch);
        curl_close($ch);
        return $response;
    }

    public function createUserNotExist($employeeCode)
    {
        $employee = Position::where('employee_code', $employeeCode)->first();

        $user = User::where('email', $employeeCode . "@egat.co.th")->first();
        if (!$user) {
            return User::create([
                'username' => $employeeCode,
                'name' => $employee->employee_name,
                'email' => $employeeCode . "@egat.co.th",
                'password' => bcrypt('keycloak'),
                'api_token' => Str::random(60),
            ]);
        }

        if (! $user->api_token)
        {
            return $user->update([
                'name' => $employee->employee_name,
                'api_token' => Str::random(60),
            ]);
        }

        return $user->update([
            'name' => $employee->employee_name,
        ]);
    }
}
