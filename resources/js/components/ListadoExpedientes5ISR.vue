<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">
    <div   class="form-group fv-plugins-icon-container">
        <div class="table-responsive">
            <table class="table  table-striped">
                <thead style="border-bottom: solid;">
                    <tr>
                        <th class="text-center">
                            Expediente Catastral
                        </th>
                        <th>
                            Domicilio
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr  v-for="(registro, key) in expedientes"  >
                        <td class="text-center">
                            <i class="fa fa-times" id="iconBtnEliminar"  @click="eliminar(key)" style="cursor: pointer; color: red;" title="Quitar"></i> 
                            {{ registro.expediente }}
                        </td>	
                        <td>
                            {{ registro.direccion.datos_direccion[0].calle }}
                        </td>	
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
	<modal-expedientes-component @addExpediente="addExpediente"></modal-expedientes-component>
    </div>
</template>
<script>
	export default {
		mounted(){
            if(this.campo.valor && this.campo.valor.expedientes && this.campo.valor.expedientes.length > 0){
                this.expedientes = this.campo.valor.expedientes;
            }
            this.validar();
		},
        props:{
          campo:{
            default: null,
            type: Object
          },
          estadoFormulario:{
            default: null,
            type: Number
          },
          showMensajes:{
            default: false,
            type: Boolean
          }
        },
	    data(){
	        return {
	            expedientes: [],
	        }
	    },
		methods : {
            eliminar( index ){
                this.expedientes.splice(index, 1);
                this.validar();
            },

           	addExpediente(expediente){
           		this.expedientes.push(expediente);
                this.validar();
           	},

            validar(){
                this.campo.valido =  this.expedientes && this.expedientes.length > 0;
                this.campo.valor = {expedientes:this.expedientes};
                this.$emit('updateForm', this.campo);
          
            }
		},

	};
</script>