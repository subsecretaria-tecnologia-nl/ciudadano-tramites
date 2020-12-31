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
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Fecha Escritura</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Fecha Escritura" id="fecha" v-model="datos.fecha_escritura" />
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Monto Operación</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Monto Operación" id="fecha" v-model="datos.monto_operacion" />
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Ganancia Obtenida</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Ganancia Obtenida" id="ganancia_obtenida" v-model="datos.ganancia_obtenida" />
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Pago provisional</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Pago provisional" id="fecha" v-model="datos.pago_provisional_lisr" />
                            </div>
                        </div>
                        <div  class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group fv-plugins-icon-container"  >
                                <label>Multa Corrección Fiscal</label>
                                <input @change="cambioModelo" type="text" class="form-control form-control-solid form-control-lg"  placeholder="Multa Corrección Fiscal" id="fecha" v-model="datos.multa_correccion_fiscal" />
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
        data() {
            return {
                datos:{
                    folio_anterior:'',fecha_escritura:'', monto_operacion:'', ganancia_obtenida:'', multa_correccion_fiscal:'', pago_provisional_lisr:''
                }
            }
        },
        props: [],
        mounted() {
            
        },

        methods:{
            cambioModelo(){
                let formularioValido = true;
                let claves = Object.keys(this.datos); 
                console.log( claves )
                for(let i=0; i< claves.length; i++){
                  let clave = claves[i];
                  formularioValido =  formularioValido && !!this.datos[clave] && this.datos[clave].length > 0
                }

                this.$emit('updatingScore', formularioValido);
                
                this.$emit('sendData', this.datos);
                
            }
        }
    }
</script>


