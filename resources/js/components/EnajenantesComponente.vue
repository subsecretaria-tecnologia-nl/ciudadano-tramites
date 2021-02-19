<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">

        <b-row >
          <b-col>
            <b-form-group label="Porcentaje que enajena" label-for="procentaje-venta-input" >
                <b-form-input  id="procentaje-venta-input" name="procentaje-venta"  v-model="porcentajeVenta" @input="validar"></b-form-input>
                <b-input-group prepend="0" append="100" >
                    <b-form-input  id="procentaje-venta-rango" name="procentaje-venta"  v-model="porcentajeVenta" type="range" max="100" @input="validar"></b-form-input>
                    
                </b-input-group>
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
                            % Venta 
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
                            {{ registro.tipoPersona == 'pm' ? registro.datosPersonales.razonSocial : (registro.datosPersonales.nombre + ' ' + registro.datosPersonales.apPat + ' ' + registro.datosPersonales.apMat) }}
                        </td>	
                        <td>
                           {{ registro.datosPersonales.rfc }}
                        </td>	
                        <td>
                            {{ registro.datosPersonales.curp }}
                        </td>	
                        <td>
                             
                             {{ Number.parseFloat(porcentajeVenta * ( registro.porcentajeCompra / 100 )).toFixed(2) }}
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
            Porcentaje de venta
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
            if(this.campo.valor && this.campo.valor.enajenantes && this.campo.valor.enajenantes.length > 0){
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
                if( response.enajenante.tipoPersona === "pf" ){
                    delete response.enajenante.datosPersonales.razonSocial;
                } else {
                    delete response.enajenante.datosPersonales.nombre
                    delete response.enajenante.datosPersonales.apPat
                    delete response.enajenante.apMat;
                    delete response.enajenante.datosPersonales.curp;
                    delete response.enajenante.datosPersonales.estado;
                    delete response.enajenante.datosPersonales.fechaNacimiento;
                    delete response.enajenante.datosPersonales.genero;
                    delete response.enajenante.ife;
                }
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