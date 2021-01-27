<template>
  <div>
    <iframe id="the_frame" :src="firma" style="width:100%; height:500px;" frameborder="0"> </iframe>
    <iframe id="the_frame" src="http://Insumos.test.nl.gob.mx/signature?data=YSUzQTclM0ElN0JzJTNBNiUzQSUyMnBlcmZpbCUyMiUzQnMlM0EyJTNBJTIyQUUlMjIlM0JzJTNBNyUzQSUyMnRyYW1pdGUlMjIlM0JzJTNBNCUzQSUyMjM4OTYlMjIlM0JzJTNBNSUzQSUyMmxsYXZlJTIyJTNCcyUzQTEwJTNBJTIyMTlBMDAwMDM4NyUyMiUzQnMlM0EzJTNBJTIyZG9jJTIyJTNCcyUzQTQ4JTNBJTIyaHR0cCUzQSUyRiUyRnd3dy5hZnJpY2F1LmVkdSUyRmltYWdlcyUyRmRlZmF1bHQlMkZzYW1wbGUucGRmJTIyJTNCcyUzQTUlM0ElMjJmb2xpbyUyMiUzQnMlM0ExNiUzQSUyMjI2MDhDYmp3ZW42VDM4OTYlMjIlM0JzJTNBMyUzQSUyMnJmYyUyMiUzQnMlM0ExMyUzQSUyMkNBRUU5NDA3Mjg2SDYlMjIlM0JzJTNBNiUzQSUyMnBhZ2FkbyUyMiUzQmklM0ExJTNCJTdE" style="width:100%; height:500px;" frameborder="0"> </iframe>
 </div>
</template>

<script>
export default {
    data(){
        return{
            firma: '',
        }
    },
    methods: {
        encodeData(){
            var  url = "http://Insumos.test.nl.gob.mx/signature?data=";
            // $catastroInsumos = @@catastroinsumos;
            var urlDocumento = 'http://www.orimi.com/pdf-test.pdf';
            var tramite_id = 1111;
            var llave = 2222;
            var folio = 333333;
            var rfc = 'CACJ960722HNLSMM14';


            var data = [{
                'perfil' : 'AE',
                'tramite' : tramite_id,
                'llave' : llave,
                'doc' : urlDocumento,
                'folio' : folio,
                'rfc' : rfc,
                'pagado' : 1
            }];

            var encodedData = btoa(encodeURIComponent(JSON.stringify(data)));
            var urlFinal = url+encodedData;
            this.firma = urlFinal;
            console.log(encodedData);
        }
    },
    mounted() {
        this.encodeData();
    }
}
</script>

<style>

</style>