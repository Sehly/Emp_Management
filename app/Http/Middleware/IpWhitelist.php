<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpWhitelist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
     
        $allowedIps = explode(',', env('ALLOWED_IPS', ''));

        $clientIp = $request->ip();

        if (!in_array($clientIp, $allowedIps)) {
            
            return response()->json(['error' => 'Access denied.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}