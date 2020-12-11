<template>
    <div class="card card-custom card-transparent">
                <div class="card-body p-0">
                    <!--begin: Wizard-->
                    <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="true" >
                        <!--begin: Wizard Nav-->
                        <div class="wizard-nav">
                            <div class="wizard-steps">
                                <!--begin::Wizard Step 1 Nav-->
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current" id="tab1" v-on:click="goTo(1)">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">1</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Datos</div>
                                            <div class="wizard-desc"> 
                                                Información sobre el trámite
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 1 Nav-->
                                <!--begin::Wizard Step 2 Nav-->
                                <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending" id="tab2" v-on:click="goTo(2)">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">2</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Solicitantes</div>
                                            <div class="wizard-desc">
                                                Solicitantes del trámite
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 2 Nav-->
                                <!--begin::Wizard Step 3 Nav-->
                                <div class="wizard-step mr-auto" data-wizard-type="step" data-wizard-state="pending" id="tab3" v-on:click="goTo(3)" >
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">3</div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">Finalizar</div>
                                            <div class="wizard-desc">
                                                Revisar y completar
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 3 Nav-->
                            </div>
                        </div>
                        <!--end: Wizard Nav-->
                        <!--begin: Wizard Body-->
                        <div class="card card-custom card-shadowless rounded-top-0">
                            <div class="card-body p-0">
                                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                    <div class="col-xl-12 col-xxl-7">
                                        <!--begin: Wizard Form-->
                                            <!--begin: Wizard Step 1 Campos tramite-->

                                            <div class="pb-5 c" data-wizard-type="step-content" data-wizard-state="current" id="step1">
                                                <campos-tramite-component :tramite="tramite" v-if="currentStep == 1"  
                                                :formularioValido="formularioValido" @updatingScore="updateScore" :comprobarEstadoFormularioCount="comprobarEstadoFormularioCount" @updatingFiles="updatingFiles"></campos-tramite-component>
                                            </div>
                                            <!--end: Wizard Step 1-->
                                            <!--begin: Wizard Step 2-->
                                            <div class="pb-5" data-wizard-type="step-content" id="step2" >
                                              <solicitantes-component v-if="currentStep == 2" @updatingSolicitante="updateSolicitante" ></solicitantes-component>
                                            </div>
                                            <!--end: Wizard Step 2-->
                                            <!--begin: Wizard Step 3-->
                                            <div class="pb-5" data-wizard-type="step-content" id="step3" >
                                                <resumen-tramite-component v-if="currentStep == 3"></resumen-tramite-component>
                                            </div>
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                                </div>
                                                <div >
                                                    <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"  v-if="currentStep == 3" v-on:click="agregar('guardaContinua')" :disabled="enviando">
                                                      Guardar y Continuar                                                                          <div id="spinner-guardaFina" class="spinner-border spinner-border-sm float-right" role="status" v-if="enviando" style="margin-left: 5px;">
                                                          <span class="sr-only">Loading...</span>
                                                      </div>
                                                    </button>
                                                   <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4"  v-if="currentStep == 3" v-on:click="agregar('finalizar')" :disabled="finalizando">
                                                      Finalizar 
                                                      <div id="spinner-finalizar" class="spinner-border spinner-border-sm float-right" role="status" v-if="finalizando" style="margin-left: 5px;">
                                                          <span class="sr-only">Loading...</span>
                                                      </div>
                                                    </button>
                                                    <button type="button" id="btnWizard" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next" v-on:click="next()" v-if="currentStep != 3">
                                                        Next
                                                    </button>
                                                </div>
                                            </div>
                                            <!--end: Wizard Actions-->
                                        <!--end: Wizard Form-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Wizard Bpdy-->
                    </div>
                    <!--end: Wizard-->
                </div>
    </div>
</template>

<script>
    import { uuid } from 'vue-uuid';
  
    export default {
        props: ['tramite','idUsuario'],
        mounted() {
            this.tramite.id_seguimiento =  uuid.v4();
            console.log(this.tramite.tramite)
            $("#tramite-name span").text(this.tramite.tramite.toUpperCase())
            const parsed = JSON.stringify(this.tramite);
            localStorage.setItem('tramite', parsed);
        },
  
        data() {
            return {
                currentStep: 1,
                datosIncompletos: true,
                enviando:false, finalizando:false,
                registrado: false,
                formularioValido: false,
                solicitantesValido: false,
                comprobarEstadoFormularioCount:0,
                files:[]
            }
        },
  
        methods: {
            updateScore(formularioValido) {
              $("#btnWizard").attr("disabled", true);
              if( formularioValido ){
                $("#btnWizard").attr("disabled", false);
              }
              this.formularioValido = formularioValido;
              this.$forceUpdate()
            },

            updatingFiles( files ){
              this.files = files;
            },

            updateSolicitante(solicitantesValido){ 
              $("#btnWizard").attr("disabled", true);
              this.solicitantesValido = solicitantesValido;
              if( solicitantesValido ){
                $("#btnWizard").attr("disabled", false);
              }
            },

            next: function (event) {
              if( (this.currentStep + 1) === 2 ){
                  this.comprobarEstadoFormularioCount++;
              }

              if( (this.currentStep + 1) === 3 && (!this.solicitantesValido || !this.formularioValido)){
                Command: toastr.warning("Aviso!", "Datos requeridos");
                return false;
              }

              if( (this.currentStep + 1) === 2 &&  !this.formularioValido){
                Command: toastr.warning("Aviso!", "Campos requeridos");
                return false;
              }


              $("#tab" + (this.currentStep + 1)).attr("data-wizard-state", "current");
              $("#tab" +  parseInt( this.currentStep )).attr("data-wizard-state", "");

              $("#step" + (this.currentStep + 1)).attr("data-wizard-state", "current");
              $("#step" + parseInt( this.currentStep) ).attr("data-wizard-state", "");
              this.currentStep = this.currentStep + 1;

            },

            goTo( idStep ){

                if(idStep == 2){
                  this.comprobarEstadoFormularioCount++;
                }
                
                if( idStep === 3 && (!this.solicitantesValido || !this.formularioValido)){
                  Command: toastr.warning("Aviso!", "Datos requeridos");
                  return false;
                }


                if( idStep === 2 &&  !this.formularioValido){
                  Command: toastr.warning("Aviso!", "Campos requeridos");
                  return false;
                }


                $("#step" + this.currentStep ).attr("data-wizard-state", "");
                $("#tab" + this.currentStep).attr("data-wizard-state", "");

                $("#tab" + idStep).attr("data-wizard-state", "current");
                $("#step" + idStep).attr("data-wizard-state", "current");
                this.currentStep = idStep;
            }, 

            async agregar( type){


                let listaSolicitantes = [];
                let tramite = {};
                let datosFormulario = {};



                if (localStorage.getItem('listaSolicitantes')) {
                  try {
                    listaSolicitantes = JSON.parse(localStorage.getItem('listaSolicitantes'));
                  } catch(e) {
                    localStorage.removeItem('listaSolicitantes');
                    goTo(2);
                  }
                }

                if (localStorage.getItem('tramite')) {
                  try {
                    tramite = JSON.parse(localStorage.getItem('tramite'));
                  } catch(e) {
                    localStorage.removeItem('tramite');
                  }
                }

                if (localStorage.getItem('datosFormulario')) {
                  try {
                    datosFormulario = JSON.parse(localStorage.getItem('datosFormulario'));
                  } catch(e) {
                    localStorage.removeItem('datosFormulario');
                    goTo(1);
                  }
                }
                let camposObj = {};
                datosFormulario.campos.forEach( campo =>  {
                  camposObj[campo.campo_id] = campo.valor;
                });
      
                let informacion = {
                  campos:camposObj,
                  costo_final:tramite.detalle.costo_final,
                  partidas: tramite.partidas,
                  detalle: tramite.detalle
                }

                let formData = new FormData();

                if( this.files && this.files.length > 0 ){
                  formData.append('file',this.files[0].valor );
                }
                formData.append('user_id', this.idUsuario );
                formData.append('info', JSON.stringify(informacion) );
                formData.append('solicitantes', JSON.stringify(listaSolicitantes) );
                formData.append('clave', tramite.id_seguimiento );
                formData.append('catalogo_id', tramite.id_tramite );

                //data = JSON.stringify(data);

                if( type == "finalizar" ){
                  this.finalizando = true;
                } else {
                  this.enviando = true;
                }

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
                  this.registrado = true;
                  if( type == "finalizar" ){
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
                this.finalizando = false;
            }
        }
    }
</script>