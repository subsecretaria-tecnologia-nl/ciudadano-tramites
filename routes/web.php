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
		})->name("home");
		Route::get('/dashboard', "DashboardController@index")->name("dashboard");
		Route::get('/tramites/{type}', "TramitesController@index")->name("tramites");
		Route::get('/nuevo-tramite', "TramitesController@new")->name("tramite.nuevo");
		Route::get('/perfil',  "AcountInfoController@index")->name("perfil");
		Route::get('/informacion-cuenta', "ProfileController@index")->name("informacion-cuenta");
		Route::get('/cambiar-contraseña', "changePassword@index")->name("cambiar-contraseña");
		Route::get('/usuarios', "UsersController@index")->name("usuarios");

		// LOGIN
		Route::get('/login', "LoginController@index")->name("login");
		Route::post('/login', "LoginController@validation");
		Route::get('/logout', "LoginController@logout")->name("logout");
		Route::get('/password/recovery', "RecoveryController@index")->name("password/recovery");
		Route::get('/password/recovery/{token}', [ConfirmPasswordController::class,'index'], function($token){
			return $token;
		})->name('/password/recovery/{token}');

		Route::get('/getTramites', 'TramitesController@listaTramites')->name("getTramites");

		//Solicitudes
		Route::get('/allTramites', 'SolicitudesController@getTramites')->name("allTramites");
		Route::get('/getCampos', 'SolicitudesController@getCampos')->name("getCampos");
		Route::post('/crearSolicitud', 'TramitesController@crearSolicitud');

		Route::post('/getcostoTramite', 'TramitesController@getcostoTramite')->name("costo-tramite");

		Route::get('/detalle-tramite/{idTramite}', "TramitesController@detalle")->name("tramite.detalle");
 
});
