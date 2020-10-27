<template>	                
    <div class="container-fluid">
		<div class="row">

		    <!--Grid column-->
		    <div class="col-lg-8">

		      	<!-- Card -->
		      	<div class="mb-3" v-if="!mostrarMetodos">
		        	<div class="pt-4 wish-list " id="listTramites" v-for="tramite in tramites" >
		        		<div class="row mb-4 mb-3 shadow-sm p-3 bg-white rounded" 	>
		        			<div class="col-md-7 col-lg-9 col-xl-9">
		        				<div>
		        					<div class="d-flex justify-content-between">
		        						<div>
		        							<h5> {{ tramite.id_tramite }} </h5>
		        							<p class="mb-3 text-muted text-uppercase small"> 
		        								Nombre : {{ tramite.datos_solicitante.nombre }} {{ tramite.datos_solicitante.apellido_paterno  }} {{ tramite.datos_solicitante.apellido_materno }}
		        							</p>
		        							<p class="mb-3 text-muted text-uppercase small">
		        								RFC: {{ tramite.datos_solicitante.rfc }}
		        							</p>
		        						</div>
		        					</div>
		        					<div class="d-flex justify-content-between align-items-center">
		        						<div>
		        							<a type='button' class='card-link-secondary small text-uppercase mr-3' v-on:click="eliminar( tramite.id_tramite )" >
		        								<i class='fas fa-trash-alt mr-1'></i>Eliminar
		        							</a>
		        						</div>
		        						<p class="mb-0">
		        							<span><strong id="summary"> 
		        								$ {{ tramite.importe_tramite}}
		        							</strong></span>
		        						</p>
		        					</div>
		        				</div>
		        			</div>
		        		</div>
		        	</div>
		      	</div>
		      	<!-- Card -->
      			<metodos-pago-component v-if="mostrarMetodos" :infoMetodosPago="infoMetodosPago"></metodos-pago-component>

		    </div>
		    <!--Grid column-->

		    <!--Grid column-->
		    <div class="col-lg-4">

		    	<!-- Card -->
		      	<div class="mb-3 shadow-sm p-3 bg-white rounded">  
		        	<div class="pt-4 ">

		          		<h5 class="mb-3">Total:</h5>

		          		<ul class="list-group list-group-flush">
		            		<li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-0">
		              			Subtotal
		              			<span id="subTotalTramites">$0.00</span>
		            		</li>
		            		<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
		              			<div>
		                			<strong>Total</strong>
		                			<strong>
		                  				<p class="mb-0"></p>
		                			</strong>
		              			</div>
		              			<span>
		              				<strong id="totalTramites">
		              					$0.00
		              				</strong>
		              			</span>
		            		</li>
		          		</ul>

		          		<button id="metodoPagoBtn" type="button" class="btn btn-primary btn-block" v-on:click="metodoPago()" :disabled="diabledBtnMedtodo" >
		          			Pagar
		          			<div id="spinner-pago" class="spinner-border spinner-border-sm float-right" role="status" v-if="diabledBtnMedtodo">
		          				<span class="sr-only">Loading...</span>
		          			</div>
		          		</button>
<!--
		          		<transition name="fade">
    						<p v-if="!diabledBtnMedtodo">
    							<button  id="addTramiteBTN" type="button" class="btn btn-default btn-block" onclick="openModalAdd()">Agregar Trámite</button>
    						</p>
  						</transition>
		          		-->
		          		
		          		<button id="metodoPagoCancBtn" type="button" class="btn btn-danger btn-block" onclick="cancelarPago()" style="display: none;">
		          			Cancelar
		          		</button>
		        	</div>


		     	</div>
		      	<!-- Card -->
		    </div>
		    <!--Grid column-->
		</div>
		<!-- Grid row -->
    </div>
</template>
<style type="text/css">
	.fade-enter-active, .fade-leave-active {
	  transition: opacity .5s
	}
	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
	  opacity: 0
	}
</style>
<script>
	import { uuid } from 'vue-uuid';
    export default {
        data() {
            return {
            	diabledBtnMedtodo:false,
            	tramites:[],
            	mostrarMetodos:false,
            	infoMetodosPago:{}
            }
        },
  
        mounted() {
           this.tramites =  [
			    {
			      "id_seguimiento": 4254,
			      "id_tipo_servicio": 397,
			      "id_tramite": "BMU8605134I81FM5K7D80EGA56944",
			      "importe_tramite": "3041",
			      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
			      "auxiliar_2": "",
			      "auxiliar_3": "",
			      "datos_solicitante": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "datos_factura": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "detalle": [
			        {
			          "concepto": "REFRENDO PTE.AÑO",
			          "importe_concepto": "3041",
			          "partida": 95101
			          
			        },
			        {
			          "concepto": "SANCION REFRENDO PTE.AÑO",
			          "importe_concepto": "130",
			          "partida": 95123,
			          "descuentos": [
			            {
			              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
			              "importe_descuento": "130",
			              "partida_descuento": 95136
			            }
			          ]
			        }
			      ]
			    },
			    {
			      "id_seguimiento":334,
			      "id_tipo_servicio": 397,
			      "id_tramite": "BMU8605134I81GBKC34J9WJ108483",
			      "importe_tramite": "820",
			      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
			      "auxiliar_2": "",
			      "auxiliar_3": "",
			      "datos_solicitante": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "datos_factura": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "detalle": [
			        {
			          "concepto": "REFRENDO PTE.AÑO",
			          "importe_concepto": "3035",
			          "partida": 95101,
			          "descuentos": [
			            {
			              "concepto_descuento": "SUBSIDIO ANTIGUEDAD 15 AÑOS",
			              "importe_descuento": "2215",
			              "partida_descuento": 95106
			            }
			          ]
			        },
			        {
			          "concepto": "SANCION REFRENDO PTE.AÑO",
			          "importe_concepto": "130",
			          "partida": 95123,
			          "descuentos": [
			            {
			              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
			              "importe_descuento": "130",
			              "partida_descuento": 95136
			            }
			          ]
			        }
			      ]
			    },
			    {
			      "id_seguimiento":43,
			      "id_tipo_servicio": 397,
			      "id_tramite": "BMU8605134I81GBKC34JXWJ103325",
			      "importe_tramite": "826",
			      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
			      "auxiliar_2": "",
			      "auxiliar_3": "",
			      "datos_solicitante": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "datos_factura": {
			        "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "apellido_paterno": "",
			        "apellido_materno": "",
			        "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			        "rfc": "BMU8605134I8 ",
			        "curp": "",
			        "email": "",
			        "calle": "AV LA JUVENTUD",
			        "colonia": "BOSQUES DEL NOGALAR",
			        "numexterior": "",
			        "numinterior": "120",
			        "municipio": "SAN NICOLAS DE LOS GARZA",
			        "codigopostal": 66480
			      },
			      "detalle": [
			        {
			          "concepto": "REFRENDO PTE.AÑO",
			          "importe_concepto": "3041",
			          "partida": 95101,
			          "descuentos": [
			            {
			              "concepto_descuento": "SUBSIDIO ANTIGUEDAD 15 AÑOS",
			              "importe_descuento": "2215",
			              "partida_descuento": 95106
			            }
			          ]
			        },
			        {
			          "concepto": "SANCION REFRENDO PTE.AÑO",
			          "importe_concepto": "130",
			          "partida": 95123,
			          "descuentos": [
			            {
			              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
			              "importe_descuento": "130",
			              "partida_descuento": 95136
			            }
			          ]
			        }
			      ]
			    }
			    
			  ]

			  console.log( this.tramites ) 

        },

        methods: {

        	eliminar(id_tramite){
        		this.tramites = this.tramites.filter( tramite => tramite.id_tramite != id_tramite );
        	},

		    metodoPago() {
		    	this.diabledBtnMedtodo = true;
		    	let url = process.env.PAYMENTS_HOSTNAME  + "/v1/pay"
				let data = {
					"token": "DD0FDED2FE302392164520BF7090E1B3BEB7",
					"referencia": "",
					"url_retorno": "url",
					"importe_transaccion": "4687",
					"id_transaccion": uuid.v4(),//"BMU8605134I82915082020",
					"entidad": 2,
					"url_confirma_pago": "url",
					"es_referencia": "1",
					"tramite": this.tramites 
				}
            	axios.post(url, data, {
            		headers:{
            			"Authorization":"Bearer " + process.env.PAYMENTS_KEY,
				        "Content-type":"application/json"
            		},
            	} )
              	.then(response => {
              		console.log( response.data.response)
                	this.infoMetodosPago = response.data.response;
              	}).catch((error)=> {
					this.diabledBtnMedtodo = false;
				}).finally(() => {
					this.diabledBtnMedtodo = false;
					this.mostrarMetodos = true;
				});

	    	}
		}

    }
</script>