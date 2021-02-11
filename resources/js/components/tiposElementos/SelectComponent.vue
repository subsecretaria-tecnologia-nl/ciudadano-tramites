<template>
	<div class=" fv-plugins-icon-container">
		<label>{{ campo.nombre }}</label>
    <multiselect v-model="campo.valor" :options="options" :multiple="campo.tipo == 'multiple'" label="nombre" track-by="clave" :searchable="true" @input="validar" ></multiselect>
		<small v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || estadoFormulario > 0)" class="position-absolute">
			<p v-for="mensaje in campo.mensajes" class="form-text text-danger">
				{{ mensaje.mensajeStr }}
			</p>
		</small>
	</div>
</template>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style type="text/css">
  .multiselect__tags, .multiselect__single{
    background: #e5f2f5 !important
  }
  .multiselect__tag{
    background:#3699FF !important;
    
  }
  .multiselect__tag>span{
    color: white;
  }

  .multiselect__option--highlight{
    background:#e5f2f5 !important;
  }
  
</style>
<script>
  import Multiselect from 'vue-multiselect';
    export default {
      components: { Multiselect },
      data(){
          return {
            options:[],
          }
      },
      props: ['campo', 'estadoFormulario', 'showMensajes', 'estado'],

      created(){
        let options = JSON.parse(this.campo.caracteristicas).opciones;
        if(options.length > 0){
          if(options && options[0]["clave"] && options[0]["nombre"]){
            this.options = options;
          } else {
            this.options= options.map( (opcion, key) =>{
              let nombre = opcion[Object.keys(opcion)];
              let clave = Object.keys(opcion)[0];
              let newOption = { clave, nombre }
              return newOption;
            });
          }
        }
        
        this.validar();
        this.opcionesEstado();
      },
      mounted(){
        if(this.campo.nombre== "Cambio de divisas" && !this.campo.valor){
          this.campo.valor = {clave: "PESOS", nombre: "Pesos"}
          //$("#"+ this.campo.nombre.split(' ').join('_') ).val("PESOS");
          this.validar();
        }
      },
      methods: {
        opcionesEstado(){
          if( this.campo.nombre == 'Estado'){
            var self = this;
            let url = process.env.TESORERIA_HOSTNAME + "/obtener-estados" ;  
             axios.get(url).then(data => { this.options = data.data;}).catch(error => {
                 console.log(error);
            });
          }
        },
        validar(){
          let requeridoValido = true;
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }
          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required === 'true') {
            if(this.campo.tipo == 'multiple'){
              requeridoValido =  this.campo.valor && this.campo.valor.length > 0; 
            } else {
              requeridoValido =  !!this.campo.valor; 
            }
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }
          this.campo.valido = requeridoValido;
          this.$emit('updateForm', this.campo);
          this.$forceUpdate();
        }
      },

      watch: {
        estado: function() {
          if( this.campo.nombre == 'Municipio'){
            this.options = [];
            //this.campo.valor = null; //si no se permiten municipios de diferentes estados descomentar esta linea
            var self = this;
            if( this.estado &&  this.estado.clave){
              let url =  process.env.TESORERIA_HOSTNAME + "/obtener-municipios/" + this.estado.clave ;  
                axios.get(url).then(data => { self.options = data.data; })
                .catch(error => {
                  console.log(error);
                });
            }
          }
        }
      }
    }
</script>