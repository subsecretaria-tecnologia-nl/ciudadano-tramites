<template>
  <div>
    <iframe id="the_frame" :src="firma" style="width:100%; height:500px;" frameborder="0"> </iframe>

 </div>
</template>

<script>


export default {
    props: ['datosComplementaria', 'tipoTramite','usuario'],
    data(){
        return{
            tramite : {},
            tramiteInfo: '',
            firma: '',
            access_token: '',
            resultId: '',
            listaSolicitantes:[],
            datosFormulario:{},
            obteniendoCosto:true,
            datosFormulario: '',
            multiple: '',
            doc: '',
        }
    },
    mounted() {
        console.log('usuario: '+ this.usuario);
		tramiteInfo = axios.get( process.env.TESORERIA_HOSTNAME+ "/solicitudes-get-tramite-pdf/" + 400 );
        console.log('--- ' +  process.env.TESORERIA_HOSTNAME+ "/solicitudes-get-tramite-pdf/" + this.usuario);
        console.log('tramiteinfo' +  JSON.stringify(tramiteInfo));
        var tramite = tramiteInfo.tramite.solicitudes[0].info.campos;
        self = this;
        if(  tramite.length > 0  ){
            self.multiple = true;
            self.doc = [];
            for (let i = 0; i <= tramite.length; i++) {
                self.doc.push( process.env.APP_URL +'/formato-declaracion/' + id + '/' + i );
            }
        }else{
            self.doc= 0; 
        }



        console.log( 'documento: ' , this.doc);
        this.accesToken();
        this.encodeData();

    },
    methods: {


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            var tramite_id = '399';
            // var llave = ['9996660081' ,'9996660091'];
            var llave = '999666006';
            // var folio =[ '2133331161' , '2133331171'];
            var folio ='213333112';
            var rfc = 'GOFF951130TJ0';
            // var rfc =tramiteInfo.tramite.solicitudes[0].info.solicitante.rfc;
            

            var data = {
                'perfil' : 'EI',
                'multiple' : this.multiple,
                'tramite' : tramite_id,
                'llave' : llave,
                'doc' : this.doc,
                'folio' : folio,
                'rfc' : rfc,
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
                    data: {"tramite_id" : tramite_id, "value": JSON.stringify(data), "access_token" : this.access_token},
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
                        console.log('id a consultar: ', self.resultId);
                        console.log('access: ', self.access_token);
                    }
                });
         
            // var encodedData = btoa(encodeURIComponent(serialize(data)));
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