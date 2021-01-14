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
							<v-expansion-panels accordion multiple hover style="z-index: inherit" v-model="panel">
							    <v-expansion-panel v-for="(agrupacion, i) in agrupaciones" :key="i">
							      	<v-expansion-panel-header >
							        	{{ agrupacion.nombre_agrupacion }}
							        	 <template v-slot:actions >
								        	<v-icon right class="fa fa-angle-down" />
								    	</template>
							      	</v-expansion-panel-header>
							      	<v-expansion-panel-content>
										<div class="row">
											<div v-if="agrupacion.tipo === 'agrupacion'" class="col-lg-12">
												<div class="col-md-12 col-lg-12">
												    <div >
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
			 								:class="j == agrupacion.campos.length - 1 && agrupacion.campos.length % 2 != 0 || campo.tipo == 'file'? 'col-md-12 col-sm-12 col-xs-12' : 'col-md-6 col-sm-6 col-xs-6'">

												<input-component
													v-if="campo.tipo === 'input'" 
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm">
												</input-component>	
												<select-component
													v-else-if="campo.tipo === 'select' || campo.tipo === 'multiple'" 
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm">
												</select-component>
												<option-component 
													v-else-if="campo.tipo === 'option'"
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm">
												</option-component>
												<textbox-component
													v-else-if="campo.tipo === 'textbox' && (!campo.condition || campo.condition.view(agrupaciones))"
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm">
												</textbox-component>
												<checkbox-component 
													v-else-if="campo.tipo === 'checkbox'"
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm">
												</checkbox-component>
												<file-component
													v-else-if="campo.tipo == 'file' && JSON.parse(campo.caracteristicas).tipo != 'expediente_validacion_excel'"
													:campo="campo" 
													:showMensajes="showMensajes" 
													:estadoFormulario="comprobarEstadoFormularioCount"
													@updateForm="updateForm"
												></file-component>

												<div v-else-if="JSON.parse(campo.caracteristicas).tipo == 'expediente_validacion_excel'" class=" fv-plugins-icon-container">
													<div class="input-group">
													  <div class="input-group-prepend">
													  <span class="input-group-text" id="inputGroupFileAddon01">{{ campo.nombre}}</span>
													  </div>	
														<div class="custom-file">
															<input  
																:id="[[campo.campo_id]]"
																:name="[[campo.campo_id]]" 
																class="custom-file-input"  style="background-color: #e5f2f5 !important"
																ref="fileInput"
																type="file"
																accept=".xlsx,.xls"
																@change="fileSaved(campo.campo_id)"/>
															<label class="custom-file-label" :for="[[campo.campo_id]]">
																<span :id="[[campo.campo_id]]+ '-' + [[campo.nombre.replace('*', '')]]+'-namefile'"> 	{{ campo.attach || 'Seleccione archivo' }}
																</span>
															</label>
													  	</div>
													</div>
													<a v-if="/^{*}|Expediente$/.test(campo.nombre) == true" href="images\Formato.xlsx" download="Formato.xlsx">Descargar Formato</a>
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
	const getFile = (url, nombreArchivo, campo) => {
	  return new Promise((resolve, reject) => {
	    axios({
	      	method: "get",
	      	url,
	      	responseType: "ArrayBuffer",
	      	headers: {
				'nombreArchivo': nombreArchivo,
				campo_id: campo.campo_id,
				campo_nombre:campo.nombre
			}
	    })
	      .then(data => {
	        resolve(data);
	      })
	      .catch(error => {
	        reject(error.toString());
	      });
	  });
	}

    export default {

        props: ['tramite','formularioValido', 'comprobarEstadoFormularioCount', 'infoGuardada', 'declararEn0'],
        data() {
            return {
                campos: [], agrupaciones:[],
                mostrar:false,
                errors: {},
                showMensajes:false,
                files:[], file:null,
                tipoPersona:'pf',
                consulta_api:'',
				panel : [0,1,2,3,4],
				motivoDeclaracion0:'',
            }
        },
		watch: { 
		  	declararEn0: function(newVal, oldVal) { // watch it
		      	this.setDeclararEn0();
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
	        	//localStorage.removeItem('datosFormulario');
	        	this.obtenerCampos();
			}
			
        },

        methods: {
        	setDeclararEn0(){
        		let agrupacionDatosImpuesto = this.agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == "Datos para determinar el impuesto");
        		if(agrupacionDatosImpuesto){
				    if(this.declararEn0){
						agrupacionDatosImpuesto.campos.map( campo =>{
							if(campo.nombre == 'Motivo'){
								campo.valor = "";
							} else {
								campo.valor = 0;							
								campo.valido = true;
							}
							$("#" + campo.campo_id).attr("disabled", true);
							campo.mensajes = [];
							$("#" + campo.campo_id).trigger("change");
							return campo;
						});
						this.$forceUpdate();
				    } else {
						
						agrupacionDatosImpuesto.campos.map( campo =>{
							campo.valor = '';
							$("#" + campo.campo_id).removeAttr("disabled")
							$("#" + campo.campo_id).trigger("change");
							return campo;
						});
						this.$forceUpdate();      	
				    }
				}
        	},
        	updateForm(campo){
        		if(campo.tipo == 'file' && campo.valido){
        			var fileInput = document.getElementById(campo.campo_id);
        			let file = fileInput.files[0];

        			let nuevoFile = {valor:file, nombre:campo.nombre, id:campo.campo_id, nombrreFile:file.name};
        			let indexArchivoEnLista = this.files.findIndex( file => file.id == campo.campo_id );
        			if(indexArchivoEnLista>=0){
        				this.files[indexArchivoEnLista] = nuevoFile;
        			} else {
        				this.files.push( nuevoFile);
        			}
		    		this.$emit('updatingFiles', this.files);
        		}
        		this.cambioModelo();
        	},
		    cambioModelo(){
		    	let formvALID = this.validarFormulario();
            	let datosFormulario = {
            		tramite: this.tramite,
            		campos: this.campos,
            		tipoPersona:this.tipoPersona,
            		consulta_api: this.consulta_api,
            		formularioValido:formvALID,
            		motivoDeclaracion0:this.motivoDeclaracion0
            	}
            	localStorage.setItem('datosFormulario', JSON.stringify(datosFormulario)); 
        	},

        	validarFormulario(  ){
        		let formularioValido = true;

        		let camposValidables = [];
        		this.agrupaciones.forEach( agrupacion =>{
        			camposValidables = camposValidables.concat( agrupacion.campos );
        			return agrupacion;
        		});
                camposValidables.forEach( (campo, indice) => {
                	/*if(campo.tipo == 'file'){
                		formularioValido = formularioValido && true;
                	} else*/	if( campo.nombre == 'Motivo'  ){
                		if(this.declararEn0){
							formularioValido = formularioValido && !!campo.valido;
							this.motivoDeclaracion0 = campo.valor;
                		} 
					} else {
                		formularioValido = formularioValido && !!campo.valido;
                	}
		    		
                });
                console.log(JSON.parse(JSON.stringify(camposValidables)))
				console.log(formularioValido);
                this.$emit('updatingScore', formularioValido);
                return formularioValido;
		    },

		    async obtenerCampos(){
		    	let url = process.env.APP_URL + "/getCampos";
				let promises = [];
		    	let linksArchivos = [];
		    	try {
				  	let response = await axios.get(url,  { params: { id_tramite: this.tramite.id_tramite } });
				  	this.consulta_api = response.data && response.data.length > 0 ? response.data[0].consulta_api : '';
					this.campos = response.data && response.data.length > 0 ? response.data[0].campos_data : [];

					if( this.infoGuardada && this.infoGuardada.campos ){
						this.tipoPersona = this.infoGuardada.tipoPersona;
						this.motivoDeclaracion0 = this.infoGuardada.motivoDeclaracion0;
						this.campos.forEach( (campo) =>{	
							campo.valor = this.infoGuardada.campos[ campo.campo_id ];
							if( campo.tipo == 'file' && this.infoGuardada.archivosGuardados){
								let infoArchivoGuardado = this.infoGuardada.archivosGuardados.find( archivo => archivo.mensaje == campo.nombre );
								campo.archivoGuardado = true;
								let urlFile = process.env.TESORERIA_HOSTNAME + '/download/' + infoArchivoGuardado.attach;
								promises.push(getFile( urlFile, infoArchivoGuardado.attach, campo ));
							}
							
						});
					}
				} catch (error) {
				  	console.log(error);
				}
		       	Promise.all(promises).then(( respuestas ) => {
					respuestas.forEach( (res) => {
						const blob = new Blob([res.data], { type: res.headers['content-type'] });
						var fileNew = new File([blob], res.config.headers.nombreArchivo , {
							type: res.headers['content-type'], 
							lastModified: Date.now()
						});
						let headers = res.config.headers;
						this.files.push( {valor:fileNew, nombre: headers.campo_nombre});
						this.$emit('updatingFiles', this.files);

						var fileInput = document.getElementById(headers.campo_id /*+ '-' + headers.campo_nombre.replace('*', '')*/);
	  					fileInput.files.push(fileNew);

					})
		       	}).catch(errors => {
				  // react on errors.
				}).finally(() => {
					console.log("no hay archivos")
					this.agruparCampos();
					let segg= this;
					setTimeout(function(){ segg.cambioModelo(); }, 1000);
				});
				this.mostrar = true;
				
		    },

		    agruparCampos(){
		    		let agrupaciones = this.campos.map( (campo, index) => {  
		    			return {
			    			agrupacion_id:campo.agrupacion_id, 
			    			nombre_agrupacion: campo.nombre_agrupacion, 
			    			campos:[],
			    			orden_agrupacion: campo.orden_agrupacion 
		    			} 
		    		}).filter( this.onlyUnique );
				  	agrupaciones = agrupaciones.map( agrupacion => {
				  		agrupacion.campos = this.campos.filter(  campo => campo.agrupacion_id == agrupacion.agrupacion_id );
				  		agrupacion.campos.sort(function(a,b) { return parseFloat(a.orden) - parseFloat(b.orden) } );
				  		return agrupacion;
				  	});

				  	let agrupacionDatosImpuesto = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == "Datos para determinar el impuesto");
				  	let nombreCampoMotivo = 'Motivo';
				  	if( agrupacionDatosImpuesto ){

				  		let campo = {
				  			idElemento:'campo_motivo_declaracion_0',
							agrupacion_id: agrupacionDatosImpuesto.agrupacion_id,
							caracteristicas: '{"required":"true"}',
							nombre: nombreCampoMotivo,
							valor: this.motivoDeclaracion0 ? this.motivoDeclaracion0 : '',
							nombre_agrupacion: agrupacionDatosImpuesto.nombre_agrupacion,
							orden: agrupacionDatosImpuesto.campos[ agrupacionDatosImpuesto.campos.length - 1 ].orden + 1,
							tipo: "textbox",
							condition:{
								view: function(agrupaciones){
									let agrupacionDatosImpuesto = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == "Datos para determinar el impuesto");
									//Obtenemos campos diferentes a Motivo
									let campos = agrupacionDatosImpuesto.campos.filter( campo => {
										return campo.nombre != nombreCampoMotivo
									});

									let isDelacaracion0 = true;
									campos.forEach( campo => {
										isDelacaracion0 = isDelacaracion0 && parseFloat(campo.valor ) == 0;
									});
									return isDelacaracion0;
								}
							}			  			
				  		}

				  		agrupacionDatosImpuesto.campos.push( campo )

				  						  		
				  	}

				  	this.datosPersonales = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == 'Datos Personales' );
					this.razonSocial = agrupaciones.find( agrupacion => agrupacion.nombre_agrupacion == 'Razón Social' );

				  	if(  this.datosPersonales && this.razonSocial  ){
				  		agrupaciones = agrupaciones.filter( agrupacion => agrupacion.nombre_agrupacion != 'Datos Personales' && agrupacion.nombre_agrupacion != 'Razón Social'  );
				  		agrupaciones.unshift( {nombre_agrupacion:'Tipo Persona',  tipo: 'agrupacion', grupos: { 'pf': this.datosPersonales, 'pm': this.razonSocial } } );
				  	}

				  	this.agrupaciones = agrupaciones.sort(function(a,b) { return parseFloat(a.orden_agrupacion) - parseFloat(b.orden_agrupacion) } );
				  	
				  	let segg= this;
					setTimeout(function(){ segg.setDeclararEn0(); }, 1000);

		    },

		    onlyUnique(value, index, self) { 
			    return self.findIndex (dato => dato.agrupacion_id == value.agrupacion_id) === index;
			},
/*
			fileSaved(campo_id){
				var file = document.getElementById(campo_id);

				if (file != null ) {
					  file =file.files[0];
					  console.log('file..' + file);
					if(file){
						var fileReader = new FileReader();
						fileReader.readAsBinaryString(file);
						fileReader.onload = function(e) {
							var data =  e.target.result;
							var workbook = XLSX.read(data, {type: "binary"});
							workbook.SheetNames.forEach(sheetName => {
								var rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
								var json_object = JSON.stringify(rowObject);		
								var opcionesExp = ['Expediente Catastral' , 'Exp Catastral', 'E Catastral'];
								var trueExp;
								var tipoValidacion ;

								for (let k = 0; k < opcionesExp.length; k++) {
									if (Object.keys(rowObject[0]).indexOf(opcionesExp[k]) != -1) {
										console.log(Object.keys(rowObject[0]).indexOf(opcionesExp[k]));
										var index = Object.keys(rowObject[0]).indexOf(opcionesExp[k]);
										trueExp = opcionesExp[k];
										break;
									}
									
								}

								var index = Object.keys(rowObject[0]).indexOf(trueExp);
								index != -1 ? tipoValidacion  = '1' : tipoValidacion = '2';
								console.log('tipo de validacion: ' +tipoValidacion);
								
								//cuando el usuario añada los expedientes bajo una unica columna de expediente catastral 
								if (tipoValidacion == 1 ) {
									
									var expName =  Object.keys(rowObject[0])[Object.keys(rowObject[0]).indexOf(trueExp)]
									for (let i = 0; i < rowObject.length; i++) {
											// var key = Object.keys(rowObject[0]);
											var value = rowObject[i][expName];
											if ( (/^([0-9]{3,3})(-)?([0-9]{3,3})(-)?([0-9]{3,3})$/).test(value) == false ) {
												alert('el documento excel no cuenta con el formato requerido error: "el formato de expediente completo es invalido"');
												break;
											}
									}
									console.log('file : ' + file);
									//this.files.push( {valor:file, nombre:file});
									//this.$emit('updatingFiles', this.files);
									
								}else if(tipoValidacion == 2){

										var municipio = Object.keys(rowObject[0])[Object.keys(rowObject[0]).indexOf('Municipio')];
											municipio == undefined ? 'municipio' : municipio;

										var region = Object.keys(rowObject[0])[Object.keys(rowObject[0]).indexOf('Region')];
											region == undefined ? region = 'region' : region;

										var manzana = Object.keys(rowObject[0])[Object.keys(rowObject[0]).indexOf('Manzana')];
											manzana == undefined ? manzana = 'manzana' : manzana;

										var lote = Object.keys(rowObject[0])[Object.keys(rowObject[0]).indexOf('Lote')];
											lote == undefined ? lote = 'lote' : lote;

										for (let i = 0; i < rowObject.length; i++) {
											var valueMunicipio = rowObject[i][municipio];
												valueMunicipio = valueMunicipio.toString().padStart(3, '0');
											var valueRegion = rowObject[i][region];
												valueRegion = valueRegion.toString().padStart(3, '0');
											var valueManzana = rowObject[i][manzana];
												valueManzana = valueManzana.toString().padStart(3, '0');
											var valueLote = rowObject[i][lote];
												valueLote = valueLote.toString().padStart(3, '0');
											
											if ( /^([0-9]){1,3}$/.test(valueMunicipio) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "el expediente formado por municipio, region, manzana, lote es incorrecto" ')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueRegion) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "el expediente formado por municipio, region, manzana, lote es incorrecto"')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueManzana) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "el expediente formado por municipio, region, manzana, lote es incorrecto"')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueLote) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "el expediente formado por municipio, region, manzana, lote es incorrecto"')
												break;
											}
										}	
								}
							})
						}.bind(this);
				
					
					}
				}
				this.cambioModelo();

			}*/
	
     	}	
	}

</script>
