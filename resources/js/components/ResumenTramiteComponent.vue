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
                                <span v-if="!obteniendoCosto"> $ {{tramite.detalle.costo_final }} </span>
                                <span class="spinner-border spinner-border-sm" v-if="obteniendoCosto"></span>
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
                datosFormulario:{},
                obteniendoCosto:true
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
                let campoCatastral = this.datosFormulario.campos.find( campo => campo.nombre === "Valor catastral");
                let campoValorOperacion = this.datosFormulario.campos.find( campo => campo.nombre === "Valor de operacion")
             
                let url = process.env.APP_URL + "/getcostoTramite";
                let data = {  
                    valor_catastral: campoCatastral.valor || 0,
                    id_seguimiento: this.tramite.id_seguimiento,
                    tramite_id: this.tramite.id_tramite,
                    valor_operacion: campoValorOperacion.valor || 0,
                    oficio:62
                }
                
                try {
                    let response = await axios.post(url, data);
                    let detalleTramite = response.data;
                    this.tramite.detalle =  detalleTramite[0];

                    const parsed = JSON.stringify(this.tramite);
                    localStorage.setItem('tramite', parsed);  
                    this.$forceUpdate();
                    this.obteniendoCosto = false;
                } catch (error) {
                    console.log(error);
                    this.obteniendoCosto = false;
                }
                
            }

        }
    }
</script>

