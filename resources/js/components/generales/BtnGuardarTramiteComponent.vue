<template>
	<button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"   
		v-on:click="agregar()" :disabled="enviando">
        {{ labelBtn }}                                                              
        <div id="spinner-guardaFina" class="spinner-border spinner-border-sm float-right" role="status" 
        	v-if="enviando" style="margin-left: 5px;">
            <span class="sr-only">Loading...</span>
        </div>
    </button>
</template>

<script>
    import BtnGuardarTramiteParent from './BtnGuardarTramiteParent'
    export default {
        data() {
            return {
              enviando:false,
            }
        },
        extends: BtnGuardarTramiteParent, //heredamos del componente BtnGuardarTramiteParent!
        
        methods:{
            agregar(){
              let url = process.env.TESORERIA_HOSTNAME + (  this.type == 'temporal' ? "/solicitudes-register-temporal" : "/solicitudes-register" )
              this.guardar(url);
            },
            
            async guardar(url){
              let formData = this.getFormData(); 
              this.enviando = true;
              try {
                let response = await axios.post(url, formData, {
                  headers:{
                      'Content-Type': 'application/json',
                  },
                });
                this.$emit('tramiteAgregadoEvent', {type:this.type, respuesta:true, response});
              } catch (error) {
                console.log(error);
                Command: toastr.warning("Error!", "No fue posible registrar intente de nuevo");

              }
              this.enviando = false;
            }



        }
    }
</script>

