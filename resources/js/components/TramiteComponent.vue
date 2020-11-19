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
                            <a v-bind:href="'detalle-tramite/'+ tramite.id_tramite" class="d-flex text-dark over-primary font-size-h5 font-weight-bold mr-3 flex-column">
                                <strong>{{ (tramite.tramite || tramite.titulo) | capitalize }}</strong>
                                <span class="text-muted" v-if="tramite.info">{{ tramite.clave }}</span>
                                <span class="mt-3" v-if="tramite.info">{{ tramite.info.solicitante ? tramite.info.solicitante.rfc : "" }} - {{ tramite.info.solicitante && tramite.info.solicitante.tipoPersona == "pm" ? tramite.info.solicitante.razonSocial : tramite.info.solicitante.razonSocial }}</span>
                            </a>
                            <!--end::Name-->
                        </div>
                        <!--begin::User-->
                        <!--begin::Actions-->
                        <div class="my-lg-0 my-1">
                            <span v-if="tramite.info" class="btn btn-secondary mr-2">{{ tramite.descripcion }}</span>
                            <a v-on:click="goTo(tramite)" class="btn btn-sm btn-primary font-weight-bolder text-uppercase text-white" v-if="!tramite.info">
                                INICIAR TRAMITE
                            </a>
                            <a v-on:click="goTo(tramite)" class="btn btn-sm btn-primary font-weight-bolder text-uppercase text-white" v-if="tramite.info">
                                CONTINUAR
                            </a>

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
        props: ['tramite'],
        mounted() {
            if(this.tramite.info)
                this.tramite.info = JSON.parse(this.tramite.info)
            // if(this.tramite.clave)
        },

        methods:{
            goTo(tramite){ 
                redirect("/detalle-tramite/" +  tramite.id_tramite);
            }
        }
    }
</script>


