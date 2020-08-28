<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
    	set_layout_arg("subtitle", "Dashboard");
    	return layout_view("welcome", [ "hello" => "world" ]);
    }
}
