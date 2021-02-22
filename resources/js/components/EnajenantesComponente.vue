<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">

        <b-row >
          <b-col>
            <b-form-group label="Porcentaje que enajena" label-for="procentaje-venta-input" >
                <b-form-input  id="procentaje-venta-input" name="procentaje-venta"  v-model="$v.porcentajeVenta.$model" @input="validar"  :state="$v.porcentajeVenta.$dirty ? !$v.porcentajeVenta.$error : null" aria-describedby="porcentajeVenta-input-feedback" max="100" type="number"></b-form-input>
                <b-input-group prepend="0" append="100" >
                    <b-form-input  id="procentaje-venta-rango" name="procentaje-venta"  v-model="$v.porcentajeVenta.$model" type="range" max="100" @input="validar" :state="$v.porcentajeVenta.$dirty ? !$v.porcentajeVenta.$error : null" aria-describedby="porcentajeVenta-input-feedback"></b-form-input>
                </b-input-group>
                <b-form-invalid-feedback id="porcentajeVenta-input-feedback">
                    <span v-if="!$v.porcentajeVenta.isMayorQuePorcentajeAsignado"  class="form-text text-danger">
                       La suma de los porcentajes individuales es mayor al porcentaje de enajenación.
                    </span>
                    <span v-if="!$v.porcentajeVenta.isPorcentajeComplete"  class="form-text text-danger">
                       El porcentaje de venta debe ser de {{$v.porcentajeVenta.$model}}
                    </span>
                    <span v-if="!$v.porcentajeVenta.maxValue"  class="form-text text-danger">
                       El porcentaje de venta debe ser menor o igual a 100
                    </span>

                </b-form-invalid-feedback>
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
                            {{  registro.porcentajeCompra }}
                        </td>		
                        <td>
                            <modal-component 
                        		@editaEnajentante="editaEnajentante"  :enajenanteEditado="registro" :porcentajeAsignado="porcentajeTotalCompra" :indexEnajenanteEditado="key"
                                :porcentajeVenta="$v.porcentajeVenta.$model">
                        	</modal-component>                        	
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
            Porcentaje de venta asignado 
            <b-progress :value="porcentajeTotalCompra" max="porcentajeVenta" show-value class="mb-3"></b-progress>
    </div>
	<modal-component 
		@addEnajentante="addEnajentante" v-if="porcentajeTotalCompra < $v.porcentajeVenta.$model" 
            :porcentajeAsignado="porcentajeTotalCompra" 
            :porcentajeVenta="$v.porcentajeVenta.$model">
	</modal-component>
    </div>
</template>
<script>
    import { validationMixin } from 'vuelidate'
    import { maxValue } from 'vuelidate/lib/validators';
	export default {
        mixins: [validationMixin],
            validations() {
              return {
                  porcentajeVenta:{
                    isMayorQuePorcentajeAsignado(value) {
                        return this.porcentajeTotalCompra <= value
                    },
                    isPorcentajeComplete(value){
                        return this.porcentajeTotalCompra == value;
                    },
                    maxValue: maxValue(100)
                  }
              }
            },

		mounted(){
            if(this.campo.valor && this.campo.valor.enajenantes && this.campo.valor.enajenantes.length > 0){
                this.enajentantes = this.campo.valor.enajenantes;
                //this.porcentajeVenta = this.campo.valor.porcentajeVenta;
                this.$v.porcentajeVenta.$model  = this.campo.valor.porcentajeVenta;
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
                this.$v.$touch()
                var total = 0;
                this.enajentantes.forEach(enajentante => {
                    total = parseFloat(total) + parseFloat(enajentante.porcentajeCompra);
                });
                this.porcentajeTotalCompra = total;
                this.validar();
            },

            validar(){
                this.campo.valido =  this.porcentajeTotalCompra == this.$v.porcentajeVenta.$model;
                this.campo.valor = {enajenantes:this.enajentantes, porcentajeVenta:this.$v.porcentajeVenta.$model};
                this.$emit('updateForm', this.campo);
          
            }
		},

	};
</script>