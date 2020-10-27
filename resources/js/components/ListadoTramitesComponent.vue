<template>
    <div class="d-flex flex-column-fluid">

        <v-container v-if="loading">
            <v-row>
                <v-col cols="12" md="12">
                    <v-skeleton-loader  type="list-item" v-for="(r,i) in [1,2,3,4,5,6]" height="90px" style="margin-bottom: 8px;"></v-skeleton-loader>
                </v-col>
            </v-row>
        </v-container>


        <div class="container" v-if="!loading">
            <tramite-component v-for="(tramite, index) in tramites" :tramite="tramite" v-bind:key="index"></tramite-component>
        </div>
    </div>
</template>

<script>
    export default {    

        data() {
            return {
                tramites: [], loading:true
            }
        },
        created() {
            localStorage.removeItem('datosFormulario');
            localStorage.removeItem('listaSolicitantes');
            localStorage.removeItem('tramite');
            this.obtenerTramites();
        },

        methods: {


            async obtenerTramites(){
                let url = process.env.APP_URL + "/allTramites";
                try {
                    let response = await axios.get(url);
                    this.tramites = response.data;
                } catch (error) {
                    console.log(error);
                }
                this.loading = false;
            }

        }


    }
</script>