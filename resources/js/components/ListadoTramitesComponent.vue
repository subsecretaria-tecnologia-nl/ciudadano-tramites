<template>
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <tramite-component v-for="(tramite, index) in tramites" :tramite="tramite" v-bind:key="index"></tramite-component>
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