<template>
	<div id="contenedorCampos" class="container-fluid">
		<div class="text-center" id="loadin" style=" margin-bottom: 9px;" v-if="!mostrar" >
			<div class="spinner-grow" role="status">
			  	<span class="sr-only">Loading...</span>
			</div>
		</div>
		<div class="" v-if="mostrar">
			<form id="formularioDinamico">
				<div v-for="campo in campos" class="">
					<div v-if="campo.tipo === 'input'">
					  	<div class="form-group fv-plugins-icon-container">
						  	<div class="form-group fv-plugins-icon-container">
						  		<label>{{ campo.nombre }}</label>
						  		<input type="text" class="form-control form-control-solid form-control-lg"  
						  			:placeholder="[[campo.nombre]]" :id="[[campo.campo_id]]"
						  			v-model="model[campo.campo_id]"  @change="cambioModelo" :required="isRequired( campo )"/>
						  		<small  class="form-text text-muted" v-if="errors[campo.campo_id]">
						  			Campo requerido
						  		</small>
						  	</div>
					  	</div>
					</div>
					<div v-else-if="campo.tipo === 'select'">
					  	<div class="form-group fv-plugins-icon-container">
					  		<label>{{ campo.nombre }}</label>
					  		<select :id="[[campo.campo_id]]" :name="[[campo.campo_id]]"
					  			class="form-control form-control-solid form-control-lg"
					  			v-model="model[campo.campo_id]" @change="cambioModelo" :required="isRequired( campo )">
					  			<option v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
					  			:value="[[Object.keys(opcion)[0] ]]">
					  				{{ opcion[ Object.keys(opcion)[0] ] }}
					  			</option>
					  		</select>
						  		<small  class="form-text text-muted" v-if="errors[campo.campo_id]">
						  			Campo requerido
						  		</small>
					  	</div>
					</div>
					<div v-else-if="campo.tipo === 'option'">
						<div class="form-group" v-for="opcion in JSON.parse(campo.caracteristicas).opciones">
							<input type="radio" class=" form-control-solid"   
								:id="[[campo.campo_id]]"
							 	:name="[[campo.campo_id]]"
							 	:value="[[Object.keys(opcion)[0] ]]" v-model="model[campo.campo_id]" @change="cambioModelo" :required="isRequired( campo )">
							 	<label> {{ opcion[Object.keys(opcion)[0]] }}</label>
						</div>
					</div>
					<div v-else-if="campo.tipo === 'textbox' ">
						<div class="form-group fv-plugins-icon-container">
							<label>{{ campo.nombre }}</label>
							<textarea 
								:id="[[campo.campo_id]]"
							 	:name="[[campo.campo_id]]" 
							 	class="form-control form-control-solid form-control-lg" v-model="model[campo.campo_id]"
							 	@change="cambioModelo" :required="isRequired( campo )"</textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
</template>

<script>
    export default {
        props: ['tramite','formularioValido'],
        data() {
            return {
                campos: [],
                mostrar:false,
                model:{},
                errors: {}
            }
        },
  
        created() {
            this.recuperarDatosInStorage();
			this.obtenerCampos();
        },

        methods: {
		    cambioModelo() {
		    	let info = {};
		    	for (const property in this.model) {
				  	let campo = this.campos.find( campo => campo.campo_id == property  );
				  	
				  	info[property] = { name: campo.nombre.toLowerCase().split(' ').join('_'), value: this.model[property] };
				}
				
		    	const parsed = JSON.stringify(this.model);
                if( this.validarFormulario() ){
                	localStorage.setItem('datosFormulario', parsed); 
                }
		    },

		    validarFormulario(){
		    	let valido = true;
		    	 this.campos.forEach( campo =>{
                	if( this.isRequired(campo)) {
                		let campoValido = !!this.model[campo.campo_id];
                		/*if( campoValido ){
                			delete this.errors[nombreCampo];
                		} else{
                			this.errors[nombreCampo] = true;
                		}*/
                		
                		valido = valido && campoValido;
                	}
                });
                this.$emit('updatingScore', valido);
                return valido;
		    },


		    recuperarDatosInStorage(){
	            if (localStorage.getItem('datosFormulario')) {
	              	try {
	                	this.model = JSON.parse(localStorage.getItem('datosFormulario'));
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
				  	this.validarFormulario();
				} catch (error) {
				  	console.log(error);
				}
				this.mostrar = true;
				
		    },

		    isRequired(campo  ){
		    	let caracteristicas = JSON.parse(campo.caracteristicas);
	        	return !!caracteristicas.required;
	        },


		}

    }
</script>
