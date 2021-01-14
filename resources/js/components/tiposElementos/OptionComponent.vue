<template>
  	<div>
  		<div class="" v-for="opcion in JSON.parse(campo.caracteristicas).opciones">
  			<input type="radio" class=" "    
  				:id="[[campo.campo_id]]"
  			 	:name="[[campo.campo_id]]"
  			 	:value="[[Object.keys(opcion)[0] ]]" v-model="campo.valor" @change="validar" @focus="validar" >
  			 	<label> {{ opcion[Object.keys(opcion)[0]] }}</label>
  		</div>
	</div>
</template>

<script>
    export default {
      props: ['campo', 'estadoFormulario', 'showMensajes'],
      created() {
        this.validar();
      },
      methods: {

        validar(){console.log("calidando")
          let requeridoValido = true;
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }

          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required) {
            requeridoValido =  !!this.campo.valor;
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }
          this.campo.valido = requeridoValido ;
          this.$emit('updateForm', this.campo);
        }
      }
    }
</script>