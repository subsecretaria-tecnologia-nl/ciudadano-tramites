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
							<v-expansion-panels>
							    <v-expansion-panel v-for="(agrupacion, i) in agrupaciones" :key="i">
							      	<v-expansion-panel-header >
							        	{{ agrupacion.nombre_agrupacion }}
							        	 <template v-slot:actions >
								        	<v-icon right class="fa fa-angle-down"> 
								        	</v-icon>
								    	</template>
							      	</v-expansion-panel-header>
							      	<v-expansion-panel-content>
										<div class="row">
											<div  v-if="agrupacion.tipo === 'agrupacion'" class="col-lg-12">
												<div class="col-md-12 col-lg-12">
												    <div class="text-center">
														    <div class="custom-control custom-radio custom-control-inline">
														      	<input type="radio" value="pf"  name="radioInline" class="custom-control-input" id="defaultInline2" v-model="tipoPersona" key="tipoPersona">
														      	<!--<input  name="tipoPersona"  >-->
														      	<label class="custom-control-label" for="defaultInline2">
														      		Persona fisica	
														      	</label>
														    </div>

														    <!-- Default inline 3-->
														    <div class="custom-control custom-radio custom-control-inline">
														      	<input type="radio" value="pm" name="radioInline" class="custom-control-input" id="defaultInline3" v-model="tipoPersona" key="tipoPersona">

														      	<label class="custom-control-label" for="defaultInline3">
														      		Persona Moral	
														      	</label>
														    </div>

														    <div :set= 'agrupacion.campos = agrupacion.grupos[tipoPersona].campos'> </div>
													</div>
												</div>
											</div>
			 								<div v-for="(campo, j) in agrupacion.campos" :key="j" class="col-md-6 col-sm-6 col-xs-6"
			 								:class="j == agrupacion.campos.length - 1 && agrupacion.campos.length % 2 != 0 ? 'col-md-12 col-sm-12 col-xs-12' : 'col-md-6 col-sm-6 col-xs-6'">

												<div class="form-group fv-plugins-icon-container"  v-if="campo.tipo === 'input'">
											  		<label>{{ campo.nombre }}</label>
											  		<input type="text" class="form-control form-control-solid form-control-lg"  
											  			:placeholder="[[campo.nombre]]" :id="[[campo.campo_id]]"
											  			v-model="campo.valor"  @keyup="cambioModelo"  @focus="cambioModelo"/>
													<small  v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
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
												  		<small  class="form-text text-muted" v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
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
													 	<small  class="form-text text-muted" v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
												  			<span v-for="mensaje in campo.mensajes">
												  				{{ mensaje.mensajeStr }}
												  			</span>
												  		</small>
													
												</div>
												<div v-else-if="campo.tipo == 'file'" class="form-group fv-plugins-icon-container">
													<div class="input-group">
													  <div class="input-group-prepend">
													    <span class="input-group-text" id="inputGroupFileAddon01">{{ campo.nombre}}</span>
													  </div>
													  <div class="custom-file">
													    <input type="file" id="file" name="file" class="custom-file-input"   @change="cambioModelo" aria-describedby="inputGroupFileAddon01">
													    <label class="custom-file-label" for="file">
													    	<span v-if="file">{{file.name }}</span>
													    	<span v-else-if="!file">Seleccione archivo</span>

													    </label>
													  </div>
													</div>
												</div>

			 								</div>
										</div>
							      	</v-expansion-panel-content>
							    </v-expansion-panel>
							</v-expansion-panels>
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
                campos: [], agrupaciones:[],
                mostrar:false,
                errors: {},
                showMensajes:false,
                files:[], file:null,
                tipoPersona:'pf',
                consulta_api:''
            }
        },
  
        created() {

			if (localStorage.getItem('datosFormulario')) {
              	try {
                	let datosFormulario = JSON.parse(localStorage.getItem('datosFormulario'));
                	if( datosFormulario.tramite.id_tramite  == this.tramite.id_tramite){
		                this.campos = datosFormulario.campos;
		                this.consulta_api = datosFormulario.consulta_api;
						this.agruparCampos();
						this.showMensajes = true;
						this.mostrar = true;
						if (datosFormulario.tipoPersona) {
							this.tipoPersona = datosFormulario.tipoPersona;
						}
                	} else {
                		localStorage.removeItem('datosFormulario');
                		this.obtenerCampos();
                	}
                	
              	} catch(e) {
                	localStorage.removeItem('datosFormulario');
                	this.obtenerCampos();
              	}
	        } else {
	        	this.obtenerCampos();
	        }
        },

        methods: {

		    cambioModelo(){
        		let camposAvalidar = [];
		    	this.agrupaciones.forEach( agrupacion => camposAvalidar = camposAvalidar.concat( agrupacion.campos ) );
		    	var fileInput = document.getElementById('file');
		    	if( fileInput ){
		    		this.file = fileInput.files[0];
		    		this.files.push( {valor:this.file, nombre:this.file});
		    		this.$emit('updatingFiles', this.files);
		    	}
		    	let formvALID = this.validarFormulario(camposAvalidar);

		    	if( formvALID ){
                	let datosFormulario = {
                		tramite: this.tramite,
                		campos: this.campos,
                		tipoPersona:this.tipoPersona,
                		consulta_api: this.consulta_api
                	}
                	localStorage.setItem('datosFormulario', JSON.stringify(datosFormulario)); 
                }
        	},



        	validarFormulario( camposAvalidar ){
        		let formularioValido = true;
        		camposAvalidar.forEach( (campo) =>{
					const campoOBJ = JSON.parse(JSON.stringify(campo));
					this.isValido(campoOBJ);
        		});

        		let camposValidados = this.campos.filter( campo => !!camposAvalidar.find( campoAvalidar => { 
        			return campoAvalidar.campo_id == campo.campo_id && campoAvalidar.agrupacion_id == campo.agrupacion_id
        		}));

                camposValidados.forEach( (campo, indice) => {
                	formularioValido = formularioValido && campo.valido;
                });
                this.$emit('updatingScore', formularioValido);
                return formularioValido;
		    },

		    async obtenerCampos(){
		    	let url = process.env.APP_URL + "/getCampos";
		    	try {
				  	let response = await axios.get(url,  { params: { id_tramite: this.tramite.id_tramite } });
				  	this.consulta_api = response.data && response.data.length > 0 ? response.data[0].consulta_api : '';
					this.campos = response.data && response.data.length > 0 ? response.data[0].campos_data : [];
					this.agruparCampos();


				} catch (error) {
				  	console.log(error);
				}
				this.mostrar = true;
				
		    },


		    agruparCampos(){
		    		let agrupaciones = this.campos.map( campo => {  return {agrupacion_id:campo.agrupacion_id, nombre_agrupacion: campo.nombre_agrupacion, campos:[] } }).filter( this.onlyUnique );
				  	agrupaciones = agrupaciones.map( agrupacion => {
				  		agrupacion.campos = this.campos.filter(  campo => campo.agrupacion_id == agrupacion.agrupacion_id );
				  		agrupacion.campos.sort(function(a,b) { return parseFloat(a.orden) - parseFloat(b.orden) } );
				  		return agrupacion;
				  	});
				  	this.datosPersonales = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == 'Datos Personales' );
					this.razonSocial = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == 'Razón Social' );

				  	if(  this.datosPersonales && this.razonSocial  ){
				  		agrupaciones = agrupaciones.filter( agrupacion => agrupacion.nombre_agrupacion != 'Datos Personales' && agrupacion.nombre_agrupacion != 'Razón Social'  );
				  		agrupaciones.unshift( {nombre_agrupacion:'Tipo Persona',  tipo: 'agrupacion', grupos: { 'pf': this.datosPersonales, 'pm': this.razonSocial } } );
				  	}
				  	console.log( agrupaciones )
				  	this.agrupaciones = agrupaciones;

		    },

		    onlyUnique(value, index, self) { 
			    return self.findIndex (dato => dato.agrupacion_id == value.agrupacion_id) === index;
			},


        	isValido(campo){

		    	let curpValido = true;
		    	let requeridoValido = true;
				let caracteristicas = {};
		    	var caracteristicasStr = campo.caracteristicas;

		    	let indiceCampo = this.campos.findIndex( campoInARRAY => campoInARRAY.campo_id == campo.campo_id && campoInARRAY.agrupacion_id == campo.agrupacion_id );
		    	this.campos[indiceCampo].mensajes = [];
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
		    			this.campos[indiceCampo].mensajes.push( mensaje );
		    		}
		    	} 
		    	if( caracteristicas.hasOwnProperty('required') && caracteristicas.required) {
		    		
		    		if( campo.tipo == 'file' ){
						requeridoValido =  !!this.file;
		    		} else {
						requeridoValido =  !!campo.valor;
		    		}
		    		if( !requeridoValido ){
		    			let mensaje = { 
		    				tipo:'required',
		    				mensajeStr: "El campo " + campo.nombre + " es requerido"
		    			}
		    			this.campos[indiceCampo].mensajes.push( mensaje );
		    		}
		    	}
		    	this.campos[indiceCampo].valido = curpValido && requeridoValido;
	        }



		}

    }
</script>
