<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
		set_layout_arg(["subtitle" => "Dashboard" ,
        "fluid_container"=> true
        ]);
    	return layout_view("dashboard");
    }
}
