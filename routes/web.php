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

Route::get("/", function(){
	return redirect()->route("dashboard");
});

Route::group(["prefix" => getenv("APP_PREFIX") ?? "/"], function(){
	Route::middleware(["validate_session"])->group(function(){
		Route::get('/', function () {
			return redirect()->route("dashboard");
		});
		Route::get('/dashboard', "DashboardController@index")->name("dashboard");
		Route::get('/tramites/{type}', "TramitesController@index");
		Route::get('/nuevo-tramite', "TramitesController@new");
		Route::get('/perfil',  "AcountInfoController@index");
		Route::get('/informacion-cuenta', "ProfileController@index");
		Route::get('/cambiar-contraseña', "changePassword@index");
		Route::get('/usuarios', "UsersController@index");
		
		// LOGIN
		Route::get('/login', "LoginController@index")->name("login");
		Route::post('/login', "LoginController@validation");
		Route::get('/logout', "LoginController@logout");
		Route::get('/password/recovery', "RecoveryController@index");
		Route::get('/password/recovery/{token}', [ConfirmPasswordController::class,'index'], function($token){
				return $token;
		});
	});
});

