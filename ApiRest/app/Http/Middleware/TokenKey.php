<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class TokenKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header("key")){
            if(Config::get('app.token') == $request->header("key")){
                return $next($request);
            }
            else{
                return response()->json(['error' => "API key is missing."], 403);
            }
        }
        return response()->json(['error' => "API key is missing."], 403);
    }
}
