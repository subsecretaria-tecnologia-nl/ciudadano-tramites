<template>	                
    <div class="container-fluid">
		<div class="row">

		    <!--Grid column-->
		    <div class="col-lg-8">
		      	<!-- Card -->
		      	<div v-if="!mostrarMetodos">
		      		     <v-container v-if="obteniendoTramites">
			                <v-row>
			                    <v-col cols="12" md="12">
			                        <v-skeleton-loader  type="list-item" v-for="(r,i) in [1,2,3,4,5,6]" height="90px" style="margin-bottom: 8px;"></v-skeleton-loader>
			                    </v-col>
			                </v-row>
			            </v-container>
		        		<div class="container-fluid mb-4 mb-3 shadow-sm p-3 bg-white rounded" id="listTramites" v-for="tramite in tramitesPaginados"  v-if="!obteniendoTramites" >
		        			<div class="col-md-7 col-lg-9 col-xl-9">
		        				<div>
		        					<div class="d-flex justify-content-between">
		        						<div>
		        							<h5> {{ tramite.nombre }} </h5>
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
		        							<a type='button' class='card-link-secondary small text-uppercase mr-3' v-on:click="eliminar( tramite )" >
		        								<i class='fas fa-trash-alt mr-1'></i>Eliminar
		        							</a>
		        						</div>
		        						<p class="mb-0">
		        							<span>
		        								<strong > 
		        									$<span v-html="tramite.importe_tramite"> </span>
		        									<!--
		        								$ {{ tramite.importe_tramite}}
		        							-->
		        								</strong>
		        							</span>
		        						</p>
		        					</div>
		        				</div>
		        			</div>
		        		</div>


		        	<div class="card card-custom">
                    	<div class="card-body py-7">
	                        <!--begin::Pagination-->
	                        <div class="d-flex justify-content-between align-items-center flex-wrap">
	                            <div class="d-flex flex-wrap mr-3" >
	                                <a  class="btn btn-icon btn-sm btn-light-primary" v-if="currentPage !== 1" v-on:click="goto(currentPage - 1)">
	                                    <i class="ki ki-bold-arrow-back icon-xs"></i>
	                                </a>
	                                <a class="btn btn-icon btn-sm border-0 btn-hover-primary" v-for="(r) in pages"
	                                v-bind:class="[ currentPage === r ? 'active' : '']" v-on:click="goto(r)"> 
	                                   {{ r }}
	                                </a>
	                                <a  class="btn btn-icon btn-sm btn-light-primary" v-if="currentPage !== (pages.length)"  v-on:click="goto(currentPage + 1)">
	                                    <i class="ki ki-bold-arrow-next icon-xs"></i>
	                                </a>
	                            </div>
	                            <div class="d-flex align-items-center">
	                                <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" v-model="porPage" @change="calcularPage">
	                                    <option value="2">2</option>
	                                    <option value="5">5</option>
	                                    <option value="30">30</option>
	                                </select>
	                            </div>
	                        </div>
	                        <!--end:: Pagination-->
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
		          			<!--
		            		<li class="list-group-item d-flex justify-content-between align-items-center px-0 pb-0">
		              			Subtotal
		              			<span id="subTotalTramites">$0.00</span>
		            		</li>-->
		            		<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
		              			<div>
		                			<strong>Total</strong>
		                			<strong>
		                  				<p class="mb-0"></p>
		                			</strong>
		              			</div>
		              			<span>
		              				<strong id="totalTramites" >
		              					${{ totalImporte }}
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
    	props: ['idUsuario'],


        data() {
            return {
            	diabledBtnMedtodo:false,
            	tramites:[],
            	mostrarMetodos:false,
            	infoMetodosPago:{},

            	porPage : 10, pages:[0], currentPage :1, tramitesPaginados:{},
            	totalImporte:0,
            	obteniendoTramites:false
            }
        },
  
        mounted() {
        	this.obtenerTramitesAgregados();
        },

        methods: {

        	eliminar(tramiteDelete){
        		this.tramites = this.tramites.filter( tramite => tramite.id_tramite != tramiteDelete.id_tramite );
        		/*confirm({
					  title: "Eliminar tramite",
					  message: tramite.nombre,
					  okButtonText: "Your OK button text",
					  cancelButtonText: "Your Cancel text"
					}).then(result => {
					  console.log(result);
					});*/

				this.tramitesFiltrados = this.tramites;
				let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
			    let pages = [];

	            for (var i = 0; i < pagesTotal; i++) {
	                pages.push( i + 1 );
	            }
	            this.pages = pages;
	            this.pagination(1);

	            					let total = 0;
					this.tramites.forEach(tramite => total = total + tramite.importe_tramite );
 					this.totalImporte = total;
        	},


		    metodoPago() {
		    	this.diabledBtnMedtodo = true;
		    	const clone = items => items.map(item => (Array.isArray(item) ? clone(item) : item))
		    	let tramitesAEnviar =clone( this.tramites);
		    	tramitesAEnviar = tramitesAEnviar.map( tramite =>{
		    		delete tramite.nombre;
		    		return tramite;
		    	})

		    	let url = process.env.PAYMENTS_HOSTNAME  + "/v1/pay"
				let data = {
					"token": "DD0FDED2FE302392164520BF7090E1B3BEB7",
					"referencia": "",
					"url_retorno": "url",
					"importe_transaccion":  this.totalImporte, //"4687",
					"id_transaccion": uuid.v4(),//"BMU8605134I82915082020",
					"entidad": 2,
					"url_confirma_pago": "url",
					"es_referencia": "1",
					"tramite": tramitesAEnviar
				}
				
            	axios.post(url, data, {
            		headers:{
            			"Authorization":"Bearer " + process.env.PAYMENTS_KEY,
				        "Content-type":"application/json"
            		},
            	} )
              	.then(response => {

                	this.infoMetodosPago = response.data.response;
                	this.mostrarMetodos = true;
              	}).catch((error)=> {
					this.diabledBtnMedtodo = false;
					this.mostrarMetodos = false;
				}).finally(() => {
					this.diabledBtnMedtodo = false;
					
				});

	    	},

	    	pagination( page ){
                let porPageInt = parseInt(this.porPage);
                let indiceInicial = (page - 1 ) * porPageInt;
                let indiceFinal =   ( (page - 1 ) * porPageInt  )  + porPageInt;

                //this.tramitesFiltrados = this.tramites.filter( tramite => tramite.tramite.toLocaleLowerCase().includes(this.strBusqueda.toLocaleLowerCase()) ) ;
                this.tramitesPaginados = this.tramites.slice( indiceInicial,  indiceFinal );
                this.totalTramites = this.tramitesPaginados.length;
            },


            goto( page ){ 
                this.pagination( page );
                this.currentPage = page;
            },

            search(){
                this.calcularPage()
                this.currentPage = 1;
                this.pagination(1);
            },

            calcularPage(){
                let pages = [];
                let pagesTotal = Math.ceil( /*this.tramitesFiltrados.length*/ this.tramites.length  / this.porPage);
                for (var i = 0; i < pagesTotal; i++) {
                    pages.push( i + 1 );
                }
                this.pages = pages;


                this.goto(1);


            },


            async obtenerTramitesAgregados(){
            	this.obteniendoTramites = true;

                let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-info/" + this.idUsuario;
                try {
                    let response = await axios.get(url);
                    let notary_offices = response.data.notary_offices;
                    let tramites =  response.data.tramites ;
                    this.construirJSONTramites( tramites );
                    this.obteniendoTramites = false;
                } catch (error) {
                    console.log(error);
                    this.obteniendoTramites = false;
                }
                //this.loading = false;
            },

            async obtenerCosto( data ){
                let url = process.env.APP_URL + "/getcostoTramite";                
                try {
                    let response = await axios.post(url, data);
                    let detalleTramite = response.data;
                    
                    return detalleTramite[0];
                } catch (error) {
                    console.log(error);
                    return false;
                }
            },

            async construirJSONTramites( tramites ){
            	let listadoTramites = [];
            	let requestCostos = [];
            	let contadorSolicitantes = 0;
			    tramites.forEach(  tramiteInarray => {
					
					tramiteInarray.solicitudes.forEach(  soliciante => {
						let tramitesJson = {};
						tramitesJson.nombre = tramiteInarray.tramite;
						tramitesJson.id_seguimiento = tramiteInarray.tramite_id;
						tramitesJson.id_tipo_servicio = 397;//tramiteInarray.tramite_id;//397;//
						tramitesJson.id_tramite = soliciante.clave;
						tramitesJson.auxiliar_1 = "";
						tramitesJson.auxiliar_2 = "";
						tramitesJson.auxiliar_3 = "";
						tramitesJson.importe_tramite = '<div id="spinner-pago" class="spinner-border spinner-border-sm float-right" role="status" ><span class="sr-only">Loading...</span>	</div>'
						let info = JSON.parse(soliciante.info);
						let solicianteInfo = info.solicitante;

						tramitesJson.detalle = [];

						tramitesJson.detalle[0] = { 
							concepto : info.partida ? info.partidas[0].descripcion : "Descripcion opcional",
							partida: info.partida ? info.partidas[0].id_partida : 654656546,
							importe_concepto:1						
						}

						tramitesJson.datos_solicitante = {
					        "nombre": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.nombreSolicitante,
					        "apellido_paterno": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.apPat,
					        "apellido_materno": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.apMat,
					        "razon_social": solicianteInfo.tipoPersona == "pm" ? solicianteInfo.razonSocial : "",
					        "rfc": solicianteInfo.rfc,
					        "curp": solicianteInfo.curp || "",
					        "email": solicianteInfo.email|| "",
					        "calle": solicianteInfo.calle|| "",
					        "colonia":solicianteInfo.colonia|| "",
					        "numexterior": solicianteInfo.numexterior|| "",
					        "numinterior": solicianteInfo.numinterior|| "",
					        "municipio": solicianteInfo.municipio|| "",
					        "codigopostal": solicianteInfo.codigopostal|| "",
					    }

					    tramitesJson.datos_factura = tramitesJson.datos_solicitante;

						let data = {  
		                    valor_catastral: info.valor_catastral || 0,
		                    id_seguimiento: soliciante.clave,
		                    tramite_id: tramiteInarray.tramite_id,
		                    valor_operacion: info.valor_de_operacion || 0,
		                    oficio:62
                		}
                		
                		let url = process.env.APP_URL + "/getcostoTramite";

                		requestCostos.push(axios.post(url, data,{headers:{
                			contadorSolicitantes:contadorSolicitantes
                		}}));
                		

						listadoTramites.push( tramitesJson );
						contadorSolicitantes=contadorSolicitantes+1;


					});

			    });

	    		this.tramites = listadoTramites;

				this.tramitesFiltrados = this.tramites;
				let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
			    let pages = [];

	            for (var i = 0; i < pagesTotal; i++) {
	                pages.push( i + 1 );
	            }
	            this.pages = pages;
	            this.pagination(1);

			    axios.all(requestCostos).then(axios.spread((...responses) => {

					responses.forEach( respuesta => {

						let indiceTramite = respuesta.config.headers.contadorSolicitantes;
						listadoTramites[indiceTramite].importe_tramite = respuesta.data ? respuesta.data[0].costo_final : 1;


						listadoTramites[indiceTramite].detalle[0].importe_concepto = listadoTramites[indiceTramite].importe_tramite;
/*
						let descuento =  respuesta.data ? respuesta.data[0].descuentos[0] : false;
						if( descuento ){
							if(listadoTramites[indiceTramite].detalle){
								listadoTramites[indiceTramite].detalle[0].importe_concepto = descuento.importe_concepto;
							}  else {
								listadoTramites[indiceTramite].detalle[0].importe_concepto = listadoTramites[indiceTramite].importe_tramite;;
							}
							
						}else {
							listadoTramites[indiceTramite].detalle[0].importe_concepto = listadoTramites[indiceTramite].importe_tramite;
						}*/
						
					});
					  // use/access the results 
				})).catch(errors => {
				  console.log( errors )
				}).finally( () =>{
					console.log("termino de consulttar")
/*
					listadoTramites = listadoTramites.filter( elTramite => { 

						return elTramite.importe_tramite > 0 && elTramite.detalle && elTramite.detalle[0].concepto != "No aplica"
					});*/
//console.log( JSON.parse( listadoTramites ) )

					//this.tramites = listadoTramites;
					//this.tramitesFiltrados = this.tramites;

					let total = 0;
					this.tramites.forEach(tramite => total = total + tramite.importe_tramite );
 					this.totalImporte = total;
/*
					let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
				    let pages = [];

		            for (var i = 0; i < pagesTotal; i++) {
		                pages.push( i + 1 );
		            }
		            this.pages = pages;
		            this.pagination(1);*/
				} )

			    

            }

		}

    }
</script>