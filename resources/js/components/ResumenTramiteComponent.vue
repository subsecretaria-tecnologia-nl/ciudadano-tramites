<template>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-3">Trámite:</h6>

                    <div >
                        <strong> {{ tramite.tramite }}</strong>
                    </div>
                    <div v-if="this.tramite.detalle && this.tramite.detalle.Salidas" class="btn btn-link" v-on:click="toggleTabla()" >
                        <small>Ver detalle </small> <i class="fa fa-angle-down"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 ml-auto" >
                                <table class="table table-clear" >
                                    <tbody v-if="this.tramite.detalle && this.tramite.detalle.Salidas"  id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="display: none;">
                                        <tr v-for="(salida, key) in this.tramite.detalle.Salidas" >
                                            <td class="left" style="width: 70%"  v-if="key != 'H (Importe total)'">
                                                <strong>{{ key }}</strong>
                                            </td>
                                            <td class="right" v-if="key != 'H (Importe total)'">
                                                    <span class="spinner-border spinner-border-sm" v-if="obteniendoCosto"></span>
                                                    <span v-if="!obteniendoCosto">  {{ salida }} </span>

                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody  v-if="this.tramite.detalle && this.tramite.detalle.Salidas">
                                        <tr>
                                            <td class="left" style="width: 70%">
                                                <strong>H (Importe total)</strong>
                                            </td>
                                            <td class="right">
                                                    <span class="spinner-border spinner-border-sm" v-if="obteniendoCosto"></span>
                                                    <span v-if="!obteniendoCosto"> 
                                                        {{ this.tramite.detalle.Salidas['H (Importe total)'] }}
                                                    </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else-if="this.tramite.detalle && tramite.detalle.costo_final ">
                                        <tr >
                                            <td class="left">
                                                <strong>Total</strong>
                                            </td>
                                            <td class="right">
                                                    <span v-if="!obteniendoCosto"> $ {{tramite.detalle.costo_final }} </span>
                                                    <span class="spinner-border spinner-border-sm" v-if="obteniendoCosto"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                                        
                    <div class="table-responsive-sm" v-if="listaSolicitantes.length > 0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="center">RFC</th>
                                <th>Nombre ó Razon Social</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sol, index) in listaSolicitantes" >
                                    <td class="left strong">{{ sol.rfc }}</td>
                                    <td class="center">
                                        {{ sol.tipoPersona == "pm" ? sol.razonSocial : sol.nombreSolicitante  }} 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

</template>

<script>
    export default {
        mounted() {
            this.obtenerInformacionDelTramite();
            this.obtenerCosto();
        },

        data(){
            return {
                tramite: {  },
                listaSolicitantes:[],
                datosFormulario:{},
                obteniendoCosto:true
            }
        },
  
        methods: {
            obtenerInformacionDelTramite(){
                let informacionEnStorage = ["listaSolicitantes", "tramite", "datosFormulario"];
                informacionEnStorage.forEach( name => {
                    if (localStorage.getItem(name)) {
                      try {
                        this[name] = JSON.parse(localStorage.getItem(name));
                      } catch(e) {
                        letocalStorage.removeItem(name);
                      }
                    }
                });
            },

            toggleTabla(){
                $( "#collapseOne" ).toggle('slow');
            },



            async obtenerCosto(){
                let campoCatastral = this.datosFormulario.campos.find( campo => campo.nombre === "Valor catastral");
                let campoValorOperacion = this.datosFormulario.campos.find( campo => campo.nombre === "Valor de operacion");
                let campoSubsidio = this.datosFormulario.campos.find( campo => campo.nombre === "Subsidio");
                let campoHoja = this.datosFormulario.campos.find( campo => campo.nombre === "Hoja");
                let campoLote = this.datosFormulario.campos.find( campo => campo.nombre === "Lote");

                //calculo impuesto
                let campoGananciaObtenida = this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase() === "ganancia obtenida");
                let campoFechaMinuta = this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase()  === "fecha de escritura o minuta");
                let campoPagoProvisional = this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase()  === "pago provisional conforme al articulo 126 lisr");
                let campoMulta= this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase() === "multa por correccion fiscal");
                let campoMonto = this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase()  === "monto de operación (reportado en el aviso de enajenación)");

             
                let consulta_api =  this.datosFormulario.consulta_api;
                let url = "";

                if( consulta_api ){
                    url = process.env.APP_URL + consulta_api;
                } else {
                    url = process.env.APP_URL + "/getcostoTramite";
                }

                let data = {  
                    id_seguimiento: this.tramite.id_seguimiento,
                    tramite_id: this.tramite.id_tramite
                }

                if( campoCatastral ){
                    data.valor_catastral = campoCatastral.valor;
                }

                if(campoSubsidio){
                    data.subsidio = campoSubsidio.valor;//62
                }

                if(campoValorOperacion ){
                    data.valor_operacion = campoValorOperacion.valor;
                }

                if( campoHoja ){
                    data.hoja = campoHoja.valor; 
                }

                if( campoLote ){
                    data.lote = campoLote.valor
                }


                if( consulta_api == "/getcostoImpuesto" ){

                    if( campoGananciaObtenida && campoFechaMinuta && campoPagoProvisional  && campoMonto  ){
                        data.fecha_escritura = campoFechaMinuta.valor;
                        data.monto_operacion = campoMonto.valor;
                        data.ganancia_obtenida = campoGananciaObtenida.valor;    
                        data.pago_provisional_lisr = campoPagoProvisional.valor;
                        if( campoMulta ){
                            data.multa_correccion_fiscal = campoMulta.valor;
                        }
                        
                    } else {

                    }
                }

                
                try {
                    let response = await axios.post(url, data);
                    console.log( response );
                    let detalleTramite = response.data;
                    if( consulta_api == "/getcostoImpuesto" ){
                        this.tramite.detalle =  detalleTramite;
                    } else {
                        this.tramite.detalle =  detalleTramite[0];
                    }

                    const parsed = JSON.stringify(this.tramite);
                    localStorage.setItem('tramite', parsed);  
                    this.$forceUpdate();
                    this.obteniendoCosto = false;
                } catch (error) {
                    console.log(error);
                    this.obteniendoCosto = false;
                }
                
            }

        }
    }
</script>

