<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(["validate_session"])->group(function(){
	Route::get('/', function () {
		return redirect("/dashboard");
	});
	Route::get('/dashboard', "DashboardController@index");
	Route::get('/tramites/{type}', "TramitesController@index");
	Route::get('/nuevo-tramite', "TramitesController@new");
	
	// LOGIN
	Route::get('/login', "LoginController@index");
	Route::post('/login', "LoginController@validation");
	Route::get('/logout', "LoginController@logout");
	Route::get('/recovery-password', "RecoveryController@index");
	Route::get('/recovery-password/{token}', [ConfirmPasswordController::class,'index'], function($token){
			return $token;
	});
});

