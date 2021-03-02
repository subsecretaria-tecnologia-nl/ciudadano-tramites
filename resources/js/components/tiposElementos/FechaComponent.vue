<template>
    <div class=" fv-plugins-icon-container" id="fechaElement">
        <label>
         {{ campo.nombre }}  {{JSON.parse(this.campo.caracteristicas + '').required == 'true' ? '*' : '' }}
        </label>
        <b-form-datepicker   :id="campo.campo_id + ''" :name="campo.nombre"  v-model="campo.valor"        
              @change="validar" style="background-color: #e5f2f5 !important"
        @focus="validar" @input="validar" :show-decade-nav="showDecadeNav">
              	</b-form-datepicker>
       
        <small  v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || estadoFormulario > 0)">
	        <span v-for="mensaje in campo.mensajes" class="form-text text-danger">
	          {{ mensaje.mensajeStr }}
	        </span>
    	</small>
    </div>
</template>

<script>

    export default {
      
      props: ['campo', 'estadoFormulario', 'showMensajes'],
      created() {
        this.validar();
      },
      data(){
        return {
          showDecadeNav: true
        }
      },
      methods: {

        validar(){
       		this.campo.mensajes = [];
          let requeridoValido = true;
          let caracteristicas= this.getCaracteristicas();
          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required === 'true') {
            requeridoValido =  !!this.campo.valor && (this.campo.valor+"").length > 0;
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }
          this.campo.valido =  requeridoValido;
          this.$forceUpdate();
          this.$emit('updateForm', this.campo);
        },

        getCaracteristicas(){
          let caracteristicas = {};
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }
          return caracteristicas;
        },
      }
    }
</script>