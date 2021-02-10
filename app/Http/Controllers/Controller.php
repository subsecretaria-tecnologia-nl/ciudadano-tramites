<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Notifications;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $notifications;
    
    function __construct(){
    	$this->notifications = Notifications::where(["closed_at" => null])
    	->orderBy('created_at', 'desc')
    	->get();
    	\Config::set('layout.args.notifications.total', $this->notifications->count());
    	$notifications = [];
        $notificacion_count = 0;
        $aviso_count = 0;
    	foreach($this->notifications->toArray() as $notification){
            if($notification['type_id'] == 1)
                $notificacion_count++;
            else
                $aviso_count++;

    		$notification['type'] = $notification['type_id'] == 1 ? 'notificacion' : 'aviso';
            if(!isset($notifications[$notification['type']]))
                $notifications[$notification['type']] = [];
    		array_push($notifications[$notification['type']], $notification);
    	}

        \Config::set('layout.args.notifications.items', $notifications);
        \Config::set('layout.args.notifications.notificacion_count', $notificacion_count);
    	\Config::set('layout.args.notifications.aviso_count', $aviso_count);
    }
}
