<template>
    <div class="col-md-12 col-lg-12">
        <div class="text-center">
            <div class="custom-control custom-radio custom-control-inline"  v-for="(opcion, i) in opciones" :key="i">
                <input type="radio" :value="opcion.value"  :name="opcion.name" class="custom-control-input" :id="opcion.id" v-model="modelo"  @change="cambioInput">
                <!--<input  name="tipoPersona"  >-->
                <label class="custom-control-label" :for="opcion.id">
                  {{opcion.label}}
                </label>
            </div>
        </div>
    </div>   
</template>

<script>
    export default {
        data() {
            return {
                opciones : [{
                    value:'normal',
                    name:'normal',
                    id:'checkTipoTramiteNormal',
                    label:'Normal'
                },
                {
                    value:'complementaria',
                    name:'complementaria',
                    id:'checkTipoTramiteComp',
                    label:'Complementaria'
                }],
                modelo:null
            }
        },
        props: ['default'],
        mounted() {
            this.modelo = this.default;
        },

        methods:{
            cambioInput(){
                this.$emit('valueRadio', this.modelo);
            }
        }
    }
</script>


