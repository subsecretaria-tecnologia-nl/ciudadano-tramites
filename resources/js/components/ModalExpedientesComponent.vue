<template>
  <div>
    <b-button style="color:white" @click="openModal()" :class="classBtn">
      <i :class="btnIcon" style="color:white"></i> 
      Agregar expediente
    </b-button>

    <b-modal size="xl" :id="idModa" ref="modal" :title="titleModal" @show="resetModal" @hidden="resetModal" @ok="handleOk" 
    :ok-title = "btnOkLabel" :ok-disabled="!direccion.datos_direccion">
      <b-container fluid>
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <b-row>
            <b-col cols="12" md="4" >
              <b-form-group label="Estado" label-for="estado-select" >
                <multiselect id="estado-select" v-model="$v.form.estado.$model" :options="estados" label="nombre" track-by="clave" 
                :searchable="true" @input="getMunicipios" :state="$v.form.estado.$dirty ? !$v.form.estado.$error : null"  aria-describedby="estado-select-feedback"  ></multiselect>
                <b-form-invalid-feedback id="estado-select-feedback">
                  <span v-if="!$v.form.estado.required"  class="form-text text-danger">
                    Estado requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col cols="12" md="4" >
              <b-form-group label="Municippio" label-for="municipio-select" >
                <multiselect id="municipio-select" v-model="$v.form.municipio.$model" :options="municipios" label="nombre" track-by="clave" 
                :searchable="true" :state="$v.form.municipio.$dirty ? !$v.form.municipio.$error : null"  aria-describedby="municipio-select-feedback"  @input="setValMunicipio"></multiselect>
                <b-form-invalid-feedback id="municipio-select-feedback">
                  <span v-if="!$v.form.municipio.required"  class="form-text text-danger">
                    Municipio requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col cols="12" md="4" >
              <b-form-group label="No. EXP. CATASTRAL" label-for="expediente-input" >
                <b-input-group size="lg"> 
                  <template #prepend>
                    <b-input-group-text >{{clave}}</b-input-group-text>
                  </template>
                  <b-form-input v-mask="'##-###-###'"
                    id="expediente-input" name="expediente" v-model="$v.form.expediente.$model"  :state="$v.form.expediente.$dirty ? !$v.form.expediente.$error : null"  aria-describedby="expediente-input-feedback" @change="getDatosDomicilio"
                    :disabled="$v.form.municipio.$invalid"></b-form-input>
                </b-input-group>
                <b-form-invalid-feedback id="expediente-input-feedback">
                  <span v-if="!$v.form.expediente.required"  class="form-text text-danger">
                    El Expediente es requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
          </b-row>        
        </form>
        <transition name="slide-fade">
          <div class="card" v-if="direccion && direccion.datos_direccion" key="yes">
            <div class="card-body">
                
                  <h6 class="pt-3 pl-3">Datos</h6>
                  <hr>
                  <div class="overflow-auto" style="height:350px;">
                      <tree-component
                        class="item"
                        :item="direccion"
                      ></tree-component>
                  </div>
<!--
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
                   </b-container>-->
            </div>
          </div>
          <div v-else-if="$v.form.expediente.$dirty && !$v.form.expediente.$invalid && !(direccion && direccion.datos_direccion)" key="no">
            Ubicación No encontrada
          </div>
        </transition>
      </b-container>
    </b-modal>

  </div>
</template>

<script>
  import Vue from 'vue';
  import { uuid } from 'vue-uuid';
  import { validationMixin } from 'vuelidate'
  import { required, helpers, between  } from 'vuelidate/lib/validators';
  import Multiselect from 'vue-multiselect';
  import VueMask from 'v-mask';
  Vue.use(VueMask);
  export default {
    components: { Multiselect },
    mixins: [validationMixin],
    mounted(){
        this.titleModal = "Agregar";
        this.btnOkLabel = "Agregar";
        this.btnIcon = "la la-plus";
        this.textBtnOpenModal = "Agregar enajenante";
        this.classBtn = "btn bg-success w-80 mb-4 btn-block";

        
        this.getEstados();
    },
    data() {
      return {
        direccion:{},
        form: {
          expediente:'', estado:{ "clave": "19", "nombre": "NUEVO LEÓN" }, municipio:{ "clave": "70", "nombre": "Monterrey", "claveEstado": "19" }
        },
        idModa:  uuid.v4(),
        btnIcon:'',titleModal:'', btnOkLabel:'', textBtnOpenModal:'',classBtn:'',
        estados:[], municipios:[], clave: "70"
      }
    },
    computed:{
        rules(){
          return {
            expediente: { required },
            estado: { required }, municipio: { required },
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
          this.form = { 
            expediente:'', estado:{ "clave": "19", "nombre": "NUEVO LEÓN" }, municipio:{ "clave": "70", "nombre": "Monterrey", "claveEstado": "19" }
        }
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
        expediente.expediente = this.$v.form.expediente.$model;
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
        let response = await axios.get(url + '/' + this.clave + nExpediente.split("-").join(""));
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

      async getEstados(){
          let url = process.env.TESORERIA_HOSTNAME + "/obtener-estados" ; 
          let options = await this.obtenerOptions(url);
          this.estados = options; 
          this.getMunicipios();
      },

      async obtenerOptions(url){
        let response = await axios.get(url);
        let options = response.data ? response.data : [];
        return options;
      },

      async getMunicipios(){
        
        if(this.$v.form.estado.$model.clave){
          let clave = this.$v.form.estado.$model.clave;
          let url =  process.env.TESORERIA_HOSTNAME + "/obtener-municipios/" + clave ;  
          let options = await this.obtenerOptions(url);
          this.municipios = options.map( option => {
            option.claveEstado = clave;
            return option;
          }); 
        }
      },

      setValMunicipio(){
        this.clave = this.$v.form.municipio.$model.clave;
        this.getDatosDomicilio();
      }
    }
  }
</script>