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
            firma: '',
            access_token: '',
            resultId: '',
            listaSolicitantes:[],
            datosFormulario:{},
            obteniendoCosto:true,
            datosFormulario: '',
            multiple: '',
        }
    },
    mounted() {
        this.datosFormulario = localStorage.getItem('datosFormulario')
        // for (let i = 0; i < this.datosFormulario.campos; i++) {
        //     if(this.datosFormulario.campos[i].tipo == 'enajenante'){
        //         if( count(this.datosFormulario.campos[i].valor.enajenantes) < 0 ){
        //             this.multiple = true;
        //         }
        //     }   
        // }
         
        console.log( '122312' , typeof(this.datosFormulario));
        this.accesToken();
        this.encodeData();

    },
    methods: {


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            var urlDocumento = process.env.APP_URL +'/formato-declaracion/148';
            var urlDocumento2 = process.env.APP_URL +'/formato-declaracion/149';
            var doc = [ urlDocumento, urlDocumento2 ];
            var tramite_id = '5637';
            var llave = ['999666008' ,'999666009'];
            // var llave = '999666006';
            var folio =[ '213333116' , '213333117'];
            // var folio ='213333112';
            var rfc = 'GOFF951130TJ0';
            // var rfc = this.usuario.rfc;
            
            console.log('documentoa consultar: ', urlDocumento);

            var data = {
                'perfil' : 'EI',
                'multiple' : true,
                'tramite' : tramite_id,
                'llave' : llave,
                'doc' : doc,
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

           
            function serialize (mixedValue) {
                let val, key, okey
                let ktype = ''
                let vals = ''
                let count = 0

                const _utf8Size = function (str) {
                    return ~-encodeURI(str).split(/%..|./).length
                }

                const _getType = function (inp) {
                    let match
                    let key
                    let cons
                    let types
                    let type = typeof inp

                    if (type === 'object' && !inp) {
                    return 'null'
                    }

                    if (type === 'object') {
                    if (!inp.constructor) {
                        return 'object'
                    }
                    cons = inp.constructor.toString()
                    match = cons.match(/(\w+)\(/)
                    if (match) {
                        cons = match[1].toLowerCase()
                    }
                    types = ['boolean', 'number', 'string', 'array']
                    for (key in types) {
                        if (cons === types[key]) {
                        type = types[key]
                        break
                        }
                    }
                    }
                    return type
                }

                const type = _getType(mixedValue)

                switch (type) {
                    case 'function':
                    val = ''
                    break
                    case 'boolean':
                    val = 'b:' + (mixedValue ? '1' : '0')
                    break
                    case 'number':
                    val = (Math.round(mixedValue) === mixedValue ? 'i' : 'd') + ':' + mixedValue
                    break
                    case 'string':
                    val = 's:' + _utf8Size(mixedValue) + ':"' + mixedValue + '"'
                    break
                    case 'array':
                    case 'object':
                    val = 'a'

                    for (key in mixedValue) {
                        if (mixedValue.hasOwnProperty(key)) {
                        ktype = _getType(mixedValue[key])
                        if (ktype === 'function') {
                            continue
                        }

                        okey = (key.match(/^[0-9]+$/) ? parseInt(key, 10) : key)
                        vals += serialize(okey) + serialize(mixedValue[key])
                        count++
                        }
                    }
                    val += ':' + count + ':{' + vals + '}'
                    break
                    case 'undefined':
                    default:
                    val = 'N'
                    break
                }
                if (type !== 'object' && type !== 'array') {
                    val += ';'
                }

                return val
            }

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