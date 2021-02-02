<template>
	<button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"   
		v-on:click="agregar()" :disabled="disabled || enviando">
        Guardar y Continuar component                                                                 
        <div id="spinner-guardaFina" class="spinner-border spinner-border-sm float-right" role="status" 
        	v-if="enviando" style="margin-left: 5px;">
            <span class="sr-only">Loading...</span>
            {{ disabled }}
        </div>
    </button>
</template>

<script>
    import BtnGuardarTramiteParent from './BtnGuardarTramiteParent'
    export default {
        data() {
            return {
              enviando:false,
              tipo :""
            }
        },
        extends: BtnGuardarTramiteParent, //heredamos del componente BtnGuardarTramiteParent!
        

        mounted() {
          this.tipo = this.type ? this.type : 'finalizar'
        },

        methods:{
            async agregar(){
              this.enviando = true;
              
              let formData = this.getFormData(); 

              let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-register";
              try {
                  let response = await axios.post(url, formData, {
                    headers:{
                        'Content-Type': 'application/json',
                    },
                  });

                  let totalCarritoActual = parseInt( $("#totalTramitesCarrito" ).text( ));
                  $("#totalTramitesCarrito" ).text( totalCarritoActual + 1  );
                  Command: toastr.success("Listo!", response.data.Message);

                  if( this.tipo == "finalizar" ){
                    redirect("/nuevo-tramite");
                  } else {
                    localStorage.removeItem('listaSolicitantes');
                    localStorage.removeItem('datosFormulario');
                    delete this.tramite.detalle;
                    const parsed = JSON.stringify(this.tramite);
                    localStorage.setItem('tramite', parsed);
                    this.goTo(1);
                  }
              } catch (error) {
                console.log(error);
                Command: toastr.warning("Error!", "No fue posible registrar intente de nuevo");

              }

              this.enviando = false;
            },



        }
    }
</script>

