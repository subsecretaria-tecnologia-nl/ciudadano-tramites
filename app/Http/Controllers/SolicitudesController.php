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

// agregar catalogos
  protected $catalogo_campos;
  protected $catalogo_type;

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

      // creamos los catalogos iniciales

      $this->loadInfo();


    }

  /*
   * getTramites() ESTE METODO REGRESA LOS TRAMITES CONFIGURADOS 
   * 
   * @params null 
   *
   *
   * @returns an json object
   */

  public function loadInfo()
  {

    $c_campos = array();

    $campos = $this->campo->all();

    foreach($campos as $c)
    {
      $c_campos [$c->id]= $c->descripcion;
    }

    $this->catalogo_campos = $c_campos;

    $c_type = array();

    $type = $this->tipocampo->all();

    foreach($type as $t)
    {
      $c_type [$t->id]= $t->descripcion;
    }
    
    $this->catalogo_type = $c_type;

  }


  /*
   * getTramites() ESTE METODO REGRESA LOS TRAMITES CONFIGURADOS 
   * 
   * @params null 
   *
   *
   * @returns an json object
   */

  public function getTramites(){

    $tramites = $this->relationship->all();

    $t = array();
    
    // obtengo los tramites configurados
    foreach ($tramites as $k) {
      # checar los que no tenemos
      if( !in_array((int)$k->tramite_id, $t) )
      {
        $t[] = (int)$k->tramite_id;
      }
    }

    // obtengo la descripcion y id de los tramites
    $servicios = $this->tiposer->findWhereIn('Tipo_Code',$t);
    
    $tmts = array();

    foreach($servicios as $s)
    {
      $tmts []=array(
          'id_tramite'=> $s->Tipo_Code,
          'tramite' => $s->Tipo_Descripcion,
        );
    }

    return json_encode($tmts);
    
  }

  /*
   * getCampos() ESTE METODO REGRESA LOS CAMPOS CONFIGURADOS EN EL TRAMITE
   * 
   * @params id_tramite 
   *
   *
   * @returns an json object
   */

  public function getCampos(Request $request){
    
    $id_tramite = $request->id_tramite;

    //dd($id_tramite,$this->catalogo_campos,$this->catalogo_type);
    
    $campos_data = array();
    
    try{
      $campos = $this->relationship->findWhere( ['tramite_id' => $id_tramite] );
      //$campos = $this->relationship->where('tramite_id', 100)->get();

      foreach ($campos as $c) {

        $campos_data []=array(
          'relationship' => $c->id,
          'tipo' => $this->catalogo_type[$c->tipo_id],
          'nombre' => $this->catalogo_campos[$c->campo_id],
          'caracteristicas' => $c->caracteristicas,
        );
      }

      //dd($campos_data);

    }catch(\Exception $e){
      Log::info('Error Solicitud - getCampos '.$e->getMessage());
    }

    
    return json_encode($campos_data);
  }

}
