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
    	foreach($this->notifications->toArray() as $notification){
    		$notification['type'] = $notification['type_id'] == 1 ? 'notificacion' : 'aviso interno';
    		array_push($notifications, $notification);
    	}

    	\Config::set('layout.args.notifications.items', $notifications);
    }
}
