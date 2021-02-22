<template>
    <div class="card card-custom card-transparent">
                <div class="card-body p-0">
                    <!--begin: Wizard-->
                    <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="true" >
                        <!--begin: Wizard Nav-->
                        <div class="wizard-nav">
                            <div class="wizard-steps">
                                <!--begin::Wizard StepS Nav-->
                                <div v-for="(step, i) in steps" class="wizard-step" data-wizard-type="step" :data-wizard-state="step.state" :id="step.id" v-on:click="goTo(step.clickGotTo)">
                                    <div class="wizard-wrapper">
                                        <div class="wizard-number">
                                          {{ step.wizardNumber}}
                                        </div>
                                        <div class="wizard-label">
                                            <div class="wizard-title">
                                              {{ step.wizardTitle}}
                                            </div>
                                            <div class="wizard-desc">
                                                {{ step.wizardDesc}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wizard StepS Nav-->
                            </div>
                        </div>
                        <!--end: Wizard Nav-->
                        <!--begin: Wizard Body-->
                        <div class="card card-custom card-shadowless rounded-top-0">
                            <div class="card-body p-0">
                                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                                    <div class="col-xl-12 col-xxl-12">
                                        <!--begin: Wizard Form-->
                                            <!--begin: Wizard Step 1 Campos tramite-->
                                            <div class="pb-5 c" data-wizard-type="step-content" data-wizard-state="current" id="step1">
                                              <div v-if="tramite.tramite == '5% de Enajenación de Inmuebles' && camposGuardadosObtenidos">
                                                <radio-option-component
                                                  :default="tipoTramite"
                                                  @valueRadio="cambioRadio"
                                                  :disabledDefault='tipoTramiteDisabled'></radio-option-component>
                                              </div>
                                              <div v-if="(tipoTramite == 'normal' || tipoTramite == 'declaracionEn0') && camposGuardadosObtenidos" >
                                                <campos-tramite-component :tramite="tramite" v-if="currentStep == 1"
                                                :formularioValido="formularioValido" @updatingScore="updateScore" :comprobarEstadoFormularioCount="comprobarEstadoFormularioCount" @updatingFiles="updatingFiles" :infoGuardada="infoGuardada" :declararEn0="declararEn0">

                                                </campos-tramite-component>
                                              </div>
                                              <div v-else-if="tipoTramite == 'complementaria' && camposGuardadosObtenidos">
                                                  <formulario-complementaria-component @updatingScore="updateScore"
                                                  @sendData="setDatosComplementaria" :infoGuardada="infoGuardada">
                                                  </formulario-complementaria-component>
                                              </div>
                                            </div>
                                            <!--end: Wizard Step 1-->
                                            <!--begin: Wizard Step 2-->
                                            <div class="pb-5" data-wizard-type="step-content" id="step2" >
                                              <solicitantes-component v-if="currentStep == 2 && camposGuardadosObtenidos" @updatingSolicitante="updateSolicitante" :solicitantesGuardados="solicitantesGuardados" :usuario="usuario"></solicitantes-component>
                                            </div>
                                            <!--end: Wizard Step 2-->
                                            <!--begin: Wizard Step 3-->
                                            <div class="pb-5" data-wizard-type="step-content" id="step3" >
                                                <div v-if="tramite.tramite == '5% de Enajenación de Inmuebles'">
                                                  <resumen-tramite-5-isr-component v-if="currentStep == 3"
                                                  :tipoTramite="tipoTramite" 
                                                  :datosComplementaria="datosComplementaria" 
                                                  :files="files" 
                                                  :usuario="usuario" :errors="errors">
                                                  </resumen-tramite-5-isr-component>
                                                </div>
                                                <div v-else-if="tramite.tramite != '5% de Enajenación de Inmuebles'">
                                                  <resumen-tramite-component v-if="currentStep == 3" 
                                                  :tipoTramite="tipoTramite" 
                                                  :datosComplementaria="datosComplementaria" 
                                                  ></resumen-tramite-component>
                                                </div>
                                                  <div class="pt-10 pl-10 pr-10">
                                                    <firma-electronica-component  :usuario="usuario" v-if="tramite.id_tramite == 399 && currentStep == 3" :datosComplementaria="datosComplementaria" :tipoTramite="tipoTramite" ></firma-electronica-component>
                                                  </div>
                                            </div>
                                            <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                <div class="mr-2">
                                                    <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                                </div>
                                                <div >
                                                  <div class="btn-group" role="group" aria-label="Basic example">
                                                     <btn-guardar-tramite-component
                                                      type="temporal"
                                                      :tipoTramite="tipoTramite"
                                                      :files="files"
                                                      :datosComplementaria="datosComplementaria"
                                                      :idUsuario="idUsuario"
                                                      :infoGuardadaFull="infoGuardadaFull" v-if="currentStep != 3" labelBtn="Guardar y Continuar después "
                                                      @tramiteAgregadoEvent="tramiteAgregadoEvent"
                                                      ></btn-guardar-tramite-component>

                                                    <btn-guardar-tramite-component
                                                      :tipoTramite="tipoTramite"
                                                      :files="files"
                                                      :datosComplementaria="datosComplementaria"
                                                      :idUsuario="idUsuario"
                                                      :infoGuardadaFull="infoGuardadaFull" v-if="currentStep == 3" labelBtn="Guardar y Continuar"
                                                      @tramiteAgregadoEvent="tramiteAgregadoEvent"
                                                      ></btn-guardar-tramite-component>
                                                    <btn-guardar-tramite-component
                                                      type="finalizar"
                                                      :tipoTramite="tipoTramite"
                                                      :files="files"
                                                      :datosComplementaria="datosComplementaria"
                                                      :idUsuario="idUsuario"
                                                      :infoGuardadaFull="infoGuardadaFull" v-if="currentStep == 3" labelBtn="Finalizar"
                                                      @tramiteAgregadoEvent="tramiteAgregadoEvent"
                                                      ></btn-guardar-tramite-component>
                                                    <button type="button" id="btnWizard" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next" v-on:click="next()" v-if="currentStep != 3">
                                                        Next
                                                    </button>
                                                  </div>
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
import FirmaElectronicaComponent from './tiposElementos/FirmaElectronicaComponent.vue';

    export default {
        props: ['tramite','idUsuario', 'clave', 'usuario'],
        computed:{
            declararEn0(){
                return this.tipoTramite == 'declaracionEn0';
            }
        },
        mounted() {

            this.tramite.id_seguimiento = this.clave ? this.clave : uuid.v4();
            $("#tramite-name span").text(this.tramite.tramite.toUpperCase())
            const parsed = JSON.stringify(this.tramite);
            localStorage.setItem('tramite', parsed);

            if( this.clave ){
               this.obtenerCamposTemporales();
            } else {
              this.camposGuardadosObtenidos = true;
            }
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
                files:[],
                tipoTramite:'normal',
                datosComplementaria:[],
                infoGuardada:{}, camposGuardadosObtenidos: false,
                infoGuardadaFull:{},
                solicitantesGuardados:[],
                tipoTramiteDisabled:'',
                steps:[{
                  id:"tab1",
                  state:'current',
                  clickGotTo:1,
                  wizardNumber:1,
                  wizardTitle:'Datos',
                  wizardDesc:'Información sobre el trámite',
                },{
                  id:"tab2",
                  state:'pending',
                  clickGotTo:2,
                  wizardNumber:2,
                  wizardTitle:'Solicitante',
                  wizardDesc:'Solicitante del trámite',
                },{
                  id:"tab3",
                  state:'pending',
                  clickGotTo:3,
                  wizardNumber:3,
                  wizardTitle:'Finalizar',
                  wizardDesc:'Revisar y completar',
                }],
                errors:[]
                //declararEn0:false
            }
        },

        methods: {
          tramiteAgregadoEvent(data){
            this.errors = [];
            if(data.respuesta){
              let totalAgregados = data.response ? 1 : data.responses.length;
              let totalCarritoActual = parseInt( $("#totalTramitesCarrito" ).text( ));
              $("#totalTramitesCarrito" ).text( totalCarritoActual + totalAgregados  );

           
                Command: toastr.success("Listo !", "El trámite ha sido agregado");
              
              if( data.type == "finalizar" ){
                console.log("redirigir")
                redirect("/nuevo-tramite");
              } if(data.type=="temporal"){
                redirect("/nuevo-tramite");
              }else {
                localStorage.removeItem('listaSolicitantes');
                localStorage.removeItem('datosFormulario');
                delete this.tramite.detalle;
                const parsed = JSON.stringify(this.tramite);
                localStorage.setItem('tramite', parsed);
                this.goTo(1);
              }
            } else {

              if(data.err && data.err.config && data.err.config.headers.indiceEnajenante){
                this.errors = data.err.config;
              }
            }

          },
          updateScore(formularioValido) {
            $("#btnWizard").attr("disabled", true);
            if( formularioValido ){
              $("#btnWizard").attr("disabled", false);
            }
            this.formularioValido = formularioValido;
            this.$forceUpdate()
          },

            setDatosComplementaria(datos){
              this.datosComplementaria = datos;
            },

            updatingFiles( files ){
              this.files = files;
            },

            updateSolicitante(solicitantesValido){
              this.solicitantesValido = solicitantesValido;
              $("#btnWizard").attr("disabled", !solicitantesValido);
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

            // INICIA CONFLICTO
            buildFormData(informacion, listaSolicitantes, tramite){
              let formData = new FormData();
              if( this.files && this.files.length > 0 ){
                this.files.forEach( (file, index) => {
                    if(this.files[index].valor && this.files[index].valor.name){
                      formData.append('file['+  index +']', this.files[index].valor);
                      formData.append('descripcion['+  index +']',  this.files[index].nombre );
                    }
                });
              }
              formData.append('user_id', this.idUsuario );
              formData.append('info', JSON.stringify(informacion) );
              if( listaSolicitantes && listaSolicitantes.length > 0 ){
                formData.append('solicitantes', JSON.stringify(listaSolicitantes) );
              }
              formData.append('clave', tramite.id_seguimiento );
              formData.append('catalogo_id', tramite.id_tramite );
              if(  this.infoGuardadaFull && this.infoGuardadaFull.id  ){
                formData.append('id', this.infoGuardadaFull.id );
                //formData.append('status', 80 );
              }
              return formData;
            },

            getStorage(key, goTab){
                if (localStorage.getItem(key)) {
                  try {
                    return JSON.parse(localStorage.getItem(key));
                  } catch(e) {
                    localStorage.removeItem(key);
                    if(  goTab ){
                      goTo(goTab);
                      return false;
                    }
                    
                  }
                }
            },

            obtenerDatosTabs(){
                let listaSolicitantes = this.getStorage( 'listaSolicitantes', 2 );
                let tramite = this.getStorage( 'tramite' );
                let datosFormulario = this.getStorage( 'datosFormulario', 1);
                return [listaSolicitantes, tramite, datosFormulario];
            },

            async agregar( type){
                let formData = this.getFormData();

                if( type == "finalizar" ){
                  this.finalizando = true;
                } else {
                  this.enviando = true;
                }

                // CON ESTE SE GUARDA EL REGISTRO DEL TRAMITE
                // CREAR RUTA PARA GUARDAR EN BATCH
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
            },
            // TERMINA CONFLICTO
            
            cambioRadio(valor){
              this.tipoTramite = valor;
            },


            async obtenerCamposTemporales(){

              let url = process.env.TESORERIA_HOSTNAME + "/solicitudes-get-tramite/" + this.tramite.id_seguimiento;
              try {
                let response = await axios.get(url);

                this.infoGuardadaFull = response.data[0];

                this.infoGuardada =  JSON.parse( response.data[0].info );

                if( response.data[0].archivos.length > 0 ){
                  this.infoGuardada.archivosGuardados = response.data[0].archivos;
                }

                this.tipoTramite = this.infoGuardada.tipoTramite;
                this.tipoTramiteDisabled = !this.infoGuardada.campos ? 'normal' : 'complementaria';

                this.camposGuardadosObtenidos = true;

                this.solicitantesGuardados = response.data.map( solicitante => {
                  let solicitanteNuevo = JSON.parse(solicitante.info).solicitante;
                  if( solicitanteNuevo ){
                    solicitanteNuevo.id = solicitante.id;
                  }
                  return solicitanteNuevo;
                });

              } catch (error) {
                  console.log(error);
              }
            },

        }
    }
</script>
