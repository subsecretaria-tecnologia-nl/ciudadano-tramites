<template>
  <div class=" fv-plugins-icon-container">
    <div class="input-group">
      <div class="input-group-prepend">
      <span class="input-group-text" id="inputGroupFileAddon01">
          {{ campo.nombre}}
      </span>
      </div>
      <div class="custom-file">
        <input  
          :id="[[campo.campo_id]]"
          :name="[[campo.campo_id]]" 
          class="custom-file-input"  style="background-color: #e5f2f5 !important"
          ref="fileInput"
          type="file" @change="validar"/>
        <label class="custom-file-label" :for="[[campo.campo_id]]">
          <span :id="[[campo.campo_id]]+ '-' + [[campo.nombre.replace('*', '')]]+'-namefile'">  
            {{ campo.attach || 'Seleccione archivo' }}
          </span>
        </label>
      </div>
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

        validar(){
          let requeridoValido = false;
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }
          var fileInput = document.getElementById(this.campo.campo_id );
          if( fileInput && fileInput.files.length > 0  ){
            requeridoValido = true;
            $("#"+ this.campo.campo_id + '-' + this.campo.nombre.replace('*', '') + '-namefile' ).text(  fileInput.files[0].name );
          } else {
            requeridoValido = false;
          }
          if( !requeridoValido ){
            let mensaje = { 
              tipo:'required',
              mensajeStr: "El archivo " + this.campo.nombre + " es requerido"
            }
            this.campo.mensajes.push( mensaje );
          }
          this.campo.valido =  requeridoValido;
          this.$emit('updateForm', this.campo);
        }
      }
    }
</script>