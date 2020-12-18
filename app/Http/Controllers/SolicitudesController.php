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

use App\Repositories\EgobiernopartidasRepositoryEloquent;
//use App\Repositories\PortalreglaoperativaRepositoryEloquent;
use App\Repositories\PortalcostotramitesRepositoryEloquent;
use App\Repositories\PortalcamposagrupacionesRepositoryEloquent;

use App\Repositories\PortaltramitecategoriaRepositoryEloquent;
use App\Repositories\PortaltramitecategoriarelacionRepositoryEloquent;

class SolicitudesController extends Controller
{
  protected $solicitudes;
  protected $relationship;
  protected $tiposer;
  protected $tipocampo;
  protected $campo;
  protected $partidas;
  protected $costo;
  protected $cat_tramite;
  protected $relcat;

// agregar catalogos
  protected $catalogo_campos;
  protected $catalogo_type;
  protected $group;

  public function __construct(
    PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
    PortalcamporelationshipRepositoryEloquent $relationship,
    EgobiernotiposerviciosRepositoryEloquent $tiposer,
    PortalcampotypeRepositoryEloquent $tipocampo,
    PortalcampoRepositoryEloquent $campo,
    EgobiernopartidasRepositoryEloquent $partidas,
    PortalcostotramitesRepositoryEloquent $costo,
    PortalcamposagrupacionesRepositoryEloquent $group,
    PortaltramitecategoriaRepositoryEloquent $cat_tramite,
    PortaltramitecategoriarelacionRepositoryEloquent $relcat
    )
    {
      parent::__construct();
      // $this->middleware('auth');
      $this->solicitudes = $solicitudes;

      $this->relationship= $relationship;

      $this->tiposer = $tiposer;

      $this->tipocampo = $tipocampo;

      $this->campo = $campo;

      $this->partidas = $partidas;

      $this->costo = $costo;

      $this->group = $group;

      $this->cat_tramite = $cat_tramite;

      $this->relcat = $relcat;

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

    $cost = $this->costo->all();

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
      $category = $this->relcat->findWhere(['tramite_id'=> $s->Tipo_Code] );

      $tmts []=array(
          'id_tramite'=> $s->Tipo_Code,
          'tramite' => $s->Tipo_Descripcion,
          'partidas' => $this->getPartidasTramites($s->Tipo_Code), // aqui mando los datos de la partida
          'category' => $this->getCategoryTramite($s->Tipo_Code),
        );
    }

    return json_encode($tmts);

  }

  function getCategoryTramite($id){
    $data = array();
    try{

      $info = $this->relcat->findWhere( ["tramite_id" =>  $id] );

      if($info->count() > 0){
        foreach($info as $i)
        {
          $cat_data = $this->cat_tramite->findWhere(["id" => $i->categorias_id]);
          foreach ($cat_data as $cats) {
            $name = $cats->descripcion;
          }
          $data []= array(
            "categorias_id"  => $i->categorias_id,
            "nombre_categoria" => $name
          );
        }
      }else{
        $data = 0;
      }

    }catch(\Exception $e){
      Log::info('Error getCategoryTramite '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al getCategoryTramite",
        ]
      );
    }

    return $data;
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

        $grupo = $this->group->findWhere(['id' => $c->agrupacion_id]);

        foreach ($grupo as $g) {
          $desc = $g->descripcion;
        }

          $campos_data []=array(
            'relationship' => $c->id,
            'tipo' => $this->catalogo_type[$c->tipo_id],
            'nombre' => $this->catalogo_campos[$c->campo_id],
            'caracteristicas' => $c->caracteristicas,
            'campo_id' => $c->campo_id,
            'agrupacion_id' => $c->agrupacion_id,
            'orden'=> $c->orden,
            'nombre_agrupacion' => $desc,
          );


      }
      $data = array();

      if ($id_tramite == 516 ) {

        $data [] = array(
          "campos_data" => $campos_data,
          "consulta_api" => "/getcostoImpuesto"
        );
      }elseif($id_tramite == 399){
        $data [] = array(
          "campos_data" => $campos_data,
          "consulta_api" => "/getcostoImpuesto"
        );
      }else{
        $data [] = array(
          "campos_data" => $campos_data,
          "consulta_api" => "/getcostoTramite"
        );
      }


    }catch(\Exception $e){
      Log::info('Error Solicitud - getCampos '.$e->getMessage());
    }


    return json_encode($data);
  }

  /**
   *
   * getPartidasTramites . Busca en la tabla de partidas los valores
   *
   * @param $id es el valor del tramite
   *
   * @return Array con los valores de la partida
   *
   */

  public function getPartidasTramites($id)
  {
    $data = array();
    try{

      $info = $this->partidas->findWhere( ["id_servicio" =>  $id] );

      if($info->count() > 0){
        foreach($info as $i)
        {
          $data []= array(
            "id_partida"  => $i->id_partida,
            "descripcion" => $i->descripcion
          );
        }
      }else{
        $data = 0;
      }

    }catch(\Exception $e){
      Log::info('Error Eliminar Solicitud '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al getPartidasTramites",
        ]
      );
    }

    return $data;

  }

  public function allCategories (){
    try{
      $cats = $this->cat_tramite->get();

      return json_encode($cats);

    }catch(\Exception $e){
      Log::info('Error allCategories '.$e->getMessage());
      return response()->json(
        [
          "Code" => "400",
          "Message" => "Error al listar categorias",
        ]
      );
    }
  }
}
