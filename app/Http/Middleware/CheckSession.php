<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
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
        $session = to_object(session()->all());
        if(!empty($session->authenticated)){
            if(!empty($session->authenticated->until) && $session->authenticated->until <= date()){
                return self::redirectLogin($request, $next);
            }
            return $request->getPathInfo() == (getenv("APP_PREFIX") ?? "").'/login' ? redirect()->route('dashboard') : $next($request);
        }
        return self::redirectLogin($request, $next);
    }
    
    protected function redirectLogin($request, Closure $next){
        $session_whitelist = config("layout.session_whitelist");
        $path = explode("/", $request->getPathInfo());
        $path = array_filter($path, function($var){
            return !empty($var);
        });
        $path = implode("/", $path);
        if(getenv("APP_PREFIX"))
            $session_whitelist = array_map(function($a){
                return ((explode("/", getenv("APP_PREFIX"))[1]."/" ?? "").$a);
            }, $session_whitelist);

        if( !in_array($path , $session_whitelist ) )
            return redirect()->route('login');
        else
            return $next($request);
    }
}
