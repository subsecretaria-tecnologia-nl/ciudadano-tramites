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
            "notary_titular" => ["/", "/dashboard", "/perfil" , "/tramites", "/tramites/pendientes",  "/informacion-cuenta" , "/cambiar-contraseña", "/usuarios", "/logout", "/nuevo-tramite" ],
            "notary_substitute" => ["/", "/dashboard", "/perfil" , "/tramites", "/tramites/pendientes", "/informacion-cuenta" , "/cambiar-contraseña", "/usuarios", "/logout", "/nuevo-tramite" ],
            "notary_capturist" => ["/", "/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña", "/logout", "/nuevo-tramite" ],
            "notary_payments" => ["/", "/dashboard", "/perfil" ,  "/informacion-cuenta" , "/cambiar-contraseña", "/tramites/por-pagar", "/logout"]
        ];

        foreach($validator as $key => $val){
            foreach($val as $k => $route){
                $validator[$key][$k] = getenv("APP_PREFIX")??"".$val;
            }
        }

        $session = to_object(session()->get("user"));
        if(!empty($session->role_name)){
            if (!empty($session) && isset($validator[$session->role_name]) ) {
                if( in_array($request->getPathInfo(), $validator[$session->role_name])  ){
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
