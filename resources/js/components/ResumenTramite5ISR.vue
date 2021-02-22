<template>
        <div class="container">
            <div class="card">
                 <div class="card-header">
                    Resumen
                 </div>
                <div class="card-body">
                    <b-row>
                        <div class="col-sm-6">
                            <h6 class="mb-3">Solicitante:</h6>
                            <div>

                                <strong>{{usuario.name + ' ' + usuario.fathers_surname + ' ' + usuario.mothers_surname }}</strong>
                            </div>
                            <div>CURP: {{usuario.curp}}</div>
                            <div>RFC: {{usuario.rfc}}</div>
                            <div>Email: {{usuario.email}}</div>
                            <div>Phone: {{usuario.phone}}</div>
                        </div>
                    </b-row>                                      
                    <b-row>
                        <div class="col-sm-12">
                            <h2 class="border-bottom my-3">Enajenantes</h2>
                        </div>
                        <div class="col-sm-12">
                            <b-table responsive striped hover :items="listaEnajentantes" :fields="camposEnajenantes" ref="table">
                                <template #cell(datosPersonales)="data">
                                    <template-datos-personales-component :datosPersonales="data.item.datosPersonales"></template-datos-personales-component>
                                </template>
                                <template #cell(datosParaDeterminarImpuesto)="data" >
                                    <div v-if="!data.item.detalle"  class="text-center">
                                        <b-spinner type="grow" label="Spinning"></b-spinner>
                                        <calculo-costo-tramite-5-isr-component 
                                        :datosParaDeterminarImpuesto="data.item.datosParaDeterminarImpuesto" 
                                        :campos="camposGenerales"
                                        :tramite="tramite" :tipoPersona="data.item.tipoPersona" @costosObtenidos="costosObtenidos" :index="data.index">
                                        </calculo-costo-tramite-5-isr-component>                                    
                                    </div>
                                    <div v-else-if="data.item.detalle && data.item.detalle.Salidas">
                                        <div class="text-center">
                                          <b-button tabindex="0" title="Click para ver detalles" variant="primary" @click="data.toggleDetails" class="mr-2">
                                            {{currencyFormat('H (Importe total)', data.item.detalle.Salidas['H (Importe total)'])}}
                                          </b-button>
                                        </div>                          
                                    </div>
                                    
                                </template>
                                <template #cell(status)="data">
                                    <div v-if="data.item.status">
                                        <div v-if="data.item.status.error">
                                            {{ data.item.status.msj }}

                                            
                                        </div>
                                        <div v-else-if="!data.item.status.error">
                                            Ok
                                        </div>
                                    </div>
                                </template> 
                                <template #row-details="data" #title="Detalle">
                                    <b-card no-body v-if="data">
                                        <b-card-body id="nav-scroller"ref="content"style="position:relative; height:400px; overflow-y:scroll;">
                                            <b-row v-for="(salida, key) in data.item.detalle.Salidas" :key="key">
                                                <b-col class="left" style="width: 70%" >
                                                    <strong>{{ key }}</strong>
                                                </b-col>
                                                <b-col class="right" >
                                                    <span class="text-muted">   {{ currencyFormat(key, salida) }} </span>
                                                </b-col>
                                            </b-row>
                                        </b-card-body> 
                                    </b-card>
                                </template>                                                          
                            </b-table>
                        </div>
                    </b-row>      
                    <b-row>
                        <div class="col-sm-12">
                            <h2 class="border-bottom my-3">Expedientes</h2>
                        </div>
                        <div class="col-sm-12">
                            <b-table responsive  hover :items="listaExpedientes" :fields="camposExpedientes">
                                <template #cell(direccion)="data">
                                    {{ data.item.direccion.datos_direccion[0].calle }}
                                </template>
                            </b-table>
                        </div>
                    </b-row>   
                    <b-row>
                        <div class="col-sm-12">
                            <h2 class="border-bottom my-3">Archivos</h2>
                        </div>
                        <div class="col-sm-12">
                            <b-table responsive striped hover :items="files" :fields="camposArchivos">
                                <template #cell(nombrreFile)="data">
                                    {{ data.item.nombrreFile|| "No se selecciono ninguno"}}
                                </template>
                            </b-table>
                        </div>
                    </b-row> 
                </div>
            </div>
        </div>

</template>
<script>

    import Vue from 'vue'

    export default {

        props: ['datosComplementaria','tipoTramite', 'files', 'usuario','errors'],
        mounted() {
            this.obtenerInformacionDelTramite();
            
            this.camposGenerales = this.datosFormulario.campos;
            let campoEnajenantes = this.camposGenerales.find( campo =>  campo.tipo == 'enajenante');
            let campoExpedientes = this.camposGenerales.find( campo =>  campo.tipo == 'expedientes');


            this.listaEnajentantes = campoEnajenantes.valor.enajenantes.map( (enajenante, index) => {
                enajenante.index = index;
                return enajenante;
            });
            this.listaExpedientes = campoExpedientes.valor.expedientes;
            this.camposExpedientes = ['expediente', 'direccion'];

            this.camposArchivos = ['nombre',{ key: 'nombrreFile', label: 'Archivo' }];
            this.camposEnajenantes =[
                    { key: 'porcentajeCompra', label: '% Compra' },
                    { key: 'datosPersonales', label: 'Datos Personales' },
                    { key: 'tipoPersona', label: 'Tipo Persona' },
                    { key: 'datosParaDeterminarImpuesto', label: 'Total' },
                    'status'

            ];
        },

        data(){
            return {
                tramite: {  },
                listaSolicitantes:[],
                datosFormulario:{},
                obteniendoCosto:true,
                listaEnajentantes:[],
                listaExpedientes:[],
                camposExpedientes:[],
                camposArchivos:[],
                camposGenerales:[],
                camposEnajenantes:[]

                /*camposEnajenantes:[
                    'index',
                    { key: 'rfc', label: 'RFC' },
                    { key: 'curp', label: 'CURP' },
                    { key: 'nombre', label: 'Nombre' },
                ]*/
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

            costosObtenidos(data){
                let detalle =  data.success ? data.respuestaCosto : true;

                if(!data.success){
                    this.listaEnajentantes[data.indice].status  =  {
                        error:true,
                        indice:data.indice,
                        msj :"No fue posible obtener los costos"
                    };
                }

                this.listaEnajentantes[data.indice].detalle = detalle;
                this.$refs.table.refresh();

                let campos = this.datosFormulario.campos;
                let indexCampoEnajenantes = campos.findIndex( campo =>  campo.tipo == 'enajenante');

                const parsed = JSON.stringify(this.datosFormulario);
                localStorage.setItem('datosFormulario', parsed);  

            },


            currencyFormat(campoName, salida){
                let arr = ["A*(Ganancia Obtenida)","B (Monto obtenido conforme al art 127 LISR)",
                            "C*(Pago provisional conforme al art 126 LISR)","D (Impuesto correspondiente a la entidad federativa)",
                            "E (Parte actualizada del impuesto)", "F (Recargos)", "G*(Multa corrección fiscal)", "H (Importe total)"];
                if(arr.includes(campoName)){
                    let text = Vue.filter('toCurrency')(salida);
                    return text;
                } else{
                    return salida;
                }
            }

        },
          watch: {
            'errors': {
                handler: function (val, oldVal) {
                    this.listaEnajentantes =  this.listaEnajentantes.map( enajenante => {
                        delete enajenante.status;
                        return enajenante;
                    } );
                    this.$refs.table.refresh();
                    if(val.headers.indiceEnajenante){
                   
                        this.listaEnajentantes[val.headers.indiceEnajenante].status = {
                            guardado:false,
                            error:true
                        };
                        this.$refs.table.refresh();
                        
                        let campos = this.datosFormulario.campos;
                        let indexCampoEnajenantes = campos.findIndex( campo =>  campo.tipo == 'enajenante');
                        this.datosFormulario.campos[indexCampoEnajenantes].valor.enajenantes[val.headers.indiceEnajenante].status = {
                            guardado:false,
                            error:true,
                            indice:val.headers.indiceEnajenante,
                            msj:"No fue posible guardar los datos del enajenante, intente de nuevo"
                        };
                        this.datosFormulario.errorAlguardar = true;             
                        const parsed = JSON.stringify(this.datosFormulario);
                        localStorage.setItem('datosFormulario', parsed);  
                    }
                    
                },
                deep: true
            }
          }
    }
</script>

