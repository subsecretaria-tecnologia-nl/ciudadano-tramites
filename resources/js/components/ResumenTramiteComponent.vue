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
            this.obtenerInformacionDelTramite();
            this.obtenerCosto();
        },

        data(){
            return {
                tramite: {  },
                listaSolicitantes:[],
                datosFormulario:{}
            }
        },
  
        methods: {
            obtenerInformacionDelTramite(){
                let informacionEnStorage = ["listaSolicitantes", "tramite", "datosFormulario"];
                informacionEnStorage.forEach( name => {
                    if (localStorage.getItem(name)) {
                      try {
                        this[name] = JSON.parse(localStorage.getItem(name));
                      } catch(e) {
                        letocalStorage.removeItem(name);
                      }
                    }
                });
            },

            async obtenerCosto(){
                let url = process.env.APP_URL + "/getcostoTramite";
                let data = {  
                    valor_catastral: this.datosFormulario.valor_catastral,
                    id_seguimiento: this.tramite.id_seguimiento,
                    tramite_id: this.tramite.id_tramite,
                    valor_operacion: this.datosFormulario.valor_de_operacion,
                    oficio:62
                }
                
                try {
                    let response = await axios.post(url, data);
                    let detalleTramite = response.data;
                    this.tramite.detalle =  detalleTramite[0];
                    this.$forceUpdate();
                } catch (error) {
                    console.log(error);
                }
            }

        }
    }
</script>

