<template>
    <div class="container-fluid">
        <div v-if="listaSolicitantes.length > 0 && !agregarMas" >
            <div v-for="(sol, index) in listaSolicitantes" >
                <h6 class="font-weight-bolder mb-3">{{ sol.rfc }}</h6>
                <div class="text-dark-50 line-height-lg">
                    <div class="float-lg-left">
                        <div>{{ sol.tipoPersona == "pm" ? sol.razonSocial : sol.nombreSolicitante  }} </div>
                        <div>{{ sol.apPat }}</div>
                        <div>{{ sol.apMat }}</div>
                    </div>
                    <div class="float-lg-right">
                            <button type="button"  class="btn btn-danger"  id="btnEliminar" v-on:click="eliminar( index )">
                                <i class="fa fa-times" id="iconBtnEliminar"></i> 
                            </button>
                            <button type="button"  class="btn btn-info"  id="btnEditar" v-on:click="solicitante = sol ; editando = true; agregarMas = true; indiceEditando = index;">
                                <i class="fa fa-edit" id="iconBtnEditar"></i>
                            </button> 

                    </div> 
                </div>
                <!--
                <div class="text-center" style="margin-top: 2px">
                    <div class="border-top my-3"></div>  
                </div>
                -->
                
            </div>
            <div >
                    <button type="button"  class="btn"  id="btnAddMore" v-on:click="agregarMas = true">
                        <i class="fa fa-check" id="iconBtnAddMore"></i> 
                        Agregar Solicitante
                    </button>     
            </div>
        </div>
        <div v-else-if="listaSolicitantes.length == 0 || agregarMas">
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="pf" name="tipoPersona"  v-model="solicitante.tipoPersona" key="tipoPersona">Persona Física
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" value="pm" name="tipoPersona"  v-model="solicitante.tipoPersona" key="tipoPersona">Persona Moral
                </label>
            </div>
                <div class="row" id="divPF" v-if="solicitante.tipoPersona == 'pf'">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>RFC</label>
                            <input type="text" placeholder="RFC " id="rfc" class="form-control form-control-solid form-control-lg"   v-model="solicitante.rfc">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" placeholder="Nombre " id="nombreSolicitante" class="form-control form-control-solid form-control-lg" v-model="solicitante.nombreSolicitante">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Apellido Paterno</label>
                            <input type="text" placeholder="Apellido Paterno " id="apPatSolicitante" class="form-control form-control-solid form-control-lg" v-model="solicitante.apPat">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                            <label>Apellido Materno</label>
                            <input type="text" placeholder="Apellido Materno " id="apMatSolicitante" class="form-control form-control-solid form-control-lg" v-model="solicitante.apMat">
                        </div>
                    </div>
                </div>
                <div class="row" id="divPM" v-else-if="solicitante.tipoPersona == 'pm'">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>RFC</label>
                            <input type="text" placeholder="RFC " id="rfc" class="form-control form-control-solid form-control-lg" v-model="solicitante.rfc">
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label>Razón Social</label>
                            <input type="text" placeholder="Razón Social " id="razonSocial" class="form-control form-control-solid form-control-lg" v-model="solicitante.razonSocial">
                        </div>
                    </div>
                </div>
            <button type="button"  class="btn green pull-rigth"  id="btnAddMoreCancel" v-on:click="agregarMas = false" v-if="listaSolicitantes.length > 0 ">
                <i class="fa fa-times" id="iconBtnAddMoreCancel"></i> 
                Cancelar
            </button>  
            <button type="button"  class="btn green pull-rigth"  id="btnAdd" v-on:click="agregar()" v-if="!editando">
                <i class="fa fa-check" id="iconBtnAdd"></i> 
                Guardar
            </button>
            <button type="button"  class="btn green pull-rigth"  id="btnEditSi" v-on:click="editar(indiceEditando, solicitante)" v-if="editando">
                <i class="fa fa-check" id="iconBtnSi"></i> 
                Editar
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['tramite'],
        mounted() {

        },

        data(){
            return {
                solicitante: { tipoPersona:"pf" },
                listaSolicitantes:[],
                agregarMas: false,
                editando: false,
                indiceEditando:null
            }
        },
  
        methods: {
            agregar: function (event) {
                this.listaSolicitantes.push( this.solicitante );
                this.solicitante = { tipoPersona:"pf" };
                this.agregarMas = false;
            },

            eliminar( index ){
                this.listaSolicitantes.splice(index, 1);
            },

            editar(index, solicitanteNuevo){
                this.listaSolicitantes[index] = solicitanteNuevo;
                this.solicitante = { tipoPersona:"pf" };
                this.editando = false;
                this.indiceEditando = null;
                this.agregarMas = false;
            }

        }
    }
</script>
