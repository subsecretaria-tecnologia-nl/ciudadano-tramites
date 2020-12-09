<template>
    <div class="content d-flex flex-column flex-column-fluid">
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Trámites</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">{{ tramitesFiltrados.length }} Total</span>
                        <form class="ml-5">
                            <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                                <input type="text" class="form-control" id="kt_subheader_search_form" placeholder="Search..." v-on:keyup="search()" v-model="strBusqueda">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo7/dist/assets/media/svg/icons/General/Search.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        <!--<i class="flaticon2-search-1 icon-sm"></i>-->
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Search Form-->
                </div>
                <!--end::Details-->
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
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
                <tramite-component v-for="(tramite, index) in tramitesPaginados" :tramite="tramite" v-bind:key="index"></tramite-component>
                <div class="card card-custom">
                    <div class="card-body py-7">
                        <!--begin::Pagination-->
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex flex-wrap mr-3" >
                                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== 1"  v-on:click="goto(1)">
                                    <i class="ki ki-bold-double-arrow-back icon-xs"></i> {{ index }}
                                </a>
                                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== 1" v-on:click="goto(currentPage - 1)">
                                    <i class="ki ki-bold-arrow-back icon-xs"></i>
                                </a>
                                <a class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1" v-for="(r) in pages"
                                v-bind:class="[ currentPage === r ? 'active' : '']" v-on:click="goto(r)">
                                   {{ r }}
                                </a>
                                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== (pages.length)"  v-on:click="goto(currentPage + 1)">
                                    <i class="ki ki-bold-arrow-next icon-xs"></i>
                                </a>
                                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== (pages.length)" v-on:click="goto(pages[pages.length - 1])">
                                    <i class="ki ki-bold-double-arrow-next icon-xs"></i>
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" v-model="porPage" @change="calcularPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>
                        <!--end:: Pagination-->
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                tramites: [], loading:true, porPage : 10, pages:[0], currentPage :1, strBusqueda:"", totalTramites:0,tramitesFiltrados:[]
            }
        },
        created() {
          console.log( process.env )
            localStorage.removeItem('datosFormulario');
            localStorage.removeItem('listaSolicitantes');
            localStorage.removeItem('tramite');
            this.obtenerTramites();
          console.log("fn created")
        },

        methods: {


            async obtenerTramites(){
                let url = process.env.APP_URL + "/allTramites";
                try {
                    let response = await axios.get(url);
                    this.tramites = response.data;
                    this.tramitesFiltrados = this.tramites;
                    let pagesTotal = Math.ceil( this.tramitesFiltrados.length / this.porPage);
                    let pages = [];

                    for (var i = 0; i < pagesTotal; i++) {
                        pages.push( i + 1 );
                    }
                    this.pages = pages;
                } catch (error) {
                    console.log(error);
                }

                this.pagination(1);
                this.loading = false;
            },

            calcularPage(){
                let pages = [];
                let pagesTotal = Math.ceil( this.tramitesFiltrados.length  / this.porPage);
                for (var i = 0; i < pagesTotal; i++) {
                    pages.push( i + 1 );
                }
                this.pages = pages;


                this.goto(1);
            },

            pagination( page ){
                let porPageInt = parseInt(this.porPage);
                let indiceInicial = (page - 1 ) * porPageInt;
                let indiceFinal =   ( (page - 1 ) * porPageInt  )  + porPageInt;

                this.tramitesFiltrados = this.tramites.filter( tramite => tramite.tramite.toLocaleLowerCase().includes(this.strBusqueda.toLocaleLowerCase()) ) ;
                this.tramitesPaginados = this.tramitesFiltrados.slice( indiceInicial,  indiceFinal );
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
            }

        }


    }
</script>
