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
		                        <v-skeleton-loader v-bind:key="i" type="list-item" v-for="(r,i) in [1,2,3,4,5,6]" height="90px" style="margin-bottom: 8px;"></v-skeleton-loader>
		                    </v-col>
		                </v-row>
		            </v-container>
		            <div v-if="!obteniendoTramites && tramitesPaginados.length > 0">
		        		<div class="container-fluid mb-4 mb-3 shadow-sm p-3 bg-white rounded" id="listTramites" v-for="(tramite, index) in tramitesPaginados"   >
							<item-solictud-carshop-component 
								:solicitud="tramite"
								@updatingParent="updateList" 
								:index="index">
							 </item-solictud-carshop-component>
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

		        	<div v-else-if="!obteniendoTramites && tramitesPaginados.length == 0">
		        		<div class="card" style="width: 60rem;">
						  <div class="card-body text-center">
						    <h5 class="card-title" >Aún no haz iniciado algún trámite</h5>
						    Para continuar da click <a  class="card-link"  v-on:click="iniciarTramite()"> <span style="cursor: pointer;"> aquí </span> </a>
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
        		<detalle-pago-component 
        			:tramites="tramites" 
        			:obtenidoCostos="costosObtenidos" @updatingParent="recibirMetodosPago"  @cancelarPago="cancelarPago" >
        		</detalle-pago-component>
		    </div>
		    <!--Grid column-->
		</div>
		<!-- Grid row -->
    </div>
</template>
<script>
    export default {
    	props: ['idUsuario'],

        data() {
            return {
            	tramites:[],
            	mostrarMetodos:false,
            	infoMetodosPago:{},
            	porPage : 10, pages:[0], currentPage :1, tramitesPaginados:{},
            	obteniendoTramites:false,
            	costosObtenidos:false
            }
        },
  
        mounted() {
        	this.obtenerTramitesAgregados();
        },


        methods: {
        	updateList(  data ){
    		    this.tramites.splice( data.index, 1 );
                this.tramitesFiltrados = this.tramites;
                let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
                let pages = [];
                for (var i = 0; i < pagesTotal; i++) {
                    pages.push( i + 1 );
                }
                this.pages = pages;
                this.pagination(1);
        	},

        	cancelarPago(){
        		this.mostrarMetodos = !this.mostrarMetodos;
        	},

	    	pagination( page ){
                let porPageInt = parseInt(this.porPage);
                let indiceInicial = (page - 1 ) * porPageInt;
                let indiceFinal =   ( (page - 1 ) * porPageInt  )  + porPageInt;
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
                let pagesTotal = Math.ceil( this.tramites.length  / this.porPage);
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
                    
                } catch (error) {
                    console.log(error);
                    this.obteniendoTramites = false;
                }
            },


			recibirMetodosPago( response ){
	            this.infoMetodosPago = response.data.response;
	            this.mostrarMetodos = true;
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
						tramitesJson.idSolicitante = soliciante.id; 
						tramitesJson.id_tramite = soliciante.id;//soliciante.clave;
						tramitesJson.auxiliar_1 = "";
						tramitesJson.auxiliar_2 = "";
						tramitesJson.auxiliar_3 = "";
						tramitesJson.importe_tramite = '';
						let info = JSON.parse(soliciante.info);
						let solicianteInfo = info.solicitante;

						tramitesJson.detalle = [];

						tramitesJson.detalle[0] = { 
							concepto : info.partida ? info.partidas[0].descripcion : "Descripcion opcional",
							partida: info.partida ? info.partidas[0].id_partida : 654656546,
							importe_concepto:1						
						}

						tramitesJson.datos_solicitante = {
					        "nombre": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.nombreSolicitante || "",
					        "apellido_paterno": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.apPat || "",
					        "apellido_materno": solicianteInfo.tipoPersona == "pm" ? "" : solicianteInfo.apMat || "",
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
		                    valor_catastral: info.campos["Valor catastral"] || 0,
		                    id_seguimiento: soliciante.clave,
		                    tramite_id: tramiteInarray.tramite_id,
		                    valor_operacion: info["Valor de operacion"] || 0,
		                    oficio:62
                		}
                		
                		let url = process.env.APP_URL + "/getcostoTramite";
                		requestCostos.push(axios.post(url,   data,{headers:{
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
						
					});
				})).catch(errors => {
				  console.log( errors )
				}).finally( () =>{
					console.log("termino de consulttar")
					this.obteniendoTramites = false;
					this.costosObtenidos = true;
				});
            },

            iniciarTramite(){
            	redirect("/nuevo-tramite");
            }

		}

    }
</script>