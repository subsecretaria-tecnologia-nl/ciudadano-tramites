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
        if(!$session) return $next($request);
        
        $path = explode("/", $request->getPathInfo());
        $path = array_filter($path, function($var){
            return !empty($var);
        });
        $path = implode("/", $path);
        if(!isset($session->role) && preg_match("/logout/", $path) == 0) return redirect((getenv("APP_PREFIX") ?? "") ."/logout");
        if(preg_match("/logout/", $path)) return $next($request);

        // $validator = [
        //     "notary_titular" => ["*"],
        //     "notary_substitute" => ["*"],
        //     "notary_capturist" => ["/getTramites", "/allTramites", "/getCampos", "/crearSolicitud", "/getcostoTramite", "/detalle-tramite", "/cart", "/", "/dashboard", "/perfil" , "/tramites", "/informacion-cuenta" , "/cambiar-contraseña", "/logout", "/nuevo-tramite", "/detalle-tramite/(.+)" ],
        //     "notary_payments" => ["/getTramites", "/allTramites", "/getCampos", "/crearSolicitud", "/getcostoTramite", "/detalle-tramite", "/cart", "/", "/dashboard", "/perfil" ,  "/informacion-cuenta" , "/cambiar-contraseña", "/tramites/por-pagar", "/logout"]
        // ];

        $session_whitelist = $session->role->paths ? explode('|', $session->role->paths) : ["*"];
        $session_disabled = $session->role->paths_disabled ? explode('|', $session->role->paths_disabled) : [];
        $pass = array_map(function($a) use ($path, $session_disabled){
            if($a == "*") return $a;
            $whitePath = ((getenv("APP_PREFIX") ? explode("/", getenv("APP_PREFIX"))[1]."" : "").$a);
            if(substr($whitePath, -1) == "/") $whitePath = substr($whitePath, 0, -1);
            if(substr($whitePath, 0, 1) == "/") $whitePath = substr($whitePath, 1);
            preg_match("/^".str_replace("/", "\/", $whitePath)."$/", $path, $matches);

            foreach($session_disabled as $disabled_path){
                preg_match("/^".str_replace("/", "\/", $disabled_path)."$/", $path, $matchesDisabled);
                if($matchesDisabled) $matches[] = $matchesDisabled;
            }
            if(!empty($matches) && empty($matchesDisabled)) return $a;
        }, $session_whitelist);
        $pass = array_filter($pass);

        if(empty($pass)) return abort(403);
        else return $next($request);
    }
}
