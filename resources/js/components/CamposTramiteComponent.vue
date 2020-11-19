<template>
	<div id="contenedorCampos" class="container-fluid">
		<div class="text-center" id="loadin" style=" margin-bottom: 9px;" v-if="!mostrar" >
			<div class="spinner-grow" role="status">
			  	<span class="sr-only">Loading...</span>
			</div>
		</div>
		<div class="" v-if="mostrar">
			<form id="formularioDinamico">
				<div class="panel panel-default" >
 					<div class="panel-heading">
 						<div class="row">
 							<div v-for="campo in campos" class="col-md-6 col-sm-6 col-xs-6">
							  	<div class="form-group fv-plugins-icon-container"  v-if="campo.tipo === 'input'">
							  		<label>{{ campo.nombre }}</label>
							  		<input type="text" class="form-control form-control-solid form-control-lg"  
							  			:placeholder="[[campo.nombre]]" :id="[[campo.campo_id]]"
							  			v-model="campo.valor"  @keyup="cambioModelo"  @focus="cambioModelo"/>
									<small  v-if="campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
							  			<span v-for="mensaje in campo.mensajes" class="form-text text-danger">
							  				{{ mensaje.mensajeStr }}
							  			</span>
							  		</small>
							  	</div>

							
								<div class="form-group fv-plugins-icon-container"  v-else-if="campo.tipo === 'select'">
								  		<label>{{ campo.nombre }}</label>
								  		<select :id="[[campo.campo_id]]" :name="[[campo.campo_id]]"
								  			class="form-control form-control-solid form-control-lg"
								  			v-model="campo.valor" @change="cambioModelo" >
								  			<option v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
								  			:value="[[Object.keys(opcion)[0] ]]">
								  				{{ opcion[ Object.keys(opcion)[0] ] }}
								  			</option>
								  		</select>
								  		<small  class="form-text text-muted" v-if="campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
								  			<span v-for="mensaje in campo.mensajes">
								  				{{ mensaje.mensajeStr }}
								  			</span>
								  		</small>
								</div>
								<div v-else-if="campo.tipo === 'option'">
									<div class="form-group" v-for="opcion in JSON.parse(campo.caracteristicas).opciones">
										<input type="radio" class=" form-control-solid"   
											:id="[[campo.campo_id]]"
										 	:name="[[campo.campo_id]]"
										 	:value="[[Object.keys(opcion)[0] ]]" v-model="campo.valor" @change="cambioModelo" >
										 	<label> {{ opcion[Object.keys(opcion)[0]] }}</label>
									</div>
								</div>
								<div v-else-if="campo.tipo === 'textbox'"  class="form-group fv-plugins-icon-container">
									<label>{{ campo.nombre }}</label>
									<textarea 
										:id="[[campo.campo_id]]"
									 	:name="[[campo.campo_id]]" 
									 	class="form-control form-control-solid form-control-lg" v-model="campo.valor"
									 	@change="cambioModelo" ></textarea>
									 	<small  class="form-text text-muted" v-if="campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
								  			<span v-for="mensaje in campo.mensajes">
								  				{{ mensaje.mensajeStr }}
								  			</span>
								  		</small>
									
								</div>
 							</div>
 						</div>
 		



 					</div>
 				</div>
			</form>
		</div>
    </div>
</template>

<script>
    export default {

        props: ['tramite','formularioValido', 'comprobarEstadoFormularioCount'],
        data() {
            return {
                campos: [],
                mostrar:false,
                errors: {},
                showMensajes:false
            }
        },
  
        created() {
			this.obtenerCampos();
        },

        methods: {
		    cambioModelo() {

		    	const parsed = JSON.parse(JSON.stringify(this.campos));
		    	let formvALID = this.validarFormulario();
                if( formvALID ){
                	let datosFormulario = {
                		tramite: this.tramite,
                		campos: this.campos
                	}
                	localStorage.setItem('datosFormulario', JSON.stringify(datosFormulario)); 
                }
		    },

		    validarFormulario(){
		    	let valido = true;
		    	this.campos.forEach( (campo, indice) =>{
		    	 	const campoOBJ = JSON.parse(JSON.stringify(campo));
		    	 	this.isValido(campoOBJ, indice);
                });
                this.campos.forEach( (campo, indice) =>{
                	valido = valido && campo.valido;
                });
                this.$emit('updatingScore', valido);
                return valido;
		    },


		    recuperarDatosInStorage(){
	            if (localStorage.getItem('datosFormulario')) {
	              	try {
	                	let datosFormulario = JSON.parse(localStorage.getItem('datosFormulario'));
	                	if( datosFormulario.tramite.id_tramite  == this.tramite.id_tramite){
	                		this.campos = datosFormulario.campos;
	                		this.showMensajes = true;
	                	} else {
	                		localStorage.removeItem('datosFormulario');
	                	}
	                	
	              	} catch(e) {
	                	localStorage.removeItem('datosFormulario');
	              	}
	            }	    	
		    },

		    async obtenerCampos(){
		    	let url = process.env.APP_URL + "/getCampos";
		    	try {
				  	let response = await axios.get(url,  { params: { id_tramite: this.tramite.id_tramite } });
				  	this.campos = response.data;

				  	this.recuperarDatosInStorage(); 

				  	this.validarFormulario();
				} catch (error) {
				  	console.log(error);
				}
				this.mostrar = true;
				
		    },

		    isValido(campo, indice  ){

		    	let curpValido = true;
		    	let requeridoValido = true;
				let caracteristicas = {};
		    	var caracteristicasStr = campo.caracteristicas;
		    	this.campos[indice].mensajes = [];
		    	try {
		    		caracteristicas  = JSON.parse(  caracteristicasStr + '' );
		    	}catch(err){
		    		console.log(err);
		    	}

		    	if( caracteristicas.expreg){
		    		var re = new RegExp(caracteristicas.expreg, "i");
		    		curpValido =  re.test(campo.valor) ;
		    		if(  !curpValido ){
		    			let mensaje = { 
		    				tipo:'regex',
		    				mensajeStr: "El campo " + campo.nombre + " no es válido"
		    			}
		    			this.campos[indice].mensajes.push( mensaje );
		    		}
		    	} 
		    	if( caracteristicas.hasOwnProperty('required') && caracteristicas.required) {
		    		requeridoValido =  !!campo.valor;
		    		if( !requeridoValido ){
		    			let mensaje = { 
		    				tipo:'required',
		    				mensajeStr: "El campo " + campo.nombre + " es requerido"
		    			}
		    			this.campos[indice].mensajes.push( mensaje );
		    		}
		    	}
		    	this.campos[indice].valido = curpValido && requeridoValido;
	        },



		}

    }
</script>
