<template>

    <div>
       <div class="d-flex align-items-center mb-3" :id="idItem">
            <!----> 
            <div class="mr-auto" style="width: 60%;">
                <h4 >
                    <strong class="ml-3 text-uppercase text-truncate">
                    {{ agrupacion.nombre }} 
                    </strong>
                </h4>
                <h5 class="ml-3 text-muted">
                    {{ agrupacion.clave }}
                </h5>
                <span class="ml-3" style="font-size: 12px;"  v-if="totalItemInGroup  == 1 && agrupacion.items[0].datos_solicitante">
                   {{ agrupacion.items[0].datos_solicitante.rfc || agrupacion.items[0].datos_solicitante.curp || "" }} - {{ agrupacion.items[0].datos_solicitante.razon_social ? agrupacion.items[0].datos_solicitante.razon_social : agrupacion.items[0].datos_solicitante.nombre + " " + agrupacion.items[0].datos_solicitante.apellido_paterno + " " + agrupacion.items[0].datos_solicitante.apellido_materno }}
                </span>
            </div>
            <div class="my-lg-0 my-1">
                <button type="button" class="btn btn-sm mr-2 btn-primary" v-on:click="eliminar()" :disabled="desabilitar">
                    <span><i class="fas fa-trash" v-if="totalItemInGroup > 0"></i> ELIMINAR ({{  totalItemInGroup }})</span>
                </button> 
                <span class="btn btn-secondary mr-2"> {{ total | toCurrency }} </span> 
                <button class="btn btn-secondary" type="button" data-toggle="collapse" :data-target="`#collapse-${index}`" aria-expanded="false" :aria-controls="`collapse-${index}`" v-if="totalItemInGroup >1 ">
                    <i class="fas fa-chevron-down p-0"></i>
                </button>
            </div>
       </div>

       <div :id="`collapse-${index}`"  v-bind:class="totalItemInGroup > 1 ? 'collapse' : ''" v-if="totalItemInGroup >1 ">
          <div v-bind:class="totalItemInGroup > 1 ? 'card' : ''" class="list-item card-custom gutter-b col-lg-12"  v-for="(item, i) in agrupacion.items" >
             <div class="card-body p-0">
                <div class="d-flex">
                   <div class="flex-grow-1">
                      <div class="d-flex align-items-center justify-content-between flex-wrap" >
                         <!----> 
                         <div class="mr-auto" style="width: 60%;">
                            <a class="d-flex text-dark over-primary font-size-h5 font-weight-bold mr-3 flex-column">
                                <span class="mt-3" style="font-size: 12px;"  v-if="item.datos_solicitante">
                                   {{ item.datos_solicitante.rfc || item.datos_solicitante.curp || "" }} - {{ item.datos_solicitante.razon_social ? item.datos_solicitante.razon_social : item.datos_solicitante.nombre + " " + item.datos_solicitante.apellido_paterno + " " + item.datos_solicitante.apellido_materno }}
                                </span>
                            </a>
                         </div>
                         <div class="my-lg-0 my-1" >
                            <span class="btn btn-secondary mr-2">
                                {{item.importe_tramite | toCurrency}}                              
                            </span>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
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
					user_id: user.id
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

