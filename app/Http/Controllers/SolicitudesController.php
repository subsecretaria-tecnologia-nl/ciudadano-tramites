<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

use App\Repositories\PortalsolicitudescatalogoRepositoryEloquent;
use App\Repositories\PortalcamporelationshipRepositoryEloquent;
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

class SolicitudesController extends Controller
{
  protected $solicitudes;
  protected $relationship;
  protected $tiposer;

  public function __construct(
    PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
    PortalcamporelationshipRepositoryEloquent $relationship,
    EgobiernotiposerviciosRepositoryEloquent $tiposer
    )
    {
      // $this->middleware('auth');
      $this->solicitudes = $solicitudes;
      $this->relationship= $relationship;
      $this->tiposer = $tiposer;
    }


  public function getTramites(){

    $tramits = $this->tiposer->where('id_gpm','>=', 1)->get();

    //$tmts->tramites
    $tmts = array();
    try{

      foreach ($tramits as $t) {
        $tmts []=array(
          'id_tramite'=> $t->Tipo_Code,
          'tramite' => $t->Tipo_Descripcion,
        );
      }

    }catch(\Exception $e){
      Log::info('Error Portal - ver Tramites: '.$e->getMessage());
    }

    return json_encode($tmts);
  }

  public function getCampos(Request $request){
    $id_tramite = $request->id_tramite;

    try{
      $campos = $this->relationship->where('tramite_id', $id_tramite)->get();

    }catch(\Exception $e){
      Log::info('Error Solicitud - getCampos '.$e->getMessage());
    }
    return json_encode($campos);
  }

}
