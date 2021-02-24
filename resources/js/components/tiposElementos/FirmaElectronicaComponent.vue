<template>
  <div>
    <iframe id="the_frame" :src="firma" style="width:100%; height:500px;" frameborder="0"> </iframe>

 </div>
</template>

<script>


export default {
    props: ['datosComplementaria', 'tipoTramite','usuario', 'pago'],
    data(){
        return{
            tramite : {},
            tramiteInfo: '',
            firma: '',
            access_token: '',
            resultId: '',
            multiple: '',
            doc: '',
            rfc: '',
            id:'',
            folio:'',
            llave:'',
        }
    },
    async mounted() {
        console.log('usuario: '+ this.usuario)
		this.tramiteInfo = await axios.get( process.env.TESORERIA_HOSTNAME+ "/solicitudes-get-tramite-pdf/" + this.usuario );
        var enajenantes = this.tramiteInfo.data.tramite.solicitudes[0].info.campos['Listado de enajenantes'].enajenantes;
        if(  enajenantes.length > 1  ){
            this.multiple = true;
            this.doc = [];
            this.folio = [];
            this.llave = [];
            for (let i = 0; i < enajenantes.length; i++) {
                this.doc.push( process.env.APP_URL +'/formato-declaracion/' + this.usuario + '/' + i );
                this.folio.push(enajenantes[i].datosPersonales.rfc);
                this.llave.push(i);
            }
        }else{
            this.doc ='';
            this.multiple = false;
            this.doc= process.env.APP_URL +'/formato-declaracion/' + this.usuario + '/0'; 
            this.folio = enajenantes[0].datosPersonales.curp;
            this.llave = "0";
        }
        this.rfc = this.tramiteInfo.data.tramite.solicitudes[0].info.solicitante.rfc;
        this.id = this.tramiteInfo.data.tramite.solicitudes[0].clave;


        console.log( 'documento: ' , this.doc);
        console.log( 'documento: ' , this.folio);
        console.log( 'documento: ' , this.llave);
        this.accesToken();
        this.encodeData();

    },
    methods: {


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            var rfc = 'GOFF951130TJ0';
            

            var data = {
                'perfil' : 'EI',
                'multiple' : this.multiple,
                'tramite' : this.id,
                'llave' : this.llave,
                'doc' : this.doc,
                'folio' : this.folio,
                'rfc' : rfc,
                // 'rfc' : this.rfc,
                'pagado' : 1,
              
            };

            const headers = { 
                "Authorization": "Bearer my-token",
                'Content-Type': 'application/json',
            };

            // axios.post(urlDataGeneric,{"tramite_id" : tramite_id, "value": JSON.stringify(data), "access_token" : this.access_token}, {headers})
            //     .then((restult) => { 
            //         console.log('////', restult) 
            //         self.resultId = result.data.id;
            //     })
            //     .catch((error)=> {
            //         console.log(error)
            //     })
            //     .finally(() => console.log('listo'))
           
                $.ajax({
                    type: "POST",
                    data: {"tramite_id" : this.id, "value": JSON.stringify(data), "access_token" : this.access_token},
                    dataType: 'json', 
                    url: urlDataGeneric,
                    async: false,
                    success:function(data){
                        self.resultId = data.data.id;
                    },
                    error:function(error){
                        console.log('error: ', error);
                    },
                    complete:function(){
                        console.log('id a consultar en insumos: ', self.resultId);
                    }
                });
         
            var encodedId = btoa(self.resultId); 
            var urlFinal = url+encodedId;
            this.firma = urlFinal;

           

        },

         accesToken(){
            var self = this;
            let url = "http://Insumos.test.nl.gob.mx/api/auth" ;  
            var data = { 'username' : 'fun1' , 'password': 'prueba123' };
            //  axios.post(url, data)
            //     .then(response => {
            //         self.access_token = response.data.token;
            //         console.log('token: ' , response.data.token);
            //     })
            //     .catch(error => {
            //         console.log('error al generar token: ', error);
            //     });
            $.ajax({
                type: "POST",
                data: data,
                dataType: 'json', 
                url,
                async: false,
                success:function(data){
                    self.access_token = data.token;
                },
                error:function(error){
                    console.log(error);
                },
                complete:function(){
                    console.log('accestoken generado', self.access_token);
                }
            });
        },

        
   
    },
 
}




          

        
          
           


          


      
 


</script>