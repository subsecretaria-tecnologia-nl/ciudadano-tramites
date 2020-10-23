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
                            <div>Madalinskiego 8</div>
                            <div>71-101 Szczecin, Poland</div>
                            <div>Email: info@webz.com.pl</div>
                            <div>Phone: +48 444 666 3333</div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
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
        props: ['tramite'],
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
        },

        data(){
            return {
                tramite: {  },
                listaSolicitantes:[],
            }
        },
  
        methods: {
            agregar: function (event) {

            },


        }
    }
</script>
