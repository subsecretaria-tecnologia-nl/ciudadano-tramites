<template>
	<div class=" fv-plugins-icon-container">
		<label>{{ campo.nombre }}</label>
		<select :id="[[campo.campo_id]]" :name="[[campo.campo_id]]" 
			:multiple="campo.tipo == 'multiple'"
			class="form-control  form-control-lg" style="background-color: #e5f2f5 !important"
			v-model="campo.valor" @change="validar" @focus="validar">
			<option v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
				:value="[[Object.keys(opcion)[0] ]]">
					{{ opcion[ Object.keys(opcion)[0] ] }}
			</option>
		</select>
		<small  class="form-text text-muted" v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || estadoFormulario > 0)">
			<span v-for="mensaje in campo.mensajes">
				{{ mensaje.mensajeStr }}
			</span>
		</small>
	</div>
</template>

<script>
    export default {
      props: ['campo', 'estadoFormulario', 'showMensajes'],

      created(){
        if(this.campo.tipo == 'multiple'){
          this.campo.valor = this.campo.valor || [];  
        }
        this.validar();
      },
      methods: {

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
            requeridoValido =  this.campo.valor && this.campo.valor.length > 0;
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
        }
      }
    }
</script>