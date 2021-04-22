<?php

namespace App\Http\Middleware;

use App\MobilePhoneLog;
use Closure;

class LogAccessMobilePhoneMiddleware
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
        return $next($request);

    }

    public function terminate($request, $response)
    {
        $logEntry = new MobilePhoneLog();

        $logEntry->request_url = $request->fullUrl();
        $logEntry->request_HTTP_method = $request->method();
        $logEntry->request_header = json_encode($request->header());
        $logEntry->request_body = $request->getContent();
        $logEntry->requested_at = date('Y-m-d H:i:s', LARAVEL_START);
        $logEntry->requestor = auth()->user()->username;
        $logEntry->requestor_ip = $request->ip();
        $logEntry->status_code = $response->getStatusCode();

        $logEntry->save();
    }
}
