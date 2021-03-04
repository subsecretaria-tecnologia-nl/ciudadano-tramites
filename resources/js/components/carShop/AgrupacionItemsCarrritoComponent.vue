<template>
    <div class="col-md-12 col-lg-12 col-xl-12" :id="idItem">
        <b-container fluid>
            <b-row>
                <h5> {{ agrupacion.nombre }} </h5>
                <hr>
            </b-row>
            <b-row cols="12">
                <b-col lg="2">
                    <button  type='button' class='card-link-secondary small text-uppercase mr-3' v-on:click="eliminar()" :disabled="desabilitar" >
                        <i class='fas fa-trash-alt mr-1'></i>Eliminar 
                        <div :id="`spinner-pago-solicitud-${index}`"  class="spinner-border spinner-border-sm float-right" role="status" style="display: none;">
                            <span class="sr-only">Loading...</span> 
                        </div>
                    </button>
                </b-col>

                <b-col lg="6" class="text-right">
                    <strong title="Total"> 
                    	<h4>
                        	{{total | toCurrency}}
                    	</h4>
                    </strong>
                </b-col>
                <b-col lg="4" class="text-right">
                	<span class="badge badge-pill badge-success" title="N° de Items">{{totalItemInGroup}}</span> 
                </b-col>
            </b-row>
            <b-row>
            	<link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">

				<b-button  title="Click para ver detalles" variant="outline-info" @click="verDetalle" class="mr-2 btn btn-block" size="sm"  :disabled="desabilitar">
					 <transition>
				    	<span v-if="agrupacion.verDetalle">
				    		Ocultar detalle
				    	</span>
				    	<span v-if="!agrupacion.verDetalle">
				    		Ver detalle
				    	</span>
				  </transition>  
				</b-button>
   
              <div class="col-sm-12">
                <b-card no-body v-if="agrupacion.verDetalle" >
                    <b-card-body id="nav-scroller" ref="content">
                         <b-table  responsive  hover :items="itemCamposShow" :fields="campos" style=" height:300px; overflow-y:scroll;"> 
                                <template #cell(datos_solicitante)="data">
                                    <template-datos-personales-component :datosPersonales="data.item.datos_solicitante"></template-datos-personales-component>
                                </template>
                                <template #cell(importe_tramite)="data">
                                    	{{ data.item.importe_tramite | toCurrency }}
                                </template>
                         </b-table>
                    </b-card-body> 
                </b-card>

              </div>    

            </b-row>
        </b-container>
    </div>
</template>

<script>
	import { uuid } from 'vue-uuid';
    export default {
        props: ['agrupacion', 'index', 'idUsuario'],
        data(){
            return {
                campos:['datos_solicitante', 'importe_tramite'],
                desabilitar:false,
                idItem:null
            }
        },
        mounted() {
        	this.idItem = uuid.v4();
        },

        computed:{
            totalItemInGroup(){
                return this.agrupacion.items.length;
            },
            total(){
                var total = 0;
                this.agrupacion.items.forEach(tramite => total = total + parseFloat(tramite.importe_tramite) );
                return total;
            },

            itemCamposShow(){
            	return this.agrupacion.items.map( item => {
            		let itemSHow = { importe_tramite:item.importe_tramite, datos_solicitante:item.datos_solicitante }
            		return itemSHow;
            	});

            }
        },
        methods: {
            eliminar(){
            	let idsDelete = this.agrupacion.items.map( solicitud =>{ return solicitud.idSolicitante });
                let data = {
					status : null,
					ids : idsDelete,
					type : "en_carrito",
					user_id: this.idUsuario
                }


                //$("#spinner-pago-solicitud-" + this.idItem ).show();
                let url = process.env.TESORERIA_HOSTNAME +  "/solicitudes-guardar-carrito";
                let elItem = this;
                axios.post(url, data).then(response => {
                    let res = { response, idsDelete };
                    this.$emit('updatingParent', res);
                    let totalCarritoActual = parseInt( $("#totalTramitesCarrito" ).text( ));
                    $("#totalTramitesCarrito" ).text( totalCarritoActual - idsDelete.length  );
                }).catch(error => {
                    console.log("no fue posible eliminar la solicitud");
                    console.log(error)
                }).finally( () => {
                    //$("#spinner-pago-solicitud-" + this.solicitud.idSolicitante ).hide();
                });
            },

            verDetalle(){
            	this.agrupacion.verDetalle =  !this.agrupacion.verDetalle;
            	this.$forceUpdate();
            }


        }
    }
</script>

