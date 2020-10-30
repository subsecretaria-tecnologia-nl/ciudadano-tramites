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
        $session = to_object(session()->get("user"));
        $validator = [
            "notary_titular" => ["*"],
            "notary_substitute" => ["*"],
            "notary_capturist" => ["/getTramites", "/allTramites", "/getCampos", "/crearSolicitud", "/getcostoTramite", "/detalle-tramite", "/carshop", "/", "/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña", "/logout", "/nuevo-tramite", "/detalle-tramite/(.+)" ],
            "notary_payments" => ["/getTramites", "/allTramites", "/getCampos", "/crearSolicitud", "/getcostoTramite", "/detalle-tramite", "/carshop", "/", "/dashboard", "/perfil" ,  "/informacion-cuenta" , "/cambiar-contraseña", "/tramites/por-pagar", "/logout"]
        ];

        $session_whitelist = $validator;
        $path = explode("/", $request->getPathInfo());
        $path = array_filter($path, function($var){
            return !empty($var);
        });
        $path = implode("/", $path);

        $pass = array_map(function($a) use ($path){
            if($a == "*") return $a;
            $whitePath = ((getenv("APP_PREFIX") ? explode("/", getenv("APP_PREFIX"))[1]."" : "").$a);
            preg_match("/^".str_replace("/", "\/", $whitePath)."$/", $path, $matches);
            if(!empty($matches))
                return $a;
        }, $session_whitelist[$session->role_name]);
        $pass = array_filter($pass);

        if(empty($pass))
            return abort(403);
        else
            return $next($request);
    }
}
