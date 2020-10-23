<template>
	<div id="contenedorCampos" class="container-fluid">
		<div :is="compiled" v-if="mostrar"></div>
		<div class="text-center" id="loadin" style=" margin-bottom: 9px;" v-if="!mostrar" >
			<div class="spinner-grow" role="status">
			  	<span class="sr-only">Loading...</span>
			</div>
		</div>
    </div>
</template>

<script>
    export default {
        props: ['tramite'],
        data() {
            return {
                campos: [],
                compiled: null,
                datos:null,
                mostrar:false
            }
        },
  
        mounted() {

            axios
              	.get(urlObtnerCampos, { params: { id_tramite: this.tramite.id_tramite } })
              	.then(response => {
                	let html  = "";
                	this.campos = response.data;
                	this.campos.forEach( ( campo, index ) => {
                		let jsonstr = JSON.stringify(campo);
                		
                		if( campo.tipo == "input" ){
							//html += "<div class='col-xl-6'><input-component :info='" +  jsonstr + "'' :inputData.sync=" + this.infocomplete+ "></input-component></div>";
							
							html += "<div class='col-xl-6'> "+ this.getInputTemplate( campo ) + "</div>" ;
						} else if( campo.tipo == "select" ){
							html += "<div class='col-xl-6'> "+ this.getSelectTemplate( campo ) + "</div>" ;
						} else if( campo.tipo == "option" ){
							html += "<div class='col-xl-6'> "+ this.getOptionTemplate( campo ) + "</div>" ;
						} else if( campo.tipo == "textbox"){
							console.log( campo)
							html += "<div class='col-xl-6'> "+ this.getTextBoxTemplate( campo ) + "</div>" ;
						}
					})
					this.compiled  = Vue.compile( "<div class='row'> " + html + "</div>" );
            	}).finally( () => {
					this.mostrar = true;
				});

        },

        methods: {
		    getInputTemplate(campo) {
		    	let name = campo.nombre.toLowerCase().split(" ").join("_");
	            let id = campo.nombre.toLowerCase().split(" ").join("_");
	            let caracteristicas = JSON.parse(campo.caracteristicas);
	            let descripcion = campo.nombre;
	            return   '<div class="form-group fv-plugins-icon-container"><label>'+  descripcion +'</label><input type="text" class="form-control form-control-solid form-control-lg"  placeholder="'+  descripcion +' " id="' +  id + '" ></div>';
		    },

		    getSelectTemplate(campo){
		    	let name = campo.nombre.toLowerCase().split(" ").join("_");
	            let id = campo.nombre.toLowerCase().split(" ").join("_");
	            let caracteristicas = JSON.parse(campo.caracteristicas);
	            let descripcion = campo.nombre;
	            
	            let strOpciones = '<option value="">Select</option>';
	            caracteristicas.opciones.forEach( (opcion) => {
	            	 let clave =  Object.keys(opcion)[0];
	            	strOpciones += '<option value="' + clave + '">' + opcion[clave] + '</option>'
	            });
		    	return '<div class="form-group fv-plugins-icon-container"><label>' + descripcion + '</label><select name="'+ name +'" class="form-control form-control-solid form-control-lg">'  +  strOpciones +  '</select></div>';
		    },

		    getOptionTemplate(campo){

		    	let name = campo.nombre.toLowerCase().split(" ").join("_");
	            let id = campo.nombre.toLowerCase().split(" ").join("_");
	            let caracteristicas = JSON.parse(campo.caracteristicas);
	            let descripcion = campo.nombre;

	            let html ="";
		        caracteristicas.opciones.forEach( (opcion, key) => {
		        	let clave =  Object.keys(opcion)[0];
		        	html += '<div class="form-group"><input type="radio" class=" form-control-solid"  placeholder="'+  descripcion +' " id="' +  id + '" value="' +  clave + '" ><label>'+  opcion[clave] +'</label></div>';
		        });

		    	return html;
		    },

		    getTextBoxTemplate(  campo ){
				let id = campo.nombre.toLowerCase().split(" ").join("_");
	            let caracteristicas = JSON.parse(campo.caracteristicas);
	            let descripcion = campo.nombre;
	            let name = campo.nombre.toLowerCase().split(" ").join("_");

		    	return '<div class="form-group fv-plugins-icon-container"><label>' + descripcion + '</label><textarea id="'+ id +'" class="form-control form-control-solid form-control-lg"></textarea></div>';		    	
		    }

		}

    }
</script>
