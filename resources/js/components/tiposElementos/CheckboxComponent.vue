<template>
    <div class="">
      <input type="checkbox"    
        :id="[[campo.campo_id]]"
        :name="[[campo.campo_id]]"
        v-model="campo.valor" @change="validar" @focus="validar" >
        <label> {{ campo.nombre }}</label>
    </div>
</template>
  
<script>

    export default {
      
      props: ['campo', 'estadoFormulario', 'showMensajes'],
      created() {
        this.validar();
      },
      methods: {

        validar(){

          let requeridoValido = true;
          /*
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }

          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required) {
            requeridoValido =  this.campo.valor && this.campo.valor.length > 0;
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }*/
          this.campo.valido = requeridoValido;
          this.$emit('updateForm', this.campo);
        }
      }
    }
</script>