<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\TramitedetalleRepositoryEloquent;
use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalcamporelationshipRepositoryEloquent;


class TramitesController extends Controller
{
    protected $tramites;
    protected $solicitudes;
    protected $relationship;

    public function __construct(
      TramitedetalleRepositoryEloquent $tramites,
      PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
      PortalcamporelationshipRepositoryEloquent $relationship
      )
      {
        // $this->middleware('auth');
        $this->tramites = $tramites;
        $this->solicitudes = $solicitudes;
        $this->relationship= $relationship;
      }

    public function index ($type) {
    	set_layout_arg(["subtitle" => "Trámites: {$type}","fluid_container"=> true]);
    	return layout_view("tramites.index", [ "type" => $type ]);
    }

    public function new () {
    	set_layout_arg("subtitle", "Nuevo Trámite");
    	return layout_view("tramites.new");
    }

   /**
   * Lista de tramites
   *
   *	@return json lista de tramites con id
   */

    public function listaTramites(){

      $tramits = $this->relationship->get();

      return json_encode($tramits);
    }
    /**
    * Funcion para crear una nueva solicitud
    *
    *	@return json lista de tramites con id
    */
    public function crearSolicitud(Request $request) {

    }
}
