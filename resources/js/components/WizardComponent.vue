<template>
                        <div class="card card-custom card-transparent">
                                    <div class="card-body p-0">
                                        <!--begin: Wizard-->
                                        <div class="wizard wizard-4" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="true" >
                                            <!--begin: Wizard Nav-->
                                            <div class="wizard-nav">
                                                <div class="wizard-steps">
                                                    <!--begin::Wizard Step 1 Nav-->
                                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="current" id="tab1" v-on:click="goTo('1')">
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
                                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending" id="tab2" v-on:click="goTo('2')">
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
                                                    <div class="wizard-step" data-wizard-type="step" data-wizard-state="pending" id="tab3" v-on:click="goTo('3')">
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
                                                                    <campos-tramite-component :tramite="tramite"></campos-tramite-component>
                                                                </div>
                                                                <!--end: Wizard Step 1-->
                                                                <!--begin: Wizard Step 2-->
                                                                <div class="pb-5" data-wizard-type="step-content" id="step2" >
                                                                    <solicitantes-component></solicitantes-component>
                                                                </div>
                                                                <!--end: Wizard Step 2-->
                                                                <!--begin: Wizard Step 3-->
                                                                <div class="pb-5" data-wizard-type="step-content" id="step3">
                                                                    3
                                                                </div>
                                                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                                                    <div class="mr-2">
                                                                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                                                    </div>
                                                                    <div>
                                                                        <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                                                        <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next" v-on:click="next()">
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
    export default {
        props: ['tramite'],
        mounted() {
            console.log('Component wizar.')
            console.log( this.tramite)
        },
  
        data() {
            return {
                currentStep: 1,
            }
        },
  
        methods: {
            next: function (event) {
                
              $("#tab" + (this.currentStep + 1)).attr("data-wizard-state", "current");
              $("#tab" + this.currentStep).attr("data-wizard-state", "");

              $("#step" + (this.currentStep + 1)).attr("data-wizard-state", "current");
              $("#step" + this.currentStep ).attr("data-wizard-state", "");
              this.currentStep = this.currentStep + 1;
//$("#tab" + this.currentStep + 1).data("wizard-state", "current")
//              $("#step" + this.currentStep + 1).data("wizard-state", "current")

            },

            goTo( idStep ){
                $("#tab" + idStep).attr("data-wizard-state", "current");
                $("#step" + idStep).attr("data-wizard-state", "current");

                $("#step" + this.currentStep ).attr("data-wizard-state", "");
                $("#tab" + this.currentStep).attr("data-wizard-state", "");
                this.currentStep = idStep;
            }
        }
    }
</script>
<style type="text/css">
   .wizard.wizard-4 {
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column; }
  .wizard.wizard-4 .wizard-nav .wizard-steps {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: end;
    -ms-flex-align: end;
    align-items: flex-end;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap; }
    .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step {
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      -webkit-box-flex: 0;
      -ms-flex: 0 0 calc(25% - 0.25rem);
      flex: 0 0 calc(25% - 0.25rem);
      width: calc(25% - 0.25rem);
      background-color: #F3F6F9;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem; }
      .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        flex: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        color: #3F4254;
        padding: 2rem 2.5rem; }
        .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper .wizard-number {
          font-size: 1.3rem;
          font-weight: 600;
          -webkit-box-flex: 0;
          -ms-flex: 0 0 2.75rem;
          flex: 0 0 2.75rem;
          height: 2.75rem;
          width: 2.75rem;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-align: center;
          -ms-flex-align: center;
          align-items: center;
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          justify-content: center;
          background-color: rgba(54, 153, 255, 0.08);
          color: #3699FF;
          margin-right: 1rem;
          border-radius: 0.5rem; }
        .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper .wizard-label {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: vertical;
          -webkit-box-direction: normal;
          -ms-flex-direction: column;
          flex-direction: column; }
          .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper .wizard-label .wizard-title {
            font-size: 1.1rem;
            font-weight: 600; }
      .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] {
        background-color: #ffffff; }
        .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-wrapper .wizard-number {
          color: #ffffff;
          background-color: #3699FF; }
        .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step[data-wizard-state="current"] .wizard-wrapper .wizard-label .wizard-title {
          color: #3699FF; }
    .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="2"] .wizard-step {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 calc(50% - 0.25rem);
      flex: 0 0 calc(50% - 0.25rem);
      width: calc(50% - 0.25rem); }
    .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="3"] .wizard-step {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 calc(33.33333% - 0.25rem);
      flex: 0 0 calc(33.33333% - 0.25rem);
      width: calc(33.33333% - 0.25rem); }
    .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="4"] .wizard-step {
      -webkit-box-flex: 0;
      -ms-flex: 0 0 calc(25% - 0.25rem);
      flex: 0 0 calc(25% - 0.25rem);
      width: calc(25% - 0.25rem); }

@media (max-width: 1399.98px) {
  .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 calc(50% - 0.25rem);
    flex: 0 0 calc(50% - 0.25rem);
    width: calc(50% - 0.25rem);
    border-bottom-left-radius: 0.5rem;
    border-bottom-right-radius: 0.5rem;
    margin-bottom: 0.5rem; }
  .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="2"] .wizard-step, .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="4"] .wizard-step {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 calc(50% - 0.25rem);
    flex: 0 0 calc(50% - 0.25rem);
    width: calc(50% - 0.25rem); }
  .wizard.wizard-4 .wizard-nav .wizard-steps[data-total-steps="3"] .wizard-step {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    width: 100%; } }

@media (max-width: 767.98px) {
  .wizard.wizard-4 .wizard-nav .wizard-steps {
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start; }
    .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step {
      -webkit-box-flex: 0 !important;
      -ms-flex: 0 0 100% !important;
      flex: 0 0 100% !important;
      position: relative;
      width: 100% !important; }
      .wizard.wizard-4 .wizard-nav .wizard-steps .wizard-step .wizard-wrapper {
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -webkit-box-flex: 0;
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        padding: 0.5rem 2rem; } }

</style>