<template>
    <div id="contenedorCampos" class="container-fluid">

        <form id="formularioComplementaria">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="row">
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Folio</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Folio" id="folio" v-model="datos.folio_anterior" />
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class=" fv-plugins-icon-container" id="fechaElement">
                                <label>Fecha Escritura</label>
                                <b-form-datepicker id="fecha"  v-model="datos.fecha_escritura"        
                                      @change="cambioModelo" style="background-color: #e5f2f5 !important"
                                    @focus="cambioModelo" @input="cambioModelo" :show-decade-nav="showDecadeNav">
                                </b-form-datepicker>
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Monto Operación</label>
                                <input  type="text" class="form-control form-control-solid form-control-lg"  placeholder="Monto Operación" id="fecha" v-model="datos.monto_operacion" @change="formatoMoneda('monto_operacion')"/>
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Ganancia Obtenida</label>
                                <input  type="text" class="form-control form-control-solid form-control-lg"  placeholder="Ganancia Obtenida" id="ganancia_obtenida" v-model="datos.ganancia_obtenida" @change="formatoMoneda('ganancia_obtenida')"/>
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Pago provisional</label>
                                <input  type="text" class="form-control form-control-solid form-control-lg"  placeholder="Pago provisional" id="fecha" v-model="datos.pago_provisional_lisr" @change="formatoMoneda('pago_provisional_lisr')"/>
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Multa Corrección Fiscal</label>
                                <input  type="text" class="form-control form-control-solid form-control-lg"  placeholder="Multa Corrección Fiscal" id="fecha" v-model="datos.multa_correccion_fiscal" @change="formatoMoneda('multa_correccion_fiscal')"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
     </div> 
</template>

<script>
    export default {
        props: ['infoGuardada'],
        data() {
            return {
                datos:{
                    folio_anterior:'',fecha_escritura:'', monto_operacion:'', ganancia_obtenida:'', multa_correccion_fiscal:'', pago_provisional_lisr:''
                },
                showDecadeNav:true
            }
        },
        mounted() {
        },

        created() {
           this.datos = this.infoGuardada && this.infoGuardada.camposComplementaria ? this.infoGuardada.camposComplementaria : this.datos;
           if(this.infoGuardada && this.infoGuardada.camposComplementaria){
                this.cambioModelo();
           }
        },

        methods:{
            cambioModelo(){
                let formularioValido = true;
                let claves = Object.keys(this.datos); 
                for(let i=0; i< claves.length; i++){
                  let clave = claves[i];
                  formularioValido =  formularioValido && !!this.datos[clave] && this.datos[clave].length > 0
                }

                this.$emit('updatingScore', formularioValido);
                this.$emit('sendData', this.datos);
                
            },

            formatoMoneda(name){

                let self = this;
                if(this.datos[name]){
                  let numero = this.formatoNumero(this.datos[name]);
                  this.datos[name] =  this.formatter(numero);
                } else{
                  return null;
                }
                this.cambioModelo();
            },

            formatoNumero(numberStr){
                let valor =  Number((numberStr+"").replace(/[^0-9.-]+/g,""));          
                return valor;
            },

            formatter(value){
                const formatter  = new Intl.NumberFormat('en-US', {
                  style: 'currency',
                  currency: 'MXN',
                  minimumFractionDigits: 2
                });
                return formatter.format(value);
            },
        }
    }
</script>


