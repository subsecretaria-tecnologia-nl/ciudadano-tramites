<template>
  <div>
    <iframe id="the_frame" :src="firma" style="width:100%; height:500px;" frameborder="0"> </iframe>

    <div class="tp-15">
        <code>
            {{datosComplementaria}} <br>
            {{tipoTramite}} <br>
            {{tramite}}
        </code>
    </div>
 </div>
</template>

<script>
export default {
    props: ['datosComplementaria', 'tipoTramite'],
    data(){
        return{
            tramite : {},
            firma: '',
            access_token: '',
            resultId: '',
        }
    },
    methods: {

        async obtenerDatos(){
                let url = "";
                let consulta_api =  this.datosFormulario.consulta_api;
                let tipo_costo_obj = this.datosFormulario.tipo_costo_obj ;

                 if( this.tipoTramite =='normal'  ){
                    url = process.env.APP_URL + (consulta_api ?  consulta_api :  "/getcostoTramite"); 
                } else if(this.tipoTramite =='complementaria'){
                    url = process.env.APP_URL + "/getComplementaria"; 
                }

                 let data = {  
                    id_seguimiento: this.tramite.id_seguimiento,
                    tramite_id: this.tramite.id_tramite,
                    tipoPersona:this.listaSolicitantes[0].tipoPersona
                }
                
                data = this.getParamsCalculoCosto(consulta_api, data, tipo_costo_obj);
                
                try {
                    let response = await axios.post(url, data);
                    let detalleTramite = response.data;

                    if( consulta_api == "/getcostoImpuesto" || this.tipoTramite =='complementaria'  ){
                        this.tramite.detalle =  detalleTramite;
                    } else {
                        this.tramite.detalle =  detalleTramite[0];
                
                    }

                    const parsed = JSON.stringify(this.tramite);
                    localStorage.setItem('tramite', parsed);  
                    this.$forceUpdate();
                    this.obteniendoCosto = false;
                } catch (error) {
                    console.log(error);
                    this.obteniendoCosto = false;
                }

        },


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            // var urlDocumento = 'http://www.africau.edu/images/default/sample.pdf'
            var urlDocumento = process.env.APP_URL +'/formato-declaracion/400';
            var tramite_id = '5637';
            var llave = '999666005';
            var folio = '213333111';
            var rfc = 'GOFF951130TJ0';
            console.log('documentoa consultar: ', urlDocumento);

            var data = {
                'perfil' : 'EI',
                'tramite' : tramite_id,
                'llave' : llave,
                'doc' : urlDocumento,
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
            let url = "https://insumos.nl.gob.mx/api/auth" ;  
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
        }
    },
    mounted() {
        //   this.obtenerInformacionDelTramite();
            if(this.tipoTramite == 'declaracionEn0'){
                this.obteniendoCosto= false;
                this.tramite.detalle = {costo_final:0};
                const parsed = JSON.stringify(this.tramite);
                localStorage.setItem('tramite', parsed);  
                this.$forceUpdate();
                this.obteniendoCosto = false;
            } else {
                this.obtenerDatos();    
            }

        this.accesToken();
        this.encodeData();

    }
}
</script>

<style>

</style>