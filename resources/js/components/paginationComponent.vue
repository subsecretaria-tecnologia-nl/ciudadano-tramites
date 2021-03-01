<template>
	<div class="pagination flex-column">
		<div class="pagination-content">
			<div  v-for="(tramite, index) in tramitesPaginados">
				<div class="card list-item card-custom gutter-b col-lg-12" style="background-color: #d9dee2 !important;" v-if="tramite.length > 1">
					<h4 class="ml-3"><strong class="text-uppercase text-truncate">{{ tramite[0].nombre_servicio && (tramite[0].titulo && tramite[0].nombre_servicio.toLowerCase() != tramite[0].titulo.toLowerCase()) ? `${tramite[0].nombre_servicio} - ` : '' }}{{ tramite[0].tramite || tramite[0].titulo | capitalize }}</strong></h4>
					<h5 class="ml-3 mb-4">{{ index }}</h5>
					<tramite-component v-for="(solicitud, ind) in tramite" @processToCart="processToCart" :tramitesCart="tramitesCart" :tramite="solicitud" v-bind:key="ind" v-if="totalItems != 0"></tramite-component>
				</div>
				<tramite-component @processToCart="processToCart" :tramitesCart="tramitesCart" :tramite="tramite[0]" v-bind:key="index"  v-if="tramite.length == 1 && totalItems != 0"></tramite-component>
			</div>
            <div class="card mb-4" v-if="totalItems == 0">
                <div class="card-body">
                    <h3 class="text-center">{{ message || '¡Lo sentimos! No se encuentran registros para mostrar.' }}</h3>
                </div>
            </div>
		</div>
		<div class="card card-custom">
		    <div class="card-body py-7">
		        <!--begin::Pagination-->
		        <div class="d-flex justify-content-between align-items-center flex-wrap">
		            <div class="d-flex flex-wrap mr-3" >
		                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" :class="totalItems == 0 ? 'disabled' : ''" v-if="currentPage != 1" v-on:click="goto(1)">
		                    <i class="ki ki-bold-double-arrow-back icon-xs"></i>
		                </a>
		                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" :class="totalItems == 0 ? 'disabled' : ''" v-if="currentPage != 1" v-on:click="goto(currentPage - 1)">
		                    <i class="ki ki-bold-arrow-back icon-xs"></i>
		                </a>
		                <a class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1" v-for="(r) in pages"
		                v-bind:class="[ currentPage === r ? 'active' : '']" v-on:click="goto(r)"> 
		                   {{ r }}
		                </a>
		                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== (pages.length)" :class="totalItems == 0 ? 'disabled' : ''" v-on:click="goto(currentPage + 1)">
		                    <i class="ki ki-bold-arrow-next icon-xs"></i>
		                </a>
		                <a  class="btn btn-icon btn-sm btn-light-primary mr-2 my-1" v-if="currentPage !== (pages.length)" :class="totalItems == 0 ? 'disabled' : ''"v-on:click="goto(pages[pages.length - 1])">
		                    <i class="ki ki-bold-double-arrow-next icon-xs"></i>
		                </a>
		            </div>
		            <div class="d-flex align-items-center">
		                <select class="form-control form-control-sm text-primary font-weight-bold mr-4 border-0 bg-light-primary" style="width: 75px;" v-model="limit" @change="calcularPage">
		                    <option value="10" selected>10</option>
		                    <option value="20">20</option>
		                    <option value="30">30</option>
		                </select>
		            </div>
		        </div>
		        <!--end:: Pagination-->
		    </div>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['tramitesCart'],
		mounted(){
			this.calcularPage()
            this.pagination(1);
		},
		data () {
			let attrs = this.$attrs;
			if(!attrs.items) attrs.items = [];
			if(!attrs.currentPage) attrs.currentPage = 1;
			if(!attrs.pages) attrs.pages = 0;
			if(!attrs.index) attrs.index = 1;
			if(!attrs.tramitesPaginados) attrs.tramitesPaginados = [];
			attrs.limit = 10;
			attrs.totalItems = 0;
			if(!attrs.message) attrs.message = null;
			return attrs;
		},
		methods : {
			processToCart(tramite){
				this.$emit('processToCart', tramite);
			},
            calcularPage(){
                let pages = [];
                let pagesTotal = Math.ceil( this.items.length  / this.limit);
                for (var i = 0; i < pagesTotal; i++) {
                    pages.push( i + 1 );
                }
                this.pages = pages;
                this.goto(1);
            },
            pagination( page ){
            	let groups = {};
                let limitInt = parseInt(this.limit);
                let indiceInicial = (page - 1 ) * limitInt;
                let indiceFinal = ( (page - 1 ) * limitInt  )  + limitInt;

                this.tramitesPaginados = this.items.slice( indiceInicial,  indiceFinal );
                this.tramitesPaginados.map(tramite => {
                	console.log(groups[tramite.clave]);
                	if(groups[tramite.clave]) groups[tramite.clave].push(tramite);
                	else groups[tramite.clave] = [tramite];
                })

                this.tramitesPaginados = groups;
                this.totalItems = this.tramitesPaginados.length;
            },
            goto( page ){ 
                this.pagination( page );
                this.currentPage = page;
            }
		}
	};
</script>