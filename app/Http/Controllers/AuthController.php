<?php

namespace App\Http\Controllers;

use App\User;
use SoapClient;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $serviceURL = "http://webservices.egat.co.th/authentication/au_provi.php?wsdl";

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login']]);
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        try {

            /* attempt to verify the credentials on egat authen web service */
            if(env('EGAT_AUTHEN'))
                if(!$this->egatLogin($this->serviceURL,$credentials))
                    return response()->json(['message' => 'หมายเลขผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'], 401);  

            $username = (int)$request->input('username');

            $credentials = ['username' => $username , 'password' => $request->input('password')];

            // if((!$this->isAdmin($username)) && (!$this->isBossDevisionUp($username)))
            //     return response()->json(['message' => 'คุณไม่ได้รับอนุญาตให้เข้าใช้งาน'], 403);            
                        
            $this->createUserNotExist($credentials);

            if (! $access_token = JWTAuth::attempt($credentials))
                return response()->json(['message' => 'หมายเลขผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'], 401);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['message' => 'ไม่สามารถเข้าระบบได้'], 500);
        }

        return response()->json([
            'access_token' => $access_token,
            'token_type' => 'bearer',
        ]);

    }

    public function logout()
    {
        JWTAuth::invalidate();
        
        return response([
            'message' => 'ออกจากระบบเรียบร้อยแล้ว'
        ], 200);
    }

    public function egatLogin($url,$credentials)
    {                
        $client = new SoapClient($url);
        return $client->validate_user($credentials['username'],$credentials['password']);
    }    

    public function createUserNotExist($credentials)
    {
        $employee = \App\Position::where('employee_code',$credentials['username'])->first();

        $user = User::where('email',$credentials['username']."@egat.co.th")->first();
        if(! $user)
        {
            return User::create([
                'username' => $credentials['username'],
                'name' => $employee->employee_name,
                'email' => $credentials['username']."@egat.co.th",
                'password' => bcrypt($credentials['password'])
            ]);
        }
        return $user->update([ 
                    'name' => $employee->employee_name,
                    'password' => bcrypt($credentials['password'])
                ]);
    }

    public function isBoss($username)
    {
        $boss = \App\Position::where('boss_id',$username)->exists();
        return $boss?:false;
    }

    public function isAdmin($id)
    {
        $admin = User::where('username',$id)
                        ->where('admin',true)
                        ->exists();
        return $admin?:false;
    }

    public function isBossDevisionUp($id)
    {
        $boss = \App\Position::where('employee_code',$id)
                        ->where('employee_subgroup','>','11')
                        ->orWhere('employee_code',$id)
                        ->where('employee_group','9')
                        ->exists();
        return $boss?:false;
    }
}
