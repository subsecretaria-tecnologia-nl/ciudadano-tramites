<template>
	<div id="contenedorCampos" class="container-fluid">
		<div class="text-center" id="loadin" style=" margin-bottom: 9px;" v-if="!mostrar" >
			<div class="spinner-grow" role="status">
			  	<span class="sr-only">Loading...</span>
			</div>
		</div>
		<div class="" v-if="mostrar">
			<form>
				<div v-for="campo in campos" class="">
					<div v-if="campo.tipo === 'input'">
					  	<div class="form-group fv-plugins-icon-container">
						  	<div class="form-group fv-plugins-icon-container">
						  		<label>{{ campo.nombre }}</label>
						  		<input type="text" class="form-control form-control-solid form-control-lg"  
						  			:placeholder="[[campo.nombre]]" :id="[[campo.nombre.toLowerCase().split(' ').join('_')]]"
						  			v-model="model[campo.nombre.toLowerCase().split(' ').join('_')]"  @change="cambioModelo"/>
						  	</div>
					  		
					  	</div>
					</div>
					<div v-else-if="campo.tipo === 'select'">
					  	<div class="form-group fv-plugins-icon-container">
					  		<label>{{ campo.nombre }}</label>
					  		<select :id="[[campo.nombre.toLowerCase().split(' ').join('_')]]" :name="[[campo.nombre.toLowerCase().split(' ').join('_')]]"
					  			class="form-control form-control-solid form-control-lg"
					  			v-model="model[campo.nombre.toLowerCase().split(' ').join('_')]" @change="cambioModelo">
					  			<option v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
					  			:value="[[Object.keys(opcion)[0] ]]">
					  				{{ opcion[ Object.keys(opcion)[0] ] }}
					  			</option>
					  		</select>
					  	</div>
					</div>
					<div v-else-if="campo.tipo === 'option'">
						<div class="form-group" v-for="opcion in JSON.parse(campo.caracteristicas).opciones">
							<input type="radio" class=" form-control-solid"   
								:id="[[campo.nombre.toLowerCase().split(' ').join('_')]]"
							 	:name="[[campo.nombre.toLowerCase().split(' ').join('_')]]"
							 	:value="[[Object.keys(opcion)[0] ]]" v-model="model[campo.nombre.toLowerCase().split(' ').join('_')]" @change="cambioModelo">
							 	<label> {{ opcion[Object.keys(opcion)[0]] }}</label>
						</div>
					</div>
					<div v-else-if="campo.tipo === 'textbox' ">
						<div class="form-group fv-plugins-icon-container">
							<label>{{ campo.nombre }}</label>
							<textarea 
								:id="[[campo.nombre.toLowerCase().split(' ').join('_')]]"
							 	:name="[[campo.nombre.toLowerCase().split(' ').join('_')]]" 
							 	class="form-control form-control-solid form-control-lg" v-model="model[campo.nombre.toLowerCase().split(' ').join('_')]"
							 	@change="cambioModelo"></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
</template>

<script>
    export default {
        props: ['tramite'],
        data() {
            return {
                campos: [],
                mostrar:false,
                model:{}
            }
        },
  
        mounted() {
            if (localStorage.getItem('datosFormulario')) {
              try {
                this.model = JSON.parse(localStorage.getItem('datosFormulario'));
              } catch(e) {
                localStorage.removeItem('datosFormulario');
              }
            }

            axios
              	.get(urlObtnerCampos, { params: { id_tramite: this.tramite.id_tramite } })
              	.then(response => {
                	let html  = "";
                	this.campos = response.data;
            	}).finally( () => {
					this.mostrar = true;
				});

        },

        methods: {
		    cambioModelo() {
		    	const parsed = JSON.stringify(this.model);
                localStorage.setItem('datosFormulario', parsed); 
		    }
		}

    }
</script>
