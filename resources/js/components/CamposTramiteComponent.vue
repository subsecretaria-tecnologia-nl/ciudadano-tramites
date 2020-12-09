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
								<div v-else-if="campo.tipo === 'file'"  class="form-group fv-plugins-icon-container">
									<label>{{ campo.nombre }}</label>
									<input  
										id="expCatastral"
									 	:name="[[campo.campo_id]]" 
									 	class="form-control form-control-solid form-control-lg" 
										ref="fileInput"
										type="file"
										accept=".xlsx,.xls"
										@change="fileSaved()"
									>
									</input>
									<a href="images\Formato.xlsx" download="Formato.xlsx">Descargar Formato</a>

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
				<code> 
					{{campos}}
				</code>
    </div>
</template>

<script>
    export default {

        props: ['tramite','formularioValido', 'comprobarEstadoFormularioCount'],
        data() {
            return {
                campos: [
					{
					"relationship":131,
					"tipo":"file",
					"nombre":"Excel",
					"caracteristicas":"{\"required\":\"false\"}",
					"campo_id":'expCatastral',
					"mensajes":[
						{
							"tipo":"required",
							"mensajeStr":"El campo Excel es requerido"
						}
					],
					"valido":false
				}
			   ],
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
			fileSaved(){

				var file = document.getElementById('expCatastral')
				if (file != null ) {
					var  selectedFile =file.files[0];
					if(selectedFile){
						var fileReader = new FileReader();
						fileReader.readAsBinaryString(selectedFile);
						fileReader.onload = function(e) {
							var data =  e.target.result;
							var workbook = XLSX.read(data, {type: "binary"});
							workbook.SheetNames.forEach(sheetName => {
									var rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
									var json_object = JSON.stringify(rowObject);
									console.log(json_object);

									//cuando el usuario añada los expedientes bajo una unica columna de expediente catastral 
									if (Object.keys(rowObject[0]) == 'Expediente Catastral' || Object.keys(rowObject[0]) == 'Exp Catastral' || Object.keys(rowObject[0]) == 'E Catrastral')  {
										for (let i = 0; i < rowObject.length; i++) {
											var key = Object.keys(rowObject[0]);
											var value = rowObject[i][key];
											if ( (/^([0-9]{3,3})(-)?([0-9]{3,3})(-)?([0-9]{3,3})$/).test(value) == false ) {
												alert('el documento excel no cuenta con el formato requerido error: "FF0213120"');
												break;
											}

										}
									//formato en el quue se separa municipio / region / manzaba / lote	
									}else if(Object.keys(rowObject[0] == 'Municipio') || Object.keys(rowObject[1] == 'municipio')){

										var municipio = Object.keys(rowObject[0])[0];
										var region = Object.keys(rowObject[0])[1];
										var manzana = Object.keys(rowObject[0])[2];
										var lote = Object.keys(rowObject[0])[3];

										for (let i = 0; i < rowObject.length; i++) {
											var valueMunicipio = rowObject[i][municipio];
												(valueMunicipio.toString().length === 1 ) ? valueMunicipio= '00' + valueMunicipio : valueMunicipio;
												(valueMunicipio.toString().length === 2 ) ? valueMunicipio= '0' + valueMunicipio : valueMunicipio;
											var valueRegion = rowObject[i][region];
												(valueRegion.toString().length === 1 ) ? valueRegion= '00' + valueRegion : valueRegion;	
												(valueRegion.toString().length === 2 ) ? valueRegion= '0' + valueRegion : valueRegion;
											var valueManzana = rowObject[i][manzana];
												(valueManzana.toString().length === 1 ) ? valueManzana= '00' + valueManzana : valueManzana;	
												(valueManzana.toString().length === 2 ) ? valueManzana= '0' + valueManzana : valueManzana;
											var valueLote = rowObject[i][lote];
												(valueLote.toString().length === 1 ) ? valueLote= '00' + valueLote : valueLote;	
												(valueLote.toString().length === 2 ) ? valueLote= '0' + valueLote : valueLote;
											
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
									}
							})
						}.bind(this);
				
					
				}
			}


			}
	
     	}	
	}

</script>
