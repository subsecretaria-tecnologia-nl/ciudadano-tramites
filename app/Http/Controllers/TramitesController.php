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
use App\Repositories\EgobiernotiposerviciosRepositoryEloquent;

use App\Repositories\PortalcostotramitesRepositoryEloquent;
use App\Repositories\PortalsubsidiotramitesRepositoryEloquent;
use App\Repositories\PortalumaRepositoryEloquent;


class TramitesController extends Controller
{
    protected $tramites;
    protected $solicitudes;
    protected $relationship;
    protected $tiposer;
    protected $costotramites;
    protected $subsidiotramites;
    protected $uma;

    public function __construct(
      TramitedetalleRepositoryEloquent $tramites,
      PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
      PortalcamporelationshipRepositoryEloquent $relationship,
      EgobiernotiposerviciosRepositoryEloquent $tiposer,
      PortalcostotramitesRepositoryEloquent $costotramites,
      PortalsubsidiotramitesRepositoryEloquent $subsidiotramites,
      PortalumaRepositoryEloquent $uma
      )
      {
        // $this->middleware('auth');
        $this->tramites = $tramites;
        $this->solicitudes = $solicitudes;
        $this->relationship= $relationship;
        $this->tiposer = $tiposer;
        $this->costotramites = $costotramites;
        $this->subsidiotramites = $subsidiotramites;
        $this->uma = $uma;
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
      //dd($tramits);
      $tmts = array();

      foreach ($tramits as $t) {
        $id_tramite = $t->tramite_id;
        $created_at = $t->created_at;
        $updated_at = $t->updated_at;

        $serv = $this->tiposer->where('Tipo_Code', $id_tramite)->get();
        foreach ($serv as $s) {
          $name = $s->Tipo_Descripcion;

          $tmts []=array(
            'id_tramite' => $id_tramite,
            'nombre' => $name,
            'created_at' => $created_at,
            'updated_at' => $updated_at
          );

        }
      }

      //dd($tmts);

      return json_encode($tmts);
    }

    /**
    * Funcion para crear una nueva solicitud
    *
    *	@return json lista de tramites con id
    */
    public function crearSolicitud(Request $request) {
      $data = $request->tramite_id;
      $user_id = 1;

      try{

      }catch(\Exception $e){
        Log::info('Error - crear Solicitud: '.$e->getMessage());
      }


    }

    /**
    * Funcion para traer el costo de un trámite
    *
    *	@return json costo e informacion del trámite
    */
    public function getcostoTramite(Request $request) {

      $tramite_id = $request->tramite_id;
      //$tramite_id = 102;
      $dt = date("Y");

      //datos para el tramite
      $valor_catastral = $request->valor_catastral;
      //$valor_catastral = 15005;
      //$valor_operacion = 2500000;
      $valor_operacion = $request->valor_operacion;
      $lotes = $request->lotes;
      $hojas =  $request->hojas;

      $data_uma = $this->uma->where('year', $dt)->get();
      foreach ($data_uma as $val) {
        $actual_uma = $val->daily;
      }

      //Informacion del costo y reglas del trámite
      $data_costo = $this->costotramites->where('tramite_id', $tramite_id)->where('status', 1)->get();
      foreach($data_costo as $data){
        $tipo = $data->tipo;
        $costoX = $data->costo;
        $min = $data->minimo;
        $max = $data->maximo;
        $valor = $data->valor;
        $status = $data->status;
      }

      //dd($costoMax);
      try{
        if ($tipo == "F"){
          if($costoX == "N"){ //N para cuando no aplica en un pago Fijo
            $costo_real = $actual_uma * $min;

            $costo_final = $this->redondeo($costo_real);
            //dd($costo_final);
            return json_encode($costo_final);
          }
          elseif ($costoX == "L") { //costo x lote
            $costo_real = $actual_uma * $valor;
            $primer_costo = $this->redondeo($costo_real);

            if (!empty($lotes)){
              $costoxlote = $primer_costo * $lotes;

              if($costoxlote < $primer_costo){
                $costo_final = $primer_costo;
              }else{
                $costo_final = $costoxlote;
              }
            }else{
              $costo_final = $primer_costo;
            }

            return json_encode($costo_final);
          }
        }elseif ($tipo == "V") {
          //Se calculan los valores minimos y máximos del trámite
          $costoMinimo = $min * $actual_uma;
          $costoMin = $this->redondeo($costoMinimo);

          $costoMaximo = $max * $actual_uma;
          $costoMax = $this->redondeo($costoMaximo);

          if( $valor_catastral > $valor_operacion){
            $operacion = $valor_catastral;
          }else{
            $operacion = $valor_operacion;
          }

          $precio = ($operacion * $valor) / 1000;

          $precioRedondeo = $this->redondeo($precio);

          if ($precioRedondeo < $costoMin ){
            $costo_final = $costoMin;
          }elseif ($precioRedondeo > $costoMax) {
            $costo_final = $costoMax;
          }else{
            $costo_final = $precioRedondeo;
          }
          return json_encode($costo_final);

        }
      }catch(\Exception $e){
        Log::info('Error - costo Trámite: '.$e->getMessage());
      }
    }

    public function redondeo($costo_real){
      //Redondeo
      $exacto = floor($costo_real);

      $dec = $costo_real - $exacto;

      if($dec <= "0.50"){
        $costo_real = floor($costo_real);
      }else{
        $costo_real = $exacto + 1;
      }

      return $costo_real;
    }

}
