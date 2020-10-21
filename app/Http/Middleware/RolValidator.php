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
            "notary_titular" => [ "dashboard", "perfil" , "tramites", "informacion-cuenta" , "cambiar-contraseña", "usuarios"],
            "notary_capturist" => ["dashboard", "perfil" , "tramites", "informacion-cuenta" , "cambiar-contraseña"]

        ];

        $session = to_object(session()->get("user"));
        if( !empty($session) && $session->role_id  )
        return $next($request);
    }
}
