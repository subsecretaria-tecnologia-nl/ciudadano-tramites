<template>
	<div class="pagination flex-column">
		<div class="pagination-content">
			<tramite-component v-for="(tramite, index) in items" :tramite="tramite" v-bind:key="index" v-if="totalItems != 0"></tramite-component>
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
			attrs.limit = 10;
			return attrs;
		},
		methods : {
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
                let limitInt = parseInt(this.limit);
                let indiceInicial = (page - 1 ) * limitInt;
                let indiceFinal =   ( (page - 1 ) * limitInt  )  + limitInt;

                this.tramitesPaginados = this.items.slice( indiceInicial,  indiceFinal );
                this.totalItems = this.tramitesPaginados.length;
                console.log(this.totalItems)
            },
            goto( page ){ 
                this.pagination( page );
                this.currentPage = page;
            }
		}
	};
</script>