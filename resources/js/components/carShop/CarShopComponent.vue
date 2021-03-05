<template>	                
    <div class="container-fluid" id="cart-container">
		<div class="row">
		    <!--Grid column-->
		    <div class="col-lg-8">
		      	<!-- Card -->
		      	<div v-if="!mostrarMetodos && !mostrarReciboPago0">
		      		<v-container v-if="loading">
		                <v-row>
		                    <v-col cols="12" md="12">
		                        <v-skeleton-loader
		                            class="card card-custom justify-content-center"
		                            type="list-item-two-line, button"
		                            v-for="(r,i) in [1,2,3,4,5,6]"
		                            v-bind:key="i"
		                            height="90px"
		                            style="margin-bottom: 8px;"
		                        ></v-skeleton-loader>
		                    </v-col>
		                </v-row>
		            </v-container>
		            <div class="w-100" v-if="!loading">
		                <pagination-component
		                	:type="type"
		                	@processDelete="processDelete"
		                	:items="tramitesFiltrados"
		                	:tramitesCart="tramitesCart"
		                	:cartComponent="true"
		                ></pagination-component>
		            </div>
		      		<!-- <v-container v-if="obteniendoTramites">
		                <v-row>
		                    <v-col cols="12" md="12">
		                        <v-skeleton-loader v-bind:key="i" type="list-item" v-for="(r,i) in [1,2,3,4,5,6]" height="90px" style="margin-bottom: 8px;"></v-skeleton-loader>
		                    </v-col>
		                </v-row>
		            </v-container>
		            <div v-if="!obteniendoTramites && items.length > 0">
		        		<div class="container-fluid mb-4 mb-3 shadow-sm p-3 bg-white rounded" v-for="(item, index) in items" :key="index"  >
		        			<agrupacion-items-carrrito-component :agrupacion="item" :index="index" :idUsuario="idUsuario"
		        			@updatingParent="updateList" ></agrupacion-items-carrrito-component>
		        		</div>
			        	<div class="card card-custom">
	                    	<div class="card-body py-7">
		                        {{<--begin::Pagination--}
		                        <div class="d-flex justify-content-between align-items-center flex-wrap">
		                            <div class="d-flex flex-wrap mr-3" >
										<b-pagination
										  v-model="currentPage"
										  :total-rows="totalListTramites"
										  :per-page="porPage"
										  aria-controls="itemList"
										  align="center"></b-pagination>
		                            </div>

		                            <div class="d-flex align-items-center">
		                                <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" v-model="porPage">
		                                    <option value="5">5</option>
		                                    <option value="30">30</option>
		                                </select>
		                            </div>
		                        </div>
		                        {{<--end:: Pagination--}
		                    </div>
		                </div>
		            </div> -->

		        	<!-- <div v-else-if="!obteniendoTramites && items.length == 0">
		        		<div class="card" style="width: 100%;">
						  <div class="card-body text-center">
						    <h5 class="card-title" >Aún no haz iniciado algún trámite</h5>
						    Para continuar da click <a  class="card-link"  v-on:click="iniciarTramite()"> <span style="cursor: pointer;"> aquí </span> </a>
						  </div>
						</div>
		        	</div> -->
		      	</div>
		      	<!-- Card -->
      			<metodos-pago-component :infoMetodosPago="infoMetodosPago" v-if="mostrarMetodos"></metodos-pago-component>
      			<b-row v-if="mostrarReciboPago0" >
      				<iframe width="100%" height="880" :src="reciboPagoCeroURL"></iframe>
      			</b-row>
		    </div>
		    <!--Grid column-->
		    <!--Grid column-->
		    <div class="col-lg-4" >
	    		<v-container v-if="obteniendoTramites">
	                <v-row>
	                    <v-col cols="12" md="12">
	                        <v-skeleton-loader v-bind:key="i" type="list-item" v-for="(r,i) in [1]" height="150px" style="margin-bottom: 8px;"></v-skeleton-loader>
	                    </v-col>
	                </v-row>
	            </v-container>
        		<detalle-pago-component v-if="tramites.length > 0" 
        			:tramites="tramites" 
        			:obtenidoCostos="costosObtenidos" @updatingParent="recibirMetodosPago" @cancelarPago="cancelarPago" >
        		</detalle-pago-component>
		    </div>
		    <!--Grid column-->
		</div>
		<!-- Grid row -->
    </div>
</template>
<script>
    export default {
    	// props: ['type'],
    //     computed:{
    //         totalListTramites(){
    //             return this.items.length;
    //         },
    //         items(){
    //         	let tramitesAgrupados = [];
    //         	this.tramites.forEach( tramite => {
    //         		let item = { nombre: tramite.nombre, clave: tramite.calveTemp, items:[tramite], verDetalle:false };
    //         		let indice = tramitesAgrupados.findIndex( agrupado => agrupado.clave == tramite.calveTemp );
    //         		if( indice < 0 ){
    //         			tramitesAgrupados.push( item );
    //         		} else {
    //         			tramitesAgrupados[indice].items.push( tramite )
    //         		}
    //         	});
				// return tramitesAgrupados.slice((this.currentPage - 1) * this.porPage,this.currentPage * this.porPage);       	
    //         }
    //     },
        // data() {
        //     return {
        //     	tramites:[],
        //     	mostrarMetodos:false,
        //     	infoMetodosPago:{},
        //     	porPage : 5, currentPage :1,
        //     	obteniendoTramites:false,
        //     	costosObtenidos:false,
        //     	mostrarReciboPago0:false,
        //     	reciboPagoCeroURL:'',
        //     	loading: false,
        //     	tramitesFiltrados: [],
        //     	strBusqueda : '',
        //     	pages : 1
        //     }
        // },
  
        data() {
            return {
                type : null,
                tramites: [], tramitesArr: [],loading:true, porPage : 10, pages:[0], currentPage :1, strBusqueda:"", totalTramites:0, tramitesFiltrados:[], tramitesCart : [],
                mostrarMetodos:false,
				infoMetodosPago:{},
				obteniendoTramites:false,
				costosObtenidos:false,
				mostrarReciboPago0:false,
				reciboPagoCeroURL:'',
				// recibirMetodosPago:false,
				// cancelarPago:false,
                ...this.$attrs
            }
        },

        created() {
        	this.obtenerTramites();
        },
        methods: {
            processDelete(tramite) {
            	console.log('emit');
            	this.obtenerTramites();
            },
            addToCart(status){
                let ids = this.tramitesCart.map(ele => ele.id);
                let onCart = parseInt($('#totalTramitesCarrito').text());
                fetch(`${process.env.TESORERIA_HOSTNAME}/solicitudes-guardar-carrito`, {
                    method : 'POST',
                    body: JSON.stringify({ ids, status, type : 'en_carrito', user_id: user.id })
                })
                .then(res => res.json())
                .then(res => {
                    if(res.code === 200){
                        this.tramitesCart.map(tramite => {
                            onCart = status ? onCart+1 : onCart-1;
                            tramite.en_carrito = status;
                            $(`input[type=checkbox]#${tramite.id}`).prop('checked', false);
                        })

                        this.tramitesCart = [];
                        $('#totalTramitesCarrito').text(onCart);
                        this.obtenerTramites();
                    }
                });
            },
            async obtenerTramites(){
                let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-filtrar";
                try {
                    let data = {
                        id_usuario : user.id,
                        en_carrito : true
                    };

                    let response = await axios.post(url, data);
                    this.tramitesArr = response.data;
                    this.construirJSONTramites(response.data);
                    // this.tramitesFiltrados = this.tramites;
                    this.tramitesFiltrados = this.tramitesArr.filter( tramite => tramite.titulo.toLocaleLowerCase().includes(this.strBusqueda.toLocaleLowerCase()) ) ;
                    this.tramitesFiltrados.map(tramite => {
                        tramite.created_at = moment(tramite.created_at).format("MMMM Do YYYY, hh:mm A")
                    })
                    let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
                    let pages = [];

                    for (var i = 0; i < pagesTotal; i++) {
                        pages.push( i + 1 );
                    }
                    this.pages = pages;
                } catch (error) {
                    console.log(error);
                }

                this.loading = false;
            },

            search(){
                this.calcularPage()
                this.currentPage = 1;
                this.pagination(1);
            },

  //       	updateList(  data ){
  //               let nuevaListaTTramites = this.tramites.filter( tramite => {      	 
  //               	let itemEliminado = data.idsDelete.find( id => {
  //               		return id == tramite.idSolicitante; 
  //               	});
  //               	return !itemEliminado;
  //               });
  //               this.tramites = nuevaListaTTramites;
  //       	},

        	cancelarPago(){
        		this.mostrarMetodos = !this.mostrarMetodos;
        	},

  //           async obtenerTramitesAgregados(){
  //           	this.obteniendoTramites = true;

  //               let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-info/" + user.id;
  //               try {
  //                   let response = await axios.get(url);
  //                   let notary_offices = response.data.notary_offices;
  //                   let tramites =  response.data.tramites ;
  //                   this.construirJSONTramites( tramites );
                    
  //               } catch (error) {
  //                   console.log(error);
  //                   this.obteniendoTramites = false;
  //               }
  //           },

  //           async obtenerTramites(){
  //               try {
  //                   let response = await axios.post(`${process.env.TESORERIA_HOSTNAME}/solicitudes-filtrar`, {
  //                   	id_usuario : user.id,
  //                   	en_carrito : true
  //                  	});
  //                   this.tramites = response.data;
  //                   this.tramitesFiltrados = this.tramites.filter( tramite => tramite.titulo.toLocaleLowerCase().includes(this.strBusqueda.toLocaleLowerCase()) ) ;
  //                   this.tramitesFiltrados.map(tramite => {
  //                       tramite.created_at = moment(tramite.created_at).format("MMMM Do YYYY, hh:mm A")
  //                   })
  //                   console.log('tramitesFiltrados', this.tramitesFiltrados);
  //                   let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
  //                   let pages = [];

  //                   for (var i = 0; i < pagesTotal; i++) {
  //                       pages.push( i + 1 );
  //                   }
  //                   this.pages = pages;
  //               } catch (error) {
  //                   console.log(error);
  //               }

  //               this.loading = false;
  //           },


			recibirMetodosPago( response ){
				if(response.data.response.pago_cero){
					this.mostrarReciboPago0 = true;
					this.reciboPagoCeroURL = response.data.response.pago_cero;
					this.cambiarStatusTransaccion(0,response.data.response.folio);
				} else {
		            this.infoMetodosPago = response.data.response;
	            	this.mostrarMetodos = true;					
				}

			},

		// 	cambiarStatusTransaccion(status, id_transaccion_motor){
  //               let data ={
  //                   id_transaccion_motor,
  //                   status
  //               }
  //               let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-update-status-tramite";
  //               axios.post(url, data, {
  //                    headers:{
  //                       "Content-type":"application/json"
  //                   }
  //               } ).then(response => {
  //                   console.log("cambiando estatus")
  //                   console.log(response)
  //               });
  //           },

            extraerDatosPersonalesSolicitante(solicitante){
				let datos_solicitante = {
			        "nombre": solicitante.tipoPersona == "pm" ? "" : solicitante.nombreSolicitante || "",
			        "apellido_paterno": solicitante.tipoPersona == "pm" ? "" : solicitante.apPat || "",
			        "apellido_materno": solicitante.tipoPersona == "pm" ? "" : solicitante.apMat || "",
			        "razon_social": solicitante.tipoPersona == "pm" ? solicitante.razonSocial : "",
			        "rfc": solicitante.rfc,
			        "curp": solicitante.curp || "",
			        "email": solicitante.email|| "",
			        "calle": solicitante.calle|| "",
			        "colonia":solicitante.colonia|| "",
			        "numexterior": solicitante.numexterior|| "",
			        "numinterior": solicitante.numinterior|| "",
			        "municipio": solicitante.municipio|| "",
			        "codigopostal": solicitante.codigopostal|| "",
			    }
			    return datos_solicitante;
            },

            extraerDatosPersonalesEnajentante(enajenante){
				let datos_solicitante = {
			        "nombre": enajenante.tipoPersona == "pm" ? "" : enajenante.datosPersonales.nombre || "",
			        "apellido_paterno": enajenante.tipoPersona == "pm" ? "" : enajenante.datosPersonales.apPat || "",
			        "apellido_materno": enajenante.tipoPersona == "pm" ? "" : enajenante.datosPersonales.apMat || "",
			        "razon_social": enajenante.tipoPersona == "pm" ? enajenante.datosPersonales.razonSocial : "",
			        "rfc": enajenante.datosPersonales.rfc,
			        "curp": enajenante.tipoPersona == "pm" ? "" : enajenante.datosPersonales.curp  || "",
			        "email": "-",
			        "calle": "-",
			        "colonia": "-",
			        "numexterior": "-",
			        "numinterior": "-",
			        "municipio":  "-",
			        "codigopostal":"-",
			    }
			    return datos_solicitante;
            },

            obtenerDatosSolicitante(soliciante){
            	if(soliciante.info.hasOwnProperty('enajenante')){
            		return this.extraerDatosPersonalesEnajentante(soliciante.info.enajenante);
            	} else if(soliciante.info.hasOwnProperty('solicitante')){
            		return this.extraerDatosPersonalesSolicitante(soliciante.info.solicitante);
            	} else {
            		return {};
            	}
            },

            async construirJSONTramites( tramites ){
            	let listadoTramites = [];
            	let requestCostos = [];

			    tramites.forEach(  tramiteInarray => {
					let tramitesJson = {};
					tramitesJson.nombre = tramiteInarray.nombre_servicio;
					tramitesJson.id_seguimiento = tramiteInarray.tramite_id;
					tramitesJson.id_tipo_servicio = tramiteInarray.tramite_id;//397;//
					tramitesJson.idSolicitante = tramiteInarray.id; 
					tramitesJson.id_tramite = tramiteInarray.id;//soliciante.clave;

					tramitesJson.calveTemp = tramiteInarray.clave;//soliciante.clave;

					tramitesJson.auxiliar_1 = "";
					tramitesJson.auxiliar_2 = "";
					tramitesJson.auxiliar_3 = "";
					tramitesJson.importe_tramite = "";

					let { info } = tramiteInarray;
					if(info.hasOwnProperty('enajenante') && (info.hasOwnProperty('solicitante') ) ){
						let solicitanteInfo = info.solicitante;
						tramitesJson.auxiliar_1  = (solicitanteInfo.nombreSolicitante || '') + " " + (solicitanteInfo.apPat || '' )+ " " + (solicitanteInfo.apMat || '');
					}

					tramitesJson.datos_solicitante = this.obtenerDatosSolicitante(tramiteInarray);
					tramitesJson.datos_factura = tramitesJson.datos_solicitante;

					if( info.camposComplementaria && info.detalle && info.detalle.Complementaria){
						tramitesJson.importe_tramite = info.detalle.Complementaria['Cantidad a cargo'] ;
					} else {
						tramitesJson.importe_tramite = info.detalle && info.detalle.Salidas ?  info.detalle.Salidas['Importe total'] : info.costo_final ;
					}
					tramitesJson.detalle = [];

					tramitesJson.detalle[0] = { 
						concepto : info.partidas ? info.partidas[0].descripcion : tramitesJson.nombre,//ponere nombre tramite
						partida: info.partidas ? info.partidas[0].id_partida : null,
						importe_concepto:tramitesJson.importe_tramite					
					}

					let descuentosAplicados = [];
					if(info.detalle && info.detalle.descuentos && Array.isArray(info.detalle.descuentos )  && info.detalle.descuentos.length > 0  ){

						let losdescuentos = info.detalle.descuentos.filter( descuento => descuento.concepto_descuento != "No aplica" );		
						losdescuentos = info.detalle.descuentos.filter( descuento => descuento.concepto_descuento != "El numero de oficio no coincide con el trámite" );		
						if( losdescuentos && losdescuentos.length > 0 ){
							info.detalle.descuentos.forEach( descuento => {
								let descuentoAplicado =  {
									concepto_descuento: descuento.concepto_descuento,
									importe_descuento: descuento.importe_subsidio,
									partida_descuento: descuento.partida_descuento
								}
								descuentosAplicados.push( descuentoAplicado )
							});
							tramitesJson.detalle[0].descuentos = descuentosAplicados;								
						}

					}

					let find = this.tramitesArr.find(ele => ele.id === tramiteInarray.id);
					find.detalle = tramitesJson.detalle;
					find.importe_tramite = tramitesJson.importe_tramite;

					listadoTramites.push( tramitesJson );
			    });

	    		this.tramites = listadoTramites;
				this.obteniendoTramites = false;
				this.costosObtenidos = true;
            },

  //           iniciarTramite(){
  //           	redirect("/nuevo-tramite");
  //           }

		}

    }
</script>