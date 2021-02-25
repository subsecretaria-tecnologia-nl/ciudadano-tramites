<template>
    <div class="card list-item card-custom gutter-b col-lg-12" >
        <div class="card-body">
            <!--begin::Top-->
            <div class="d-flex">
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex align-items-center justify-content-between flex-wrap mt-2">
                        <!--begin::User-->
                        <div class="mr-3">
                            <!--begin::Name-->
                            <a v-on:click="goTo(tramite)" class="d-flex text-dark over-primary font-size-h5 font-weight-bold mr-3 flex-column">
                                <strong class="text-uppercase">{{ tramite.nombre_servicio && (tramite.titulo && tramite.nombre_servicio.toLowerCase() != tramite.titulo.toLowerCase()) ? `${tramite.nombre_servicio} - ` : '' }}{{ tramite.tramite || tramite.titulo | capitalize }}</strong>
                                <span class="text-muted" v-if="tramite.info">{{ tramite.id || '' }} - {{ tramite.clave }}</span>
                                <span class="text-muted" v-if="tramite.info">{{ tramite.created_at }}</span>
                                <span class="mt-3" v-if="tramite.info">{{ tramite.info.solicitante ? tramite.info.solicitante.rfc : "" }} - {{ tramite.info.solicitante ? (tramite.info.solicitante.tipoPersona == "pm" ? tramite.info.solicitante.razonSocial : `${tramite.info.solicitante.nombreSolicitante} ${tramite.info.solicitante.apPat} ${tramite.info.solicitante.apMat}`) : '' }}</span>
                            </a>
                            <!--end::Name-->
                        </div>
                        <!--begin::User-->
                        <!--begin::Actions-->
                        <div class="my-lg-0 my-1">
                            <button v-on:click="addToCart(tramite)" v-if="tramite.status == 99" type="button" class="btn btn-sm mr-2" :class="tramite.en_carrito ? 'btn-primary' : 'btn-outline-primary'">
                                <span v-if="tramite.loading"><i class="fas fa-spinner fa-spin"></i></span>
                                <span v-if="!tramite.loading"><i :class="tramite.en_carrito == 1 ? 'fas fa-check-circle' : 'fas fa-plus-circle'"></i> {{ tramite.en_carrito == 1 ? 'QUITAR DEL CARRITO' : 'AGREGAR AL CARRITO' }}</span>
                            </button>
                            <span v-if="tramite.info && tramite.descripcion" class="btn btn-secondary mr-2">{{ tramite.descripcion || "CERRADO" }} </span>
                            <a v-on:click="goTo(tramite)" class="btn btn-sm btn-primary font-weight-bolder text-uppercase text-white" v-if="!tramite.info">
                                INICIAR TRAMITE
                            </a>
                            <div class="btn-group" v-if="tramite.info">
                                <a v-on:click="goTo(tramite)" class="btn btn-sm btn-primary font-weight-bolder text-uppercase text-white" :class="files.length == 0 ? 'rounded' : ''">
                                    <span v-if="tramite.mensajes.length > 0" class="text-white">VER MENSAJES ({{ tramite.mensajes.length }})</span>
                                    <span v-if="tramite.mensajes.length == 0" class="text-white">VER DETALLES</span>
                                </a>
                                <button v-if="files.length > 0" type="button" class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a v-for="(file, ind) in files" class="dropdown-item" href="{file}" :key="ind"><i class="fas fa-download mr-2"></i> {{ file }}</a>
                                </div>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Info-->
            </div>
            <!--end::Top-->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                files : []
            }
        },
        props: ['tramite'],
        mounted() {
            this.files = [];
            if(this.tramite.info)
                this.tramite.info = JSON.parse(this.tramite.info)
            if(this.tramite.mensajes && this.tramite.mensajes.length > 0){
                this.tramite.mensajes.map(msg => {
                    if(msg.attach != "")
                        this.files.push(msg.attach);
                })
            }
            this.tramite.loading = false;
        },

        methods:{
            goTo(tramite){
                if(window.location.href.indexOf("borradores") >= 0){
                    redirect("detalle-tramite/" + tramite.tramite_id + "?clave=" + tramite.clave );
                } else {
                    redirect(`/detalle${ tramite.id_tramite ? "-tramite" : "" }/` +  (tramite.id_tramite || tramite.id));
                }
                
            },
            addToCart(tramite){
                let status = tramite.en_carrito != 1 ? 1 : null;
                let onCart = parseInt($('#totalTramitesCarrito').text());
                onCart = status ? onCart+1 : onCart-1;

                tramite.loading = true;
                fetch(`${process.env.TESORERIA_HOSTNAME}/solicitudes-guardar-carrito`, {
                    method : 'POST',
                    body: JSON.stringify({ ids : [ tramite.id ], status })
                })
                .then(res => res.json())
                .then(res => {
                    if(res.code === 200){
                        tramite.en_carrito = status;
                        console.log(onCart);
                        $('#totalTramitesCarrito').text(onCart);
                    }
                    tramite.loading = false;
                });
            }
        }
    }
</script>


