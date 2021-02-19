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
              
              let formData = null; 
              this.enviando = true;

              let datosTabs = JSON.parse( JSON.stringify(this.obtenerDatosTabs() ) );

              let listaSolicitantes = datosTabs[0];
              let tramite = datosTabs[1];
              let datosFormulario = datosTabs[2];

              let informacion = this.getInformacion( tramite, datosFormulario );


              if(tramite.tramite ==  "5% de Enajenación de Inmuebles" && this.type != 'temporal'){
                this.guardarMultiplesTramites( datosFormulario, listaSolicitantes, tramite, informacion, url )
              } else {
                formData = this.getFormData();
                this.guardarTramiteUnico(formData, url); 
              } 
            },

            async guardarTramiteUnico(formData, url){

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
            },

            async guardarMultiplesTramites(datosFormulario, listaSolicitantes, tramite, informacion,url){
                let camposEnajenantes = datosFormulario.campos.find( (campo) => campo.tipo == 'enajenante');
                let id_seguimiento = tramite.id_seguimiento;
                if(camposEnajenantes && camposEnajenantes.valor && camposEnajenantes.valor.enajenantes){
                  let requests = [];
                  let enajenantes = [];
                  if(datosFormulario.errorAlguardar ){
                    enajenantes = camposEnajenantes.valor.enajenantes.filter(  enajenante => enajenante.status && !enajenante.status.guardado)
                  }  else{
                    enajenantes = camposEnajenantes.valor.enajenantes;
                  }
                  enajenantes.forEach( (enajenante, indice) => {
                    

                      informacion.detalle = enajenante.detalle;
                      informacion.enajenante = enajenante;
                      delete enajenante.detalle;
                      tramite.id_seguimiento = id_seguimiento + "-" + indice;
                      let idEdicion = null;
                      if(  this.infoGuardadaFull && this.infoGuardadaFull.id && indice == 0 ){//solo editamo el primer enajenant si es edicion, el segundo sera un registro nuevo
                        idEdicion = this.infoGuardadaFull.id ;
                        tramite.id_seguimiento = id_seguimiento ;
                      }

                      let formData = this.buildFormData(informacion, listaSolicitantes, tramite, idEdicion);
                      let indiceEnajenante = enajenante.indice || indice;
                      let request = axios.post(url, formData, {headers:{'Content-Type': 'application/json', indiceEnajenante:indiceEnajenante}})
                      requests.push(request);
                  });

                  axios.all(requests).then(axios.spread((...responses) => {
                    this.$emit('tramiteAgregadoEvent', {
                      type:this.type, respuesta:true, responses
                    });
                  })).catch((err)=>{
                    this.$emit('tramiteAgregadoEvent', {type:this.type, respuesta:false, err});
                  }).finally(()=>{
                    this.enviando = false;
                  });
                }
            }





        }
    }
</script>

