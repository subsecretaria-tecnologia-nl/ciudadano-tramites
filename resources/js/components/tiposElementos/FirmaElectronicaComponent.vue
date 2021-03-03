<template>
  <div>
    <iframe id="the_frame" :src="firma" style="width:100%; height:500px;" frameborder="0"> </iframe>
 </div>
</template>

<script>


export default {
    props: ['datosComplementaria', 'tipoTramite','usuario', 'pago', 'id', 'user'],
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
            folio:'',
            llave:'',
            idFirmado: [],
            urlFirmado: [],
            guardado: false,
        }
    },
    beforeDestroy(){
        window.removeEventListener('beforeunload');
    },
    mounted() {
    
        if (this.usuario.solicitudes.length === 1 ) {
            this.doc ='';
            this.multiple = false;
            this.doc= process.env.APP_URL +'/formato-declaracion/' + this.usuario.solicitudes[0].id; 
            this.folio = "0"  ;
            this.llave = this.usuario.solicitudes[0].id;
            this.urlFirmado.push('http://insumos.test.nl.gob.mx/documentos/firmas//' + this.usuario.tramite_id + "/" +  this.usuario.solicitudes[0].id + "_" +   this.usuario.tramite_id + "_firmado" );
            this.idFirmado.push(this.usuario.solicitudes[0].id);
        }else{
               this.multiple = true;
                this.doc = [];
                this.folio = [];
                this.llave = [];
             for (let i = 0; i < this.usuario.solicitudes.length; i++) {
                // si es multiple entra por aqui jeje si no ->\
                this.doc.push( process.env.APP_URL +'/formato-declaracion/' + this.usuario.solicitudes[i].id );
                this.llave.push( this.usuario.solicitudes[i].id );
                this.folio.push( i );
                this.idFirmado.push(this.usuario.solicitudes[i].id);
                this.urlFirmado.push('http://insumos.test.nl.gob.mx/documentos/firmas//' + this.usuario.tramite_id + "/" +  this.usuario.solicitudes[i].id + "_" +   this.usuario.tramite_id + "_firmado" );
            }
        }
        this.rfc = this.user.rfc;
        this.accesToken();
        this.encodeData();
        this.eventListenerIframe();


        var myConfObj = {
            iframeMouseOver : false
        }
        window.addEventListener('load',function(){
        if(myConfObj.iframeMouseOver){
            console.log('Wow cargo');
        }
        });

        document.getElementById('the_frame').addEventListener('mouseover',function(){
            myConfObj.iframeMouseOver = true;
        });
        document.getElementById('the_frame').addEventListener('mouseout',function(){
            myConfObj.iframeMouseOver = false;
});


       

    },
    methods: {

        eventListenerIframe(){
            var iframe = document.getElementById('the_frame');
            console.log("-------");
            iframe.contentDocument.body.addEventListener('beforeunload', function(){
            console.log("---.----");
            var guardarInfo = [ this.idFirmado, this.urlFirmado ]
            $.ajax({
                    type: "POST",
                    data: { guardarInfo }, 
                    dataType: 'json', 
                    url:  process.env.TESORERIA_HOSTNAME +"/solicitudes-guardar-carrito",
                    async: false,
                    success:function(data){
                        console.log(data);
                        console.log("considerate guardado");
                    },
                    error:function(error){
                        console.log('error: ', error);
                    },
                    complete:function(){
                        console.log('xD' );
                    }
            })
        })
        },


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            var rfc = 'GOFF951130TJ0';
            

            var data = {
                'perfil' : 'EI',
                'multiple' : this.multiple,
                'tramite' : this.usuario.tramite_id,
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
                    data: {"tramite_id" : this.usuario.tramite_id, "value": JSON.stringify(data), "access_token" : this.access_token},
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