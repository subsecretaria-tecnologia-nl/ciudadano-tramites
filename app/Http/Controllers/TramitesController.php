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
use App\Repositories\EgobiernopartidasRepositoryEloquent;
use App\Repositories\PortalcamposagrupacionesRepositoryEloquent;

use App\Repositories\PortalcostotramitesRepositoryEloquent;
use App\Repositories\PortalsubsidiotramitesRepositoryEloquent;
use App\Repositories\PortalumaRepositoryEloquent;
use Illuminate\Support\Facades\Http;

class TramitesController extends Controller
{
    protected $tramites;
    protected $solicitudes;
    protected $relationship;
    protected $tiposer;
    protected $costotramites;
    protected $subsidiotramites;
    protected $uma;
    protected $partidas;
    protected $group;

    public function __construct(
      TramitedetalleRepositoryEloquent $tramites,
      PortalsolicitudescatalogoRepositoryEloquent $solicitudes,
      PortalcamporelationshipRepositoryEloquent $relationship,
      EgobiernotiposerviciosRepositoryEloquent $tiposer,
      PortalcostotramitesRepositoryEloquent $costotramites,
      PortalsubsidiotramitesRepositoryEloquent $subsidiotramites,
      PortalumaRepositoryEloquent $uma,
      EgobiernopartidasRepositoryEloquent $partidas,
      PortalcamposagrupacionesRepositoryEloquent $group
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
        $this->partidas = $partidas;
        $this->group = $group;
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
      //$tramite_id = 100;
      $dt = date("Y");

      //datos para el tramite
      $valor_catastral = $request->valor_catastral;
      //$valor_catastral = 150050;
      //$valor_operacion = 178960;
      $valor_operacion = $request->valor_operacion;
      $lotes = $request->lote;
      $hojas =  $request->hoja;
      //$hojas = 5;
      $data_uma = $this->uma->where('year', $dt)->get();
      foreach ($data_uma as $val) {
        $actual_uma = $val->daily;
      }

      //Informacion del costo y reglas del trámite
      $data_costo = $this->costotramites->where('tramite_id', $tramite_id)->where('status', 1)->get();
      foreach($data_costo as $data){
        $tipo = $data->tipo;
        $costoX = $data->costo;
        $costo_fijo = $data->costo_fijo;
        $tipo_costo_fijo = $data->tipo_costo_fijo;
        $min = $data->minimo;
        $max = $data->maximo;
        $valor = $data->valor;
        $vigencia = $data->vigencia;
        $status = $data->status;
      }
      $detalle = array();
      //Validamos si el tramite tiene subsidio
      $subsidio_data = $this->subsidiotramites->where('tramite_id', $tramite_id)->get();
      foreach ($subsidio_data as $sub) {
        $cuotas_sub = $sub->cuotas;
        $limite_cuotassub = $sub->limite_cuotas;
        $id_partida = $sub->id_partida;
        $oficio_sub = $sub->oficio;
      }

      if (!empty($oficio_sub)){
        try{
          $data_partida = $this->partidas->where('id_partida', $id_partida)->get();
          foreach ($data_partida as $p) {
            $id_servicio = $p->id_servicio;
            $descripcion_part = $p->descripcion;
          }

          $subsidio = $request->subsidio; //se obtiene el oficio ingresado
          //$subsidio = "";

          if($subsidio == $oficio_sub) { //se valida que coincida el oficio ingresado con el registro
            //Se calculan minimos y maximos en base a cuotas establecidas
            $sub_costoMinimo = $cuotas_sub * $actual_uma;
            $sub_costoMin = $this->redondeo($sub_costoMinimo);

            $sub_costoMaximo = $limite_cuotassub * $actual_uma;
            $sub_costoMax = $this->redondeo($sub_costoMaximo);

            $descuentos = array();
            //Se hace el calculo del costo normal en base a sus cuotas establecidas
            if ($tipo == "F"){
              if($tipo_costo_fijo == "P"){ // costo fijo en pesos
                $costo_final = $costo_fijo;
              }
              else{ //C Para cuando el costo fijo es calculado en cuotas
                $costo_real = $actual_uma * $costo_fijo;
                $costo_final = $this->redondeo($costo_real);
              }

              //Se hace la validacion si aplica o no el subsidio para costos fijos
              if ($costo_final < $sub_costoMin){
                $costo_total = $costo_total;
                $costo_final = $sub_costoMin;
                $total_subsidiado = $costo_total - $costo_final;
                $descuentos []= array(
                  'concepto_descuento' => $descripcion_part,
                  'importe_subsidio' => $total_subsidiado,
                  'partida_descuento' => $id_partida
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'importe_total' => $costo_total,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );
                return json_encode($detalle);

              }elseif($costo_final > $sub_costoMax){
                $descuentos []= array(
                  'concepto_descuento' => 'No aplica',
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );
                return json_encode($detalle);
              }else{
                $costo_total = $costo_final;
                $costo_final = $sub_costoMin;
                $total_subsidiado = $costo_total - $costo_final;

                $descuentos []= array(
                  'concepto_descuento' => $descripcion_part,
                  'importe_concepto' => $sub_costoMin,
                  'partida_descuento' => $id_partida
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $sub_costoMin,
                  'descuentos' => $descuentos,
                );
                return json_encode($detalle);
              }
            }
            elseif ($tipo == "V") {
              if($costoX == "L") { //costo x lote
                $costo_real = $actual_uma * $valor;
                $primer_costo = $this->redondeo($costo_real);

                if (!empty($lotes)){
                  $costoxlote = $primer_costo * $lotes;
                  $costoMinimo = $min * $actual_uma;
                  $costoMin = $this->redondeo($costoMinimo);

                  $costoMaximo = $max * $actual_uma;
                  $costoMax = $this->redondeo($costoMaximo);

                  if($costoxlote < $costoMinimo){
                    $costo_final = $costoMinimo;
                  }elseif($costoxlote > $costoMax){
                    $costo_final = $costoMax;
                  }else{
                    $costo_final = $costoxlote;
                  }
                }else{
                  $costo_final = $primer_costo;
                }
              }
              elseif ($costoX == "H") { // costo x hojas
                if(!empty($valor)){
                  $costo_real = $actual_uma;
                }else{
                  $costo_real = $actual_uma * $valor;
                }
                $primer_costo = $this->redondeo($costo_real);

                if (!empty($hojas)){
                  $costoxhoja = $primer_costo * $hojas;

                  $costoMinimo = $min * $actual_uma;
                  $costoMin = $this->redondeo($costoMinimo);

                  $costoMaximo = $max * $actual_uma;
                  $costoMax = $this->redondeo($costoMaximo);
                  if($costoxhoja < $costoMinimo){
                    $costo_final = $costoMinimo;
                  }elseif($costoxhoja > $costoMax){
                    $costo_final = $costoMax;
                  }else{
                    $costo_final = $this->redondeo($costoxhoja);
                  }
                }else{

                  $costo_final = $primer_costo;
                }
              }
              else{ //costo x Millar
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
              }

              //Se hace la validacion si aplica o no el subsidio para costos variables
              if ($costo_final < $sub_costoMin){
                $costo_total = $costo_final;
                $costo_final = $sub_costoMin;

                $total_subsidiado = $costo_total - $costo_final;

                $descuentos []= array(
                  'concepto_descuento' => $descripcion_part,
                  'importe_concepto' => $total_subsidiado,
                  'partida_descuento' => $id_partida
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'importe_total' => $costo_total,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );
                //dd($detalle);
                return json_encode($detalle);

              }elseif($costo_final > $sub_costoMax){
                $descuentos []= array(
                  'concepto_descuento' => 'No aplica',
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );
                return json_encode($detalle);
              }else{
                $costo_total = $costo_final;
                $costo_final = $sub_costoMin;
                $total_subsidiado = $costo_total - $costo_final;
                $descuentos []= array(
                  'concepto_descuento' => $descripcion_part,
                  'importe_subsidio' => $total_subsidiado,
                  'partida_descuento' => $id_partida
                );
                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'importe_total' => $costo_total,
                  'costo_final' => $sub_costoMin,
                  'descuentos' => $descuentos,
                );

                return json_encode($detalle);
              }
              $detalle []= array(
                'tramite_id' => $tramite_id,
                'costo_final' => $costo_final,
              );
              return json_encode($detalle);

            }


          }else{ //si no coincide el registro del oficio se notifica al usuario y se hace el calculo normal
            $descuentos []= array(
              'concepto_descuento' => 'El numero de oficio no coincide con el trámite',
            );
            if ($tipo == "F"){
              if($tipo_costo_fijo == "P"){ // costo fijo en pesos
                $costo_final = $costo_fijo;
              }else{ //C Para cuando el costo fijo es calculado en cuotas
                $costo_real = $actual_uma * $costo_fijo;
                $costo_final = $this->redondeo($costo_real);
              }
              $detalle []= array(
                'tramite_id' => $tramite_id,
                'costo_final' => $costo_final,
                'descuentos' => $descuentos,
              );

              return json_encode($detalle);
            }
            elseif ($tipo == "V") {
              if($costoX == "L") { //costo x lote
                $costo_real = $actual_uma * $valor;
                $primer_costo = $this->redondeo($costo_real);

                if (!empty($lotes)){
                  $costoxlote = $primer_costo * $lotes;
                  $costoMinimo = $min * $actual_uma;
                  $costoMin = $this->redondeo($costoMinimo);

                  $costoMaximo = $max * $actual_uma;
                  $costoMax = $this->redondeo($costoMaximo);

                  if($costoxlote < $costoMinimo){
                    $costo_final = $costoMinimo;
                  }elseif($costoxlote > $costoMax){
                    $costo_final = $costoMax;
                  }else{
                    $costo_final = $this->redondeo($costoxlote);
                  }
                }else{
                  $costo_final = $primer_costo;
                }

                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );

                return json_encode($detalle);
              }
              elseif ($costoX == "H") { // costo x hojas
                if(!empty($valor)){
                  $costo_real = $actual_uma;
                }else{
                  $costo_real = $actual_uma * $valor;
                }
                $primer_costo = $this->redondeo($costo_real);

                if (!empty($hojas)){
                  $costoxhoja = $primer_costo * $hojas;

                  $costoMinimo = $min * $actual_uma;
                  $costoMin = $this->redondeo($costoMinimo);

                  $costoMaximo = $max * $actual_uma;
                  $costoMax = $this->redondeo($costoMaximo);
                  if($costoxhoja < $costoMinimo){
                    $costo_final = $costoMinimo;
                  }elseif($costoxhoja > $costoMax){
                    $costo_final = $costoMax;
                  }else{
                    $costo_final = $this->redondeo($costoxhoja);
                  }
                }else{
                  $costo_final = $primer_costo;
                }

                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );

                return json_encode($detalle);
              }
              else{ //costo x Millar
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

                $detalle []= array(
                  'tramite_id' => $tramite_id,
                  'costo_final' => $costo_final,
                  'descuentos' => $descuentos,
                );
                return json_encode($detalle);
              }
            }

          }
        }catch(\Exception $e){
          Log::info('Error - costo Trámite: '.$e->getMessage());
        }
      }else{
        try{

          if ($tipo == "F"){
            if($tipo_costo_fijo == "P"){ // costo fijo en pesos
              $costo_final = $costo_fijo;
            }else{ //C Para cuando el costo fijo es calculado en cuotas
              $costo_real = $actual_uma * $costo_fijo;
              $costo_final = $this->redondeo($costo_real);
            }
            $detalle []= array(
              'tramite_id' => $tramite_id,
              'costo_final' => $costo_final,
            );

            return json_encode($detalle);

          }elseif ($tipo == "V") {
            if($costoX == "L") { //costo x lote
              $costo_real = $actual_uma * $valor;
              $primer_costo = $this->redondeo($costo_real);

              if (!empty($lotes)){
                $costoxlote = $primer_costo * $lotes;
                $costoMinimo = $min * $actual_uma;
                $costoMin = $this->redondeo($costoMinimo);

                $costoMaximo = $max * $actual_uma;
                $costoMax = $this->redondeo($costoMaximo);

                if($costoxlote < $costoMinimo){
                  $costo_final = $costoMinimo;
                }elseif($costoxlote > $costoMax){
                  $costo_final = $costoMax;
                }else{
                  $costo_final = $this->redondeo($costoxlote);
                }
              }else{
                $costo_final = $primer_costo;
              }

              $detalle []= array(
                'tramite_id' => $tramite_id,
                'costo_final' => $costo_final,
              );

              return json_encode($detalle);
            }
            elseif ($costoX == "H") { // costo x hojas
              if(!empty($valor)){
                $costo_real = $actual_uma;
              }else{
                $costo_real = $actual_uma * $valor;
              }

              $primer_costo = $this->redondeo($costo_real);

              if (!empty($hojas)){
                $costoxhoja = $primer_costo * $hojas;

                $costoMinimo = $min * $actual_uma;
                $costoMin = $this->redondeo($costoMinimo);

                $costoMaximo = $max * $actual_uma;
                $costoMax = $this->redondeo($costoMaximo);
                if($costoxhoja < $costoMinimo){
                  $costo_final = $costoMinimo;
                }elseif($costoxhoja > $costoMax){
                  $costo_final = $costoMax;
                }else{
                  $costo_final = $this->redondeo($costoxhoja);
                }
              }else{
                $costo_final = $primer_costo;
              }

              $detalle []= array(
                'tramite_id' => $tramite_id,
                'costo_final' => $costo_final,
              );

              return json_encode($detalle);
            }
            else{ //costo x millar
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

              $detalle []= array(
                'tramite_id' => $tramite_id,
                'costo_final' => $costo_final,
              );
              return json_encode($detalle);
            }
          }
        }catch(\Exception $e){
          Log::info('Error - costo Trámite: '.$e->getMessage());
        }
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


    public function detalle ( Request $request ) {
      $id_tramite = $request->idTramite;

      $detalle = array();
      $data = $this->tiposer->where('Tipo_Code', $id_tramite)->get();
      foreach ($data as $d) {
        $nombre_tramite = $d->Tipo_Descripcion;
      }

      $info = $this->getPartidasTramites($id_tramite);

      $detalle [] = array(
        'id_tramite'=>$id_tramite,
        'tramite' => $nombre_tramite,
        'partidas' => $info,
      );

      set_layout_arg("subtitle", "Detalle Trámite");
      return layout_view("tramites.detalleTramite",[ "detalle" => $detalle ] );
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

    public function carshop ( Request $request ) {
      set_layout_arg("subtitle", "CarShop");
      return layout_view("tramites.carshop" );
    }


    public function respuestaPago(Request $request ){
      $url = getenv("PAYMENTS_HOSTNAME");
      $PAYMENTS_KEY = getenv("PAYMENTS_KEY");

      $response = Http::withHeaders([
          'Authorization' => 'Bearer ' . $PAYMENTS_KEY
      ])->post( $url . '/v1/respuestabanco', [
          'transactionToken' => $request->transactionToken,
      ]);

      $json = $response->json();
      if( $json['data'] ){
        return layout_view("tramites.respuestaPago",  [ "respuestabanco" =>$json] );
      } else {
        return layout_view("tramites.respuestaPago",  [ "respuestabanco" =>[] ]);
      }

    }

    public function respuestaPagoBBVA(Request $request){


      $url = getenv("PAYMENTS_HOSTNAME");
      $PAYMENTS_KEY = getenv("PAYMENTS_KEY");

      $response = Http::withHeaders([
          'Authorization' => 'Bearer ' . $PAYMENTS_KEY
      ])->post( $url . '/v1/respuestabanco', [
          's_transm' => $request->get('s_transm'),
          'mp_response' => $request->get('mp_response'),
          'mp_signature' => $request->get('mp_signature'),
          'n_autoriz' => $request->get('n_autoriz'),
      ]);

      $json = $response->json();


      if( $json['data'] ){
        return layout_view("tramites.respuestaPagoBancomer",  [ "respuestabanco" =>$json] );
      } else {
        return layout_view("tramites.respuestaPagoBancomer",  [ "respuestabanco" =>[] ]);
      }
    }

}
