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
        // dd($session);
        if(!empty($session->authenticated)){
            if(!empty($session->authenticated->until) && $session->authenticated->until <= date()){
                return self::redirectLogin($request, $next);
            }
            return $next($request);
        }
        return self::redirectLogin($request, $next);
    }
    
    protected function redirectLogin($request, Closure $next){
        
        $session_whitelist = config("layout.session_whitelist");
        if( in_array($request->getPathInfo() , $session_whitelist ) )
            return redirect("/login");
        else
            return $next($request);
    }
}
