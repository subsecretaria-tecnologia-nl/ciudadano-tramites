<template>
  <div>
    <b-button style="color:white" @click="openModal(porcentajeAsignado)" :class="classBtn">
      <i :class="btnIcon" style="color:white"></i> 
      {{textBtnOpenModal}}
    </b-button>

    <b-modal size="lg" :id="idModa" ref="modal" :title="titleModal" @show="resetModal" @hidden="resetModal" @ok="handleOk" 
    :ok-title = "btnOkLabel">
      <b-container fluid>
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <b-form-group label="Seleccione tipo de persona" v-slot="{ ariaDescribedby }" v-if="enajenante.nacionalidad == 'mexicano'">
            <b-form-radio-group id="tipoPersona" v-model="enajenante.tipoPersona" :aria-describedby="ariaDescribedby" name="radio-options-tipoPersona">
              <template #first>
                <b-form-radio value="pf">Física</b-form-radio>
              </template>
              <b-form-radio value="pm">Moral</b-form-radio>
            </b-form-radio-group>
          </b-form-group>
          
          <b-row>
            <b-col v-if="enajenante.tipoPersona == 'pf'" cols="12" md="6">
              <b-form-group label="Curp" label-for="curp-input" >
                <b-form-input id="curp-input" name="curp" v-model="$v.form.curp.$model" aria-describedby="curp-input-feedback" 
                   :state="$v.form.curp.$dirty ? !$v.form.curp.$error : null" @change="updateCurp">></b-form-input>
                <b-form-invalid-feedback id="curp-input-feedback">
                  <span v-if="!$v.form.curp.required"  class="form-text text-danger">
                    Curp es requerida.
                  </span>
                  <span v-if="!$v.form.curp.curpPattern"  class="form-text text-danger">
                    La Curp no cumple con la regla de validación.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group label="RFC" label-for="rfc-input" >
                <b-form-input
                  id="rfc-input" name="rfc" v-model="$v.form.rfc.$model"  :state="$v.form.rfc.$dirty ? !$v.form.rfc.$error : null"  aria-describedby="rfc-input-feedback" 
                ></b-form-input>
                <b-form-invalid-feedback id="rfc-input-feedback">
                  <span v-if="!$v.form.rfc.required"  class="form-text text-danger">
                    El RFC es requerido.
                  </span>
                  <span v-if="!$v.form.rfc.rfcPattern"  class="form-text text-danger">
                    El RFC no cumple con la regla de validación.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col v-if="enajenante.tipoPersona == 'pm'" cols="12" md="6">
              <b-form-group label="Razón Social" label-for="razon-social-input" >
                <b-form-input id="razon-social-input" name="razonSocial" v-model="$v.form.razonSocial.$model" aria-describedby="razonSocial-input-feedback" 
                   :state="$v.form.razonSocial.$dirty ? !$v.form.razonSocial.$error : null" ></b-form-input>
                <b-form-invalid-feedback id="razonSocial-input-feedback">
                  <span v-if="!$v.form.razonSocial.required"  class="form-text text-danger">
                    Campo requerido
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col v-if="enajenante.tipoPersona == 'pf'" cols="12" md="6">
              <b-form-group label="Nombre(s)" label-for="nombre-input" >
                <b-form-input id="nombre-input" name="nombre" v-model="$v.form.nombre.$model" aria-describedby="nombre-input-feedback" 
                   :state="$v.form.nombre.$dirty ? !$v.form.nombre.$error : null" ></b-form-input>
                <b-form-invalid-feedback id="nombre-input-feedback">
                  <span v-if="!$v.form.nombre.required"  class="form-text text-danger">
                    El Nombre es requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>
            <b-col v-if="enajenante.tipoPersona == 'pf'" cols="12" md="6">
              <b-form-group label="Apellido Paterno" label-for="apPat-input" >
                <b-form-input id="apPat-input" name="apPat" v-model="$v.form.apPat.$model"  :state="$v.form.apPat.$dirty ? !$v.form.apPat.$error : null"  aria-describedby="apPat-input-feedback" 
                ></b-form-input>
                <b-form-invalid-feedback id="apPat-input-feedback">
                  <span v-if="!$v.form.apPat.required" class="form-text text-danger">
                    El Apellido Paterno es requerido.
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>          
          </b-row>
          <b-row v-if="enajenante.tipoPersona == 'pf'"  >
            <b-col cols="12" md="6">
              <b-form-group label="Apellido Materno" label-for="apmaterno-input" >
                <b-form-input  id="apmaterno-input" name="apmaterno"  v-model="enajenante.apMat"></b-form-input>
              </b-form-group>
            </b-col> 
            <b-col  cols="12" md="6">
              <b-form-group label="Fecha de Nacimiento" label-for="fechaNacimiento-input" >
                <b-form-datepicker  class="mb-2" id="fechaNacimiento-input" name="fechaNacimiento"  v-model="$v.form.fechaNacimiento.$model" :state="$v.form.fechaNacimiento.$dirty ? !$v.form.fechaNacimiento.$error : null" aria-describedby="fechaNacimiento-input-feedback" ></b-form-datepicker>
                <b-form-invalid-feedback id="fechaNacimiento-input-feedback">
                  <span v-if="!$v.form.fechaNacimiento.required" class="form-text text-danger">
                    La fecha de nacimiento es requerida
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>          
            <b-col cols="12" md="4">
              <b-form-group label="Género" label-for="genero-input" >
                <b-form-input  id="genero-input" name="genero"  v-model="$v.form.genero.$model" :state="$v.form.genero.$dirty ? !$v.form.genero.$error : null" aria-describedby="genero-input-feedback"></b-form-input>
                <b-form-invalid-feedback id="genero-input-feedback">
                  <span v-if="!$v.form.genero.required" class="form-text text-danger">
                    El género es requerido
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col> 
            <b-col cols="12" md="4">
              <b-form-group label="Estado de Nacimiento" label-for="estado-input" >
                <b-form-input  id="estado-input" name="estado"  v-model="$v.form.estado.$model" :state="$v.form.estado.$dirty ? !$v.form.estado.$error : null" aria-describedby="estado-input-feedback"></b-form-input>
                <b-form-invalid-feedback id="estado-input-feedback">
                  <span v-if="!$v.form.estado.required" class="form-text text-danger">
                    El estado es requerido
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>         
            <b-col cols="12" md="4">
              <b-form-group label="IFE" label-for="ife-input" >
                <b-form-input  id="ife-input" name="ife"  v-model="enajenante.ife" ></b-form-input>
              </b-form-group>
            </b-col>
            <b-col></b-col>
            </b-row>
          <b-row >
            <b-col>
              <b-form-group label="Porcentaje de compra" label-for="procentaje-compra-input" >
                <b-form-input  id="procentaje-compra-input" name="procentaje-compra"  v-model="$v.form.porcentajeCompra.$model" :state="$v.form.porcentajeCompra.$dirty ? !$v.form.porcentajeCompra.$error : null" aria-describedby="porcentajeCompra-input-feedback" type="range" max="100"></b-form-input>
                <b-form-input  id="procentaje-compra-input" name="procentaje-compra"  v-model="$v.form.porcentajeCompra.$model" :state="$v.form.porcentajeCompra.$dirty ? !$v.form.porcentajeCompra.$error : null" aria-describedby="porcentajeCompra-input-feedback" ></b-form-input>
                <b-form-invalid-feedback id="porcentajeCompra-input-feedback">
                  <span v-if="!$v.form.porcentajeCompra.required" class="form-text text-danger">
                    Valor requerido
                  </span>
                  <span v-if="!$v.form.porcentajeCompra.between" class="form-text text-danger">
                    El valor debe de estar en un rando de 1 a {{maxProcentajePermitido}};
                  </span>
                </b-form-invalid-feedback>
              </b-form-group>
            </b-col>         
          </b-row>
        </form>
      </b-container>
    </b-modal>

  </div>
</template>

<style type="text/css">
    .modal-backdrop {
        background-color: rgba(0,0,0,0.7);
    }
</style>
<script>
  import { uuid } from 'vue-uuid';
  import { validationMixin } from 'vuelidate'
  import { required, helpers, between  } from 'vuelidate/lib/validators';
  const rfcPattern = helpers.regex("mob", /^[A-ZÑ&]{3,4}\d{6}(?:[A-Z\d]{3})?$/);

  const curpPattern = helpers.regex("mob", /^[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/);

  export default {
    mixins: [validationMixin],
    props:{
      porcentajeAsignado: {
        default: 0,
        type: Number
      },
      enajenanteEditado:{
        default: null,
        type: Object
      },
      indexEnajenanteEditado:{
        default: null,
        type: Number
      }
    },
    mounted(){
              
      if(this.enajenanteEditado){
        let oldEnajentanteEditado = Object.assign({}, this.enajenanteEditado);
        this.enajenante.nacionalidad = oldEnajentanteEditado.nacionalidad;
        this.enajenante.tipoPersona = oldEnajentanteEditado.tipoPersona;
        this.enajenante.apMat = oldEnajentanteEditado.apMat;
        this.enajenante.ife = oldEnajentanteEditado.ife;
        this.form.rfc = oldEnajentanteEditado.rfc;
        this.form.curp = oldEnajentanteEditado.curp;
        this.form.nombre = oldEnajentanteEditado.nombre;
        this.form.apPat = oldEnajentanteEditado.apPat;
        this.form.fechaNacimiento = oldEnajentanteEditado.fechaNacimiento;
        this.form.genero = oldEnajentanteEditado.genero;
        this.form.estado = oldEnajentanteEditado.estado;
        this.form.razonSocial = oldEnajentanteEditado.razonSocial;
        this.form.porcentajeCompra= oldEnajentanteEditado.porcentajeCompra;
        this.titleModal = "Editar";
        this.btnOkLabel = "Editar";
        this.btnIcon = "la la-pencil";
        this.textBtnOpenModal = " ";
        this.classBtn = "btn-info";
      } else {
        this.titleModal = "Agregar";
        this.btnOkLabel = "Agregar";
        this.btnIcon = "la la-plus";
        this.textBtnOpenModal = "Agregar enajentante";
        this.classBtn = "btn bg-success w-80 mb-4";

         
      }
    },
    data() {
      return {
        enajenante: {
            nacionalidad:'mexicano',
            tipoPersona:'pf',
            apMat:'',
            ife:''
        },
        form: {
          rfc:'', curp:'', nombre:'', apPat:'', fechaNacimiento:'', genero:'', estado: '', porcentajeCompra:1,
          razonSocial:''
        },
        idModa:  uuid.v4(),
        btnIcon:'',titleModal:'', btnOkLabel:'', textBtnOpenModal:'',classBtn:'',
        maxProcentajePermitido:100

      }
    },
    computed:{
        rules(){
            if(this.enajenante.nacionalidad == 'mexicano' && this.enajenante.tipoPersona == 'pf'){
              return {
                rfc: { required, rfcPattern },
                curp: { required, curpPattern },
                nombre: { required },
                apPat: { required },
                fechaNacimiento:{ required }, 
                genero:{ required },
                estado:{ required },
                porcentajeCompra:{ required,  between: between(1, this.maxProcentajePermitido) }

              }
            } else if(this.enajenante.nacionalidad == 'mexicano' && this.enajenante.tipoPersona == 'pm'){
              return {
                rfc: { required, rfcPattern },
                razonSocial:{ required },
                porcentajeCompra:{ required,  between: between(1, this.maxProcentajePermitido) }

              }
            }else {
              return {
                rfc: {required,rfcPattern},
                porcentajeCompra:{ required,  between: between(1, this.maxProcentajePermitido) }
              }
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
        if(!this.enajenanteEditado){
          this.form = { rfc:'', curp:'', nombre:'', apPat:'', fechaNacimiento:'', genero:'', estado: '', porcentajeCompra:1, razonSocial:'' }
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
        let enajenante = this.form;
        enajenante.nacionalidad =  this.enajenante.nacionalidad;
        enajenante.tipoPersona =  this.enajenante.tipoPersona;
        enajenante.apMat = this.enajenante.apMat;
        enajenante.ife = this.enajenante.ife;
        if(this.enajenanteEditado){
          let response = {
            enajenante:enajenante, 
            index:this.indexEnajenanteEditado
          }
          this.$emit('editaEnajentante', response);
        }else{
          this.$emit('addEnajentante', enajenante);
        }
        // Hide the modal manually
        this.$nextTick(() => {
          this.$v.$reset();
          this.$bvModal.hide(this.idModa)
        })
      },
      openModal(porcentajeAsignado){

       if(this.enajenanteEditado){

            this.maxProcentajePermitido = 100  - (parseFloat(porcentajeAsignado) - parseFloat(this.form.porcentajeCompra) )  ;
          } else {
            this.maxProcentajePermitido = 100 - porcentajeAsignado ;
          }
        this.$bvModal.show(this.idModa)
      },
      async updateCurp(){
        console.log("seleccionar")
        if( !this.$v.form.curp.$invalid ){
          let response = await this.getToken();
          console.log(this.$v.form.curp)
          this.buscarCurp( this.$v.form.curp.$model, response.data.token );
        }
      },

      async buscarCurp(curp, token) {
        let url = "https://insumos.nl.gob.mx/api/consultacurp" ;   
        let data = { 'access_token' : token , 'curp' : curp  };

        var self = this;
        $.ajax({
            type: "GET",
            data: data,
            dataType: 'json', 
            url,
            success:function(data){
                self.rellenarForm(data);
                // this.$data = data.data.nombres;
            },
            error:function(error){
                console.log(error);
            },
            complete:function(){
                console.log('.');
            }
        });
      },

      rellenarForm(data){
          this.form.nombre = data.data.nombres;
          this.form.apPat = data.data.apePat;
          this.enajenante.apMat = data.data.apeMat;

          this.form.fechaNacimiento =  data.data.fechaNac.split("/").reverse().join("-");
          this.form.genero = data.data.sexo;
          this.form.estado = data.data.entidadNac;
      },

      async getToken(){
        let url = "https://insumos.nl.gob.mx/api/auth" ;  
        let data = { 'username' : 'fun1' , 'password': 'prueba123' };

        try {
            let response = await axios.post(url, data, {
               headers:{
                  "Content-type":"application/json"
              }
            });
            
            return response;
        } catch (error) {
            console.log(error);
        }
      },
    },
    watch: {
      enajenante:{
        handler: function (val, oldVal) {
          if( val.nacionalidad == 'extranjero'){
            delete val.tipoPersona;
          } else {
            val.tipoPersona = val.tipoPersona ? val.tipoPersona : 'pf';
          }
        },
        deep: true

      }
    }
  }
</script>