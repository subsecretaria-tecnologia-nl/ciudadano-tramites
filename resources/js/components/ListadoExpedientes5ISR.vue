<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">
    <div   class="form-group fv-plugins-icon-container">
        <b-table responsive striped hover :items="expedientes" :fields="camposExpedientes" ref="table"  class="text-center">
            <template #cell(municipio)="data">
                <i class="fa fa-times" id="iconBtnEliminar"  @click="eliminar(data.item)" style="cursor: pointer; color: red;" title="Quitar"></i> 
                {{ data.item.municipio.clave }}-{{ data.item.expediente }}
            </template>
            <template #cell(direccion)="data">
                {{ data.item.direccion.datos_direccion[0].calle }}
            </template>
            <template #cell(acciones)="data">
                <div>
                    <b-link title="Click para ver detalles" @click="data.toggleDetails" class="mr-2 btn btn-link">
                        {{!data.detailsShowing ? "Ver detalle " : "Ocultar detalle "}}
                    </b-link>
                </div>
            </template> 
            <template #row-details="data" #title="Detalle">
                <b-card no-body v-if="data">
                    <b-card-body id="nav-scroller"ref="content"style="position:relative; height:400px; overflow-y:scroll;">
                        <b-row >
                            <tree-component
                                class="item"
                                :item="data.item.direccion"
                              ></tree-component>
                        </b-row>
                    </b-card-body> 
                </b-card>
            </template>                                                          
        </b-table>
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
                camposExpedientes :[
                    { key: 'municipio', label: 'Expediente Catastral' },
                    { key: 'direccion', label: 'Direccion' },
                    { key: 'acciones', label: 'Aciones' }
                ]
	        }
	    },
		methods : {
            eliminar( registro ){
                let index = this.expedientes.findIndex( expediente => expediente.municipio.clave == registro.municipio.clave  &&  expediente.expediente == registro.expediente )
                this.expedientes.splice(index, 1);
                this.validar();
            },
 
           	addExpediente(expediente){
                let index = this.expedientes.findIndex( expedienteLista => expedienteLista.municipio.clave == expediente.municipio.clave  &&  expedienteLista.expediente == expediente.expediente );
                if(index < 0){
                    this.expedientes.push(expediente);
                }
           		
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