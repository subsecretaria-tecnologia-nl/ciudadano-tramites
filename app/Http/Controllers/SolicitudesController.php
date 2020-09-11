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
use App\Repositories\PortalcampotypeRepositoryEloquent;
use App\Repositories\PortalcampoRepositoryEloquent;


class SolicitudesController extends Controller
{
  protected $solicitudes;
  protected $relationship;
  protected $tiposer;
  protected $tipocampo;
  protected $campo;

  public function __construct(
    PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
    PortalcamporelationshipRepositoryEloquent $relationship,
    EgobiernotiposerviciosRepositoryEloquent $tiposer,
    PortalcampotypeRepositoryEloquent $tipocampo,
    PortalcampoRepositoryEloquent $campo
    )
    {
      // $this->middleware('auth');
      $this->solicitudes = $solicitudes;
      $this->relationship= $relationship;
      $this->tiposer = $tiposer;
      $this->tipocampo = $tipocampo;
      $this->campo = $campo;
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

    $campos_data = array();
    try{
      $campos = $this->relationship->where('tramite_id', $id_tramite)->get();
      //$campos = $this->relationship->where('tramite_id', 100)->get();

      foreach ($campos as $c) {
        $rel_id = $c->id;
        $campo_id = $c->campo_id;
        $tipo_id = $c->tipo_id;
        $caracteristicas = $c->caracteristicas;

        $type = $this->tipocampo->where('id', $tipo_id)->get();

        foreach ($type as $t) {
          $tipo = $t->descripcion;
        }

        $campos_get = $this->campo->where('id',$campo_id)->get();
        foreach ($campos_get as $cps) {
          $campo_name = $cps->descripcion;
        }

        $campos_data []=array(
          'relationship' => $rel_id,
          'tipo' => $tipo,
          'nombre' => $campo_name,
          'caracteristicas' => $caracteristicas
        );
      }

      //dd($campos_data);

    }catch(\Exception $e){
      Log::info('Error Solicitud - getCampos '.$e->getMessage());
    }
    return json_encode($campos_data);
  }

}
