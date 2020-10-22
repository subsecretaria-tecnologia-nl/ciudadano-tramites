<template>
    <div class="container">
        <div class="row justify-content-center">
            <tramite-component v-for="(tramite, index) in tramites" :tramite="tramite"></tramite-component>
        </div>
    </div>
</template>

<script>
    export default {    

        data() {
            return {
                tramites: []
            }
        },
        mounted() {
            axios
              .get(url)
              .then(response => {
                this.tramites = response.data;
              })
        }
    }
</script>