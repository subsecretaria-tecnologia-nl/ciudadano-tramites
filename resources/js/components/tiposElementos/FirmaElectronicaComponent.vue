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
        }
    },
    // created() {
    //      window.addEventListener('beforeunload', function(event) {
    //      event.returnValue = 'Write something';
    //      console.log('tramite firmado');
    //   })
    // },
    // beforeDestroy(){
    //     window.removeEventListener('beforeunload');
    // },
    async mounted() {
        console.log('usuario: '+ typeof(this.usuario))
        console.log('usuario: '+ this.usuario.solicitudes.length)
        console.log('usuario: '+ this.usuario[1])
    
        if (this.usuario.solicitudes.length === 1 ) {
            this.doc ='';
            this.multiple = false;
            this.doc= process.env.APP_URL +'/formato-declaracion/' + this.usuario.solicitudes[0].id; 
            this.folio =  this.usuario.solicitudes[i].id ;
            this.llave = "0";
        }else{
               this.multiple = true;
                this.doc = [];
                this.folio = [];
                this.llave = [];
             for (let i = 0; i < this.usuario.solicitudes.length; i++) {
                // si es multiple entra por aqui jeje si no ->\
                this.doc.push( process.env.APP_URL +'/formato-declaracion/' + this.usuario.solicitudes[i].id );
                this.folio.push( this.usuario.solicitudes[i].id );
                this.llave.push( i );
            }
        }
        this.rfc = this.user.rfc;


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