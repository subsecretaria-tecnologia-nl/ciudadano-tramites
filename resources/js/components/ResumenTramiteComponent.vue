<template>
        <div class="container">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Trámite:</h6>
                            <div>
                                <strong> {{ tramite.tramite }}</strong>
                            </div>
                            <div >
                                Total: 
                                <span v-if="tramite.detalle"> $ {{tramite.detalle.costo_final }} </span>
                                <span class="spinner-border spinner-border-sm" v-if="!tramite.detalle"></span>
                            </div>
                            
                        </div>
                    </div>

                    <div class="table-responsive-sm" v-if="listaSolicitantes.length > 0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="center">RFC</th>
                                <th>Nombre ó Razon Social</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(sol, index) in listaSolicitantes" >
                                    <td class="left strong">{{ sol.rfc }}</td>
                                    <td class="center">
                                        {{ sol.tipoPersona == "pm" ? sol.razonSocial : sol.nombreSolicitante  }} 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

</template>

<script>
    export default {
        mounted() {
            if (localStorage.getItem('listaSolicitantes')) {
              try {
                this.listaSolicitantes = JSON.parse(localStorage.getItem('listaSolicitantes'));
              } catch(e) {
                localStorage.removeItem('listaSolicitantes');
              }
            }

            if (localStorage.getItem('tramite')) {
              try {
                this.tramite = JSON.parse(localStorage.getItem('tramite'));
              } catch(e) {
                localStorage.removeItem('tramite');
              }
            }

            if (localStorage.getItem('datosFormulario')) {
                try {
                    this.datosFormulario = JSON.parse(localStorage.getItem('datosFormulario'));
                } catch(e) {
                    localStorage.removeItem('datosFormulario');
                }
            }

            axios
              .post(urlCostos, {  
                    valor_catastral: this.datosFormulario.valor_catastral,
                    id_seguimiento: this.tramite.id_seguimiento,
                    tramite_id: this.tramite.id_tramite,
                    valor_operacion: this.datosFormulario.valor_de_operacion,
                    oficio:62
               })
              .then(response => {
                this.tramite.detalle =  response.data[0];
                this.$forceUpdate();
              }).finally(  () => {
                    
              })

            
        },

        data(){
            return {
                tramite: {  },
                listaSolicitantes:[],
                datosFormulario:{}
            }
        },
  
        methods: {
            agregar: function (event) {

            },


        }
    }
</script>

