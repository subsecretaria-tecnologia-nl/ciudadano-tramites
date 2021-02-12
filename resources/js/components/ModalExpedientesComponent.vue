<template>
  <div>
    <b-button style="color:white" @click="openModal()" :class="classBtn">
      <i :class="btnIcon" style="color:white"></i> 
      Agregar expediente
    </b-button>

    <b-modal size="md" :id="idModa" ref="modal" :title="titleModal" @show="resetModal" @hidden="resetModal" @ok="handleOk" 
    :ok-title = "btnOkLabel" :ok-disabled="!direccion.datos_direccion">
      <b-container fluid>
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <b-row>
            <b-col cols="12" md="12">
              <b-form-group label="No. EXP. CATASTRAL" label-for="expediente-input" >
                <b-form-input
                  id="expediente-input" name="expediente" v-model="$v.form.expediente.$model"  :state="$v.form.expediente.$dirty ? !$v.form.expediente.$error : null"  aria-describedby="expediente-input-feedback" @change="getDatosDomicilio"></b-form-input>
                <b-form-invalid-feedback id="expediente-input-feedback">
                  <span v-if="!$v.form.expediente.required"  class="form-text text-danger">
                    El Expediente es requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
          </b-row>        
        </form>
        <transition name="bounce">
          <div class="card" v-if="direccion && direccion.datos_direccion">
            <div class="card-body">
                  <div class="row">
                    <h2 class="mb-3">Ubicación:</h2>
                  </div>
                  <hr>
                  <b-container class="bv-example-row">
                    <div>
                      <p v-if="direccion.datos_direccion[0].calle">
                        <strong>Calle</strong>: 
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].calle}}
                        </span>  
                      </p>
                    </div>
                    <div>
                        <p v-if="direccion.datos_direccion[0].num_ext">
                          <strong>N° ext</strong>: 
                          <span class="text-muted">
                            {{direccion.datos_direccion[0].num_ext}}
                          </span>
                        </p>
                        <p v-if="direccion.datos_direccion[0].num_int">
                          <strong>N° int</strong>: 
                          <span class="text-muted">
                            {{direccion.datos_direccion[0].num_int}}
                          </span>
                        </p>
                    </div>
                    <div>
                      <p v-if="direccion.datos_direccion[0].manzana">
                        <strong>Manzana</strong>: {{direccion.datos_direccion[0].manzana}}.
                      </p> 
                      <p v-if="direccion.datos_direccion[0].lote">
                        Lote:{{direccion.datos_direccion[0].lote}}.
                      </p> 
                    </div>
                     <div v-if="direccion.datos_direccion[0].edificio">
                      <p>
                        <strong>Edificio</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].edificio}}.
                        </span>
                      </p> 
                      <p v-if="direccion.datos_direccion[0].cp">
                        <strong>CP</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].cp}}.
                        </span>
                      </p>
                    </div>                       
                    <div>
                      <p v-if="direccion.datos_direccion[0].colonia">
                        <strong>Colonia</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].colonia}}.
                        </span>
                      </p> 
                      <p v-if="direccion.datos_direccion[0].nombre_loc">
                        <strong>Nombre Localidad</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].nombre_loc}}.
                        </span>
                      </p>
                    </div>
                    <div>
                      <p v-if="direccion.datos_direccion[0].cruzamiento1">
                        <strong>Cruzamiento</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].cruzamiento1}}.
                        </span>
                      </p>
                      <p v-if="direccion.datos_direccion[0].clave_loc">
                        <strong>Clave Localidad</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].clave_loc}}.
                        </span>
                      </p> 
                      <p v-if="direccion.datos_direccion[0].cruzamiento2">
                        <strong>Cruzamiento 2</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].cruzamiento2}}.
                        </span>
                      </p>
                      <p v-if="direccion.datos_direccion[0].tipo_vialidad">
                        <strong>Vialidad</strong>:  
                        <span class="text-muted">
                          {{direccion.datos_direccion[0].tipo_vialidad}}.
                        </span>
                      </p>
                  </div>
                   </b-container>
            </div>
          </div>
          <div v-else key="edit">
            Ubicación No encontrada
          </div>
        </transition>
      </b-container>
    </b-modal>

  </div>
</template>

<script>
  import { uuid } from 'vue-uuid';
  import { validationMixin } from 'vuelidate'
  import { required, helpers, between  } from 'vuelidate/lib/validators';

  export default {
    mixins: [validationMixin],
    mounted(){
        this.titleModal = "Agregar";
        this.btnOkLabel = "Agregar";
        this.btnIcon = "la la-plus";
        this.textBtnOpenModal = "Agregar enajenante";
        this.classBtn = "btn bg-success w-80 mb-4";
    },
    data() {
      return {
        direccion:{},
        form: {
          expediente:'',
        },
        idModa:  uuid.v4(),
        btnIcon:'',titleModal:'', btnOkLabel:'', textBtnOpenModal:'',classBtn:'',
      }
    },
    computed:{
        rules(){
          return {
            expediente: { required },
          }
      
        }
    },
    validations() {
      return {
        form: this.rules
      }
    },
    methods: {
      resetModal() {
          this.form = { expediente:''}
      },
      handleOk(bvModalEvt) {
        // Prevent modal from closing
        bvModalEvt.preventDefault()
        // Trigger submit handler
        this.handleSubmit()
      },
      handleSubmit() {

        this.$v.form.$touch()
        // Exit when the form isn't valid
        if (this.$v.form.$anyError) {
          return
        }
        // Push the name to submitted names
        //this.submittedNames.push(this.name)
        let expediente = this.form;
        expediente.direccion =  this.direccion;
        this.$emit('addExpediente', expediente);

        // Hide the modal manually
        this.$nextTick(() => {
          this.$v.$reset();
          this.$bvModal.hide(this.idModa)
        })
      },
      openModal(porcentajeAsignado){
        this.direccion = {};

        this.$bvModal.show(this.idModa)
      },
      async getDatosDomicilio(){
        if( !this.$v.form.expediente.$invalid ){         
          this.buscarDatosDomicilio( this.$v.form.expediente.$model );
        } else {
          this.rellenarForm();
        }
      },

      async buscarDatosDomicilio(nExpediente) {
        let url = process.env.TESORERIA_HOSTNAME + "/insumos-catastro-consulta" ;
        let response = await axios.get(url + '/' + nExpediente);
        if(response.data){
          this.rellenarForm(response.data);
        } else {
          this.rellenarForm();
        }
      },

      rellenarForm(data){
        if(data){
          this.direccion = data;
        } else {
          this.direccion = {};
        }
      },
    }
  }
</script>