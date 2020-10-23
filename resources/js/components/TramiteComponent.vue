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
                            <a v-bind:href="'detalle-tramite/'+ tramite.id_tramite" class="d-flex align-items-center text-dark over-primary font-size-h5 font-weight-bold mr-3">
                                {{ tramite.tramite | capitalize }}
                            </a>
                            <!--end::Name-->
                        </div>
                        <!--begin::User-->
                        <!--begin::Actions-->
                        <div class="my-lg-0 my-1">
                            <a href="#" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2">
                                Precio
                            </a>
                            <a v-bind:href="'detalle-tramite/'+ tramite.id_tramite" class="btn btn-sm btn-primary font-weight-bolder text-uppercase text-white">
                                INICIAR TRAMITE 
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
            console.log('Component mounted.')
            console.log(this.tramite)
        }
    }
</script>


