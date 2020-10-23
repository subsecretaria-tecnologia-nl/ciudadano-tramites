<?php

namespace App\Http\Middleware;

use Closure;

class RolValidator
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
        $validator = [
            "notary_titular" => [ "/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña", "/usuarios"],
            "notary_substitute" => [ "/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña", "/usuarios"],
            "notary_capturist" => ["/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña"],
            "notary_payments" => [ "/perfil" ,  "/informacion-cuenta" , "/cambiar-contraseña"]
        ];

        // dd($request->getPathInfo());
        $session = to_object(session()->get("user"));
        if(!empty($session->role_name)){
            if (!empty($session) && isset($validator[$session->role_name]) ) {
                if( in_array($request->getPathInfo()  ,$validator[$session->role_name])  ){
                    return $next($request);
                }else{
                    return abort(403);    
                };
            }else{
                 return abort(403);
            }
        }else{
            return $next($request);
        }
    }
}
