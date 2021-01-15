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
								        	<v-icon right class="fa fa-angle-down"> 
								        	</v-icon>
								    	</template>
							      	</v-expansion-panel-header>
							      	<v-expansion-panel-content>
										<div class="row">
											<div  v-if="agrupacion.tipo === 'agrupacion'" class="col-lg-12">
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

												<div class=" fv-plugins-icon-container"  v-if="campo.tipo === 'input'">
											  		<label>{{ campo.nombre }}</label>
											  		<input type="text" class="form-control  form-control-lg " style="background-color: #e5f2f5 !important"  
											  			:placeholder="[[campo.nombre]]" :id="[[campo.campo_id]]"
											  			v-model="campo.valor"  @keyup="cambioModelo"  @focus="cambioModelo"/>
													<small  v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
											  			<span v-for="mensaje in campo.mensajes" class="form-text text-danger">
											  				{{ mensaje.mensajeStr }}
											  			</span>
											  		</small>
											  	</div>

											
												<div class=" fv-plugins-icon-container"  v-else-if="campo.tipo === 'select'">
												  		<label>{{ campo.nombre }}</label>
												  		<select :id="[[campo.campo_id]]" :name="[[campo.campo_id]]" 
												  			class="form-control  form-control-lg" style="background-color: #e5f2f5 !important"
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
													<div class="" v-for="opcion in JSON.parse(campo.caracteristicas).opciones">
														<input type="radio" class=" "    
															:id="[[campo.campo_id]]"
														 	:name="[[campo.campo_id]]"
														 	:value="[[Object.keys(opcion)[0] ]]" v-model="campo.valor" @change="cambioModelo" >
														 	<label> {{ opcion[Object.keys(opcion)[0]] }}</label>
													</div>
												</div>
												<div v-else-if="campo.tipo === 'textbox'"  class=" fv-plugins-icon-container">
													<label>{{ campo.nombre }}</label>
													<textarea  
														:id="[[campo.campo_id]]"
													 	:name="[[campo.campo_id]]" 
													 	class="form-control  form-control-lg " style="background-color: #e5f2f5 !important" v-model="campo.valor"
													 	@change="cambioModelo" ></textarea>
													 	<small  class="form-text text-muted" v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || comprobarEstadoFormularioCount > 0)">
												  			<span v-for="mensaje in campo.mensajes">
												  				{{ mensaje.mensajeStr }}
												  			</span>
												  		</small>
													
												</div>
												<div v-else-if="campo.tipo == 'file'" class=" fv-plugins-icon-container">
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
															@change="fileSaved(campo.campo_id)"
														>
														</input>
													    <label class="custom-file-label" :for="[[campo.campo_id]]">
													    	<span v-if="file">{{file.name }}</span>
													    	<span v-else-if="!file">Seleccione archivo</span>

													    </label>
													  </div>
													</div>
														<a v-if="campo.campo_id=82" href="images\Formato.xlsx" download="Formato.xlsx">Descargar Formato</a>
												</div>
			 								</div>
												<table-component v-if="1 == 1"></table-component>
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
				progress: '',
				selectedId: [],
                campos: [], agrupaciones:[],
                mostrar:false,
                errors: {},
                showMensajes:false,
                files:[], file:null,
                tipoPersona:'pf',
				consulta_api:'',
				// campos:[
				// 	{
				// 		"relationship":229,
				// 		"tipo":"selecction",
				// 		"nombre":"Vendedores",
				// 		"registros" : [
				// 			{nombre:"jaime",  tipoPersona:"FISICA" , rfc: "CACJ9607222L1", curp: "CACJ960722HNLSMM14" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''},
				// 			{nombre:"dexter", tipoPersona:"FISICA" , rfc: "BEBT9509042L1", curp: "BEBT950904FCOBK22" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''},
				// 			{nombre:"thania", tipoPersona:"FISICA", rfc: "GATO" , curp: "---" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''}
				// 		],
				// 		"caracteristicas":"{\"required\":\"false\"}",
				// 		"campo_id":79,
				// 		"agrupacion_id":8,
				// 		"orden":2,
				// 		"nombre_agrupacion":"Expediente"
				// 	}
				// ],
				panel : [0,1,2,3,4],
				// modalx: {
				// 	tipoPropietario: '',
				// 	porcentajePropiedad: '',
				// 	unsufructo: '',
				// 	porcentajeVenta: '',
				// 	rfc: '',
				// }
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

		    	let formvALID = this.validarFormulario(camposAvalidar);

		    	let archivos = this.campos.filter( campo => campo.tipo == 'file' );
		    	if( archivos.length > 0){
		    		this.files = [];
		    		archivos.forEach( file =>{
		    			var fileInput = document.getElementById(file.campo_id);
		    			
		    			if( fileInput ){
		    				this.file = fileInput.files[0];
		    				this.files.push( {valor:this.file, nombre:file.nombre});
		    				this.$emit('updatingFiles', this.files);
		    			}

		    		});
		    	}
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
			},
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
												alert('el documento excel no cuenta con el formato requerido error: "FF0213120"');
												break;
											}
									}
									console.log('file : ' + file);
									this.files.push( {valor:file, nombre:file});
									this.$emit('updatingFiles', this.files);
									
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
												alert('el documento excel no cuenta con el formato requerido error: "DD13913191" ')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueRegion) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "DD13913191"')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueManzana) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "DD13913191"')
												break;
											}
											if ( /^([0-9]){1,3}$/.test(valueLote) == false) {
												alert('el documento excel no cuenta con el formato requerido error: "DD13913191"')
												break;
											}
										}
									console.log('file validacion 2: ' + file);
									this.files.push( {valor:file, nombre:file});
		    						this.$emit('updatingFiles', this.files);		
								}
							})
						}.bind(this);
				
					
				}
			}


			},
			check: function (registro ) {
				console.log('modal');
				$('#myModal').modal();
				console.log(rfc);
				this.modalx.tipoPropietario = registro.tipoPropietario;
				this.modalx.porcentajePropiedad = registro.porcentajePropiedad;
				this.modalx.porcentajeVenta = registro.porcentajeVenta;

			let total = 0;
                self = this;
 					Array.from(document.getElementsByClassName('checkbox')).forEach(function(row,index){
                        if(document.getElementsByClassName('checkbox')[index].checked)
                            total += parseInt(document.getElementsByClassName('campo')[index].value)>=0 ? parseInt(document.getElementsByClassName('campo')[index].value ):0;
                        if(total > 100)
                            throw alert("el porcentaje total no puede ser mayor de 100");
                        self.progress = total;
					});
					
				console.log(this.selectedId);
				console.log('...' +  this.progress);
			},
			modal(){
				console.log('modal');
				$('#myModal').modal();
			},
			save(){
				console.log('guardado');
				console.log(this.modalx.unsufructo);
				this.campos[0].registros.push({tipoPersona: this.modalx.tipoPropietario, porcentajeVenta: this.modalx.porcentajeVenta, porcentajePropiedad: this.modalx.porcentajePropiedad, unsufructo:  this.modalx.unsufructo = true ? 'si': 'no' })
				this.modalx.porcentajePropiedad =''
				this.modalx.porcentajeVenta =''
				this.modalx.tipoPropietario =''
				this.modalx.unsufructo =''
			}

     	}	
	}


</script>
