<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">

        <b-row >
          <b-col>
            <b-form-group label="Porcentaje de venta" label-for="procentaje-venta-input" >
              <b-form-input  id="procentaje-venta-rango" name="procentaje-venta"  v-model="porcentajeVenta" type="range" max="100"></b-form-input>
              <b-form-input  id="procentaje-venta-input" name="procentaje-venta"  v-model="porcentajeVenta" ></b-form-input>
            </b-form-group>
          </b-col>         
        </b-row>

    <div   class="form-group fv-plugins-icon-container">
        <div class="table-responsive">

            <table class="table  table-striped">
                <thead style="border-bottom: solid;">
                    <tr>
                        <th class="text-center">
                            Tipo de persona
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th>
                            RFC 
                        </th>
                        <th>
                            CURP
                        </th>
                        <th>
                            % Compra 
                        </th>
                        <th>
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <tr  v-for="(registro, key) in enajentantes"  >
                        <td class="text-center">
                            <i class="fa fa-times" id="iconBtnEliminar"  @click="eliminar(key)" style="cursor: pointer; color: red;" title="Quitar"></i> 
                            {{ registro.tipoPersona }}
                        </td>	
                        <td>
                            {{ registro.razonSocial }} {{ registro.nombre + ' ' + registro.apPat + '' + registro.apMat }}
                        </td>	
                        <td>
                           {{ registro.rfc }}
                        </td>	
                        <td>
                            {{ registro.curp }}
                        </td>	
                        <td>
                            {{ registro.porcentajeCompra }}
                        </td>		
                        <td>
                            <modal-component 
                        		@editaEnajentante="editaEnajentante"  :enajenanteEditado="registro" :porcentajeAsignado="porcentajeTotalCompra" :indexEnajenanteEditado="key">
                        	</modal-component>                        	
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            Porcentaje de compra
            <b-progress :value="porcentajeTotalCompra" max="100" show-value class="mb-3"></b-progress>
    </div>
	<modal-component 
		@addEnajentante="addEnajentante" v-if="porcentajeTotalCompra < 100" :porcentajeAsignado="porcentajeTotalCompra">
	</modal-component>
    </div>
</template>
<script>
	export default {
		mounted(){
            if(this.campo.valor && this.campo.valor.enajenantes.length > 0){
                this.enajentantes = this.campo.valor.enajenantes;
                this.porcentajeVenta = this.campo.valor.porcentajeVenta;
                //this.campo.valor = {enajenantes:this.enajentantes, porcentajeVenta:this.porcentajeVenta};
                this.calcularTotalPorcentaje();
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
	            enajentantes: [],
                porcentajeTotalCompra: 0,
                porcentajeVenta:100
	        }
	    },
		methods : {
            eliminar( index ){
                this.enajentantes.splice(index, 1);
                this.calcularTotalPorcentaje();
            },

           	addEnajentante(enajentante){
           		this.enajentantes.push(enajentante);
                this.calcularTotalPorcentaje();
           	},

            editaEnajentante(response){
            	this.enajentantes[response.index] = response.enajenante;
                this.$forceUpdate();
                this.calcularTotalPorcentaje();

           	},

            calcularTotalPorcentaje(){
                var total = 0;
                this.enajentantes.forEach(enajentante => {
                    total = parseFloat(total) + parseFloat(enajentante.porcentajeCompra);
                });
                this.porcentajeTotalCompra = total;
                this.validar();
            },

            validar(){
                this.campo.valido =  this.porcentajeTotalCompra == 100;
                this.campo.valor = {enajenantes:this.enajentantes, porcentajeVenta:this.porcentajeVenta};
                this.$emit('updateForm', this.campo);
          
            }
		},

	};
</script>