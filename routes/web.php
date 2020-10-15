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

// Route::middleware(["validate_session"])->group(function(){
	Route::get('/', function () {
		return redirect("/dashboard");
	});
	Route::get('/dashboard', "DashboardController@index");
	Route::get('/tramites/{type}', "TramitesController@index");

	Route::get('/getTramites', 'TramitesController@listaTramites');

	Route::get('/nuevo-tramite', "TramitesController@new");

	Route::get('/perfil', "ProfileController@index");
	Route::get('/informacion-cuenta', "AcountInfoController@index");
	Route::get('/cambiar-contraseña', "changePassword@index");
	Route::get('/usuarios', "UsersController@index");

	// LOGIN
	Route::get('/login', "LoginController@index");
	Route::post('/login', "LoginController@validation");
	Route::get('/logout', "LoginController@logout");
	Route::get('/password/recovery', "RecoveryController@index");
	Route::get('/password/recovery/{token}', [ConfirmPasswordController::class,'index'], function($token){
			return $token;
	});

	//Solicitudes
	Route::get('/allTramites', 'SolicitudesController@getTramites');
	Route::get('/getCampos', 'SolicitudesController@getCampos');
	Route::post('/crearSolicitud', 'TramitesController@crearSolicitud');

	Route::post('/getcostoTramite', 'TramitesController@getcostoTramite');
// });
