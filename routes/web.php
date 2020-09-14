<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

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

//Route::middleware(["validate_session"])->group(function(){
	Route::get('/', function () {
		return redirect("/dashboard");
	});
	Route::get('/nuevo-tramite', "TramitesController@new");
	Route::get('/dashboard', "DashboardController@index");
	Route::get('/tramites/{type}', "TramitesController@index");
	
	Route::get('/getTramites', 'TramitesController@listaTramites');

	// LOGIN
	Route::get('/login', "LoginController@index");
	Route::post('/login', "LoginController@validation");
	Route::get('/logout', "LoginController@logout");

	//Solicitudes
	Route::get('/allTramites', 'SolicitudesController@getTramites');
	Route::get('/getCampos', 'SolicitudesController@getCampos');

//});
