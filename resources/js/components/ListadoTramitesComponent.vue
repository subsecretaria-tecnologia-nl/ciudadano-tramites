<template>
    <div class="d-flex flex-column-fluid">

        <v-container v-if="loading">
            <v-row>
                <v-col cols="12" md="12">
                    <v-skeleton-loader  type="list-item" v-for="(r,i) in [1,2,3,4,5,6]" height="90px" style="margin-bottom: 8px;"></v-skeleton-loader>
                </v-col>
            </v-row>
        </v-container>


        <div class="container" v-if="!loading">
            <tramite-component v-for="(tramite, index) in tramitesPaginados" :tramite="tramite" v-bind:key="index"></tramite-component>

            <div class="card card-custom">
                <div class="card-body py-7">
                    <!--begin::Pagination-->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex flex-wrap mr-3">
                            <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-double-arrow-back icon-xs"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-arrow-back icon-xs"></i>
                            </a>
                            <a class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1" v-for="(r) in pages"
                            v-bind:class="[ currPa === r ? 'active' : '']" v-on:click="goto(r)"> 
                               {{ r }}
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-arrow-next icon-xs"></i>
                            </a>
                            <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-2 my-1">
                                <i class="ki ki-bold-double-arrow-next icon-xs"></i>
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" v-model="porPage" @change="calcularPage">
                                <option value="10">1</option>
                                <option value="20">2</option>
                                <option value="30">3</option>
                            </select>
                            <span class="text-muted">Mostrando {{ porPage }} de {{ tramites.length }} trámites</span>
                        </div>
                    </div>
                    <!--end:: Pagination-->
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {    

        data() {
            return {
                tramites: [], loading:true, porPage : 10, pages:[0], currPa :1
            }
        },
        created() {
            localStorage.removeItem('datosFormulario');
            localStorage.removeItem('listaSolicitantes');
            localStorage.removeItem('tramite');
            this.obtenerTramites();
        },

        methods: {


            async obtenerTramites(){
                let url = process.env.APP_URL + "/allTramites";
                try {
                    let response = await axios.get(url);
                    this.tramites = response.data;
                    
                    let pagesTotal = Math.ceil( this.tramites.length / this.porPage);
                    let pages = [];

                    for (var i = 0; i < pagesTotal; i++) {
                        pages.push( i + 1 );
                    }
                    this.pages = pages;
                } catch (error) {
                    console.log(error);
                }
                this.tramitesPaginados = this.tramites.slice( (this.currPa - 1 ) * this.porPage,  ((this.currPa - 1 ) * this.porPage)  + this.porPage );
                this.loading = false;
            },

            calcularPage(){
                let pages = [];
                let pagesTotal = Math.ceil( this.tramites.length / this.porPage);
                for (var i = 0; i < pagesTotal; i++) {
                    pages.push( i + 1 );
                }
                this.pages = pages;
                this.goto(1);
            },

            goto( page ){ 
                this.tramitesPaginados = this.tramites.slice( (page - 1 ) * parseInt(this.porPage),  ((page - 1 ) * parseInt(this.porPage)  )  + parseInt(this.porPage) );
                this.currPa = page;
            }

        }


    }
</script>