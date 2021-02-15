<template>

</template>
<script>

    import Vue from 'vue'
    const CAMPO_DIVISAS = "Cambio de divisas";
    const CAMPO_FECHA_DE_ESCRITURA_O_MINUTA                     = "FECHA DE ESCRITURA O MINUTA";

    export default {
        name: 'CalculoCosto5ISRComponent',
        props: ['datosParaDeterminarImpuesto', 'campos', 'tramite', 'tipoPersona', 'index'],
        mounted() {

            let paramsCosto = {};
            let multaCorreccion            = this.datosParaDeterminarImpuesto.multaCorreccion;
console.log("datos para detterminar");
console.log(JSON.parse(JSON.stringify(this.datosParaDeterminarImpuesto)))

            paramsCosto.monto_operacion     = this.formatoNumero(this.datosParaDeterminarImpuesto.montoOperacion);
            paramsCosto.pago_provisional_lisr    = this.formatoNumero(this.datosParaDeterminarImpuesto.pagoProvisional);
            paramsCosto.ganancia_obtenida   = this.formatoNumero(this.datosParaDeterminarImpuesto.gananciaObtenida);

            paramsCosto.fecha_escritura   = this.getCampoByName(CAMPO_FECHA_DE_ESCRITURA_O_MINUTA).valor.split("-").map(dato => Number(dato)).join("-");
            let campoDivisas               = this.getCampoByName(CAMPO_DIVISAS);
            if( multaCorreccion ){
                paramsCosto.multa_correccion_fiscal = this.formatoNumero(multaCorreccion);
            }
            if( campoDivisas ){
                paramsCosto.divisa = campoDivisas.valor.clave;
            }

            this.getCosto(paramsCosto)
        },


  
        methods: {

            getCampoByName( nameCampo ){
                return this.campos.find( campo => campo.nombre.toLowerCase()  === nameCampo.toLowerCase() );
            }, 


            formatoNumero(numberStr){
                let valor =  Number((numberStr+"").replace(/[^0-9.-]+/g,""));
                return valor;
            },

            async getCosto(params){
 
                params.id_seguimiento = this.tramite.id_seguimiento,
                params.tramite_id = this.tramite.id_tramite,
                params.tipoPersona = this.tipoPersona
                try {
                    let url = process.env.APP_URL + "/getcostoImpuesto";
                    let response = await axios.post(url, params);
                   

                    //let detalleTramite = response.data;


                    //this.tramite.detalle =  detalleTramite;


                    //const parsed = JSON.stringify(this.tramite);
                    //localStorage.setItem('tramite', parsed);  
                    this.$emit('costosObtenidos', {respuestaCosto:response.data, indice:this.index});
                    //this.obteniendoCosto = false;
                } catch (error) {
                    console.log(error);
                }
                //data = this.getParamsCalculoCosto(consulta_api, data, tipo_costo_obj);
            },
        }
    }
</script>
