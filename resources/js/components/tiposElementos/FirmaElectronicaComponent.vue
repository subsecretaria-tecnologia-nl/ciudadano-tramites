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

const CAMPO_LOTE            = "Lote";
    const CAMPO_HOJA            = "Hoja";
    const CAMPO_SUBSIDIO        = "Subsidio";
    const CAMPO_VALOR_CATASTRAL = "Valor catastral";
    const CAMPO_VALOR_OPERACION = "Valor de operacion";

    //CAMPOS CALCULO IMPUESTO
    const CAMPO_GANANCIA_OBTENIDA                               = "GANANCIA OBTENIDA";
    const CAMPO_MONTO_DE_OPERACIÓN                              = "MONTO DE OPERACIÓN (reportado en el aviso de enajenación)";
    const CAMPO_MULTA_POR_CORRECCION_FISCAL                     = "MULTA POR CORRECCION FISCAL";
    const CAMPO_FECHA_DE_ESCRITURA_O_MINUTA                     = "FECHA DE ESCRITURA O MINUTA";
    const CAMPO_PAGO_PROVISIONAL_CONFORME_AL_ARTICULO_126_LISR  = "PAGO PROVISIONAL CONFORME AL ARTICULO 126 LISR";


    const CAMPO_DIVISAS = "Cambio de divisas";

    import Vue from 'vue'

export default {
    props: ['datosComplementaria', 'tipoTramite'],
    data(){
        return{
            tramite : {},
            firma: '',
            access_token: '',
            resultId: '',
            listaSolicitantes:[],
            datosFormulario:{},
            obteniendoCosto:true
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

        obtenerInformacionDelTramite(){
            let informacionEnStorage = ["listaSolicitantes", "tramite", "datosFormulario"];
            informacionEnStorage.forEach( name => {
                if (localStorage.getItem(name)) {
                    try {
                    this[name] = JSON.parse(localStorage.getItem(name));
                    } catch(e) {
                    letocalStorage.removeItem(name);
                    }
                }
            });
        },

        toggleTabla(){
            $( "#collapseOne" ).toggle('slow');
        },

        getCampoByName( nameCampo ){
            return this.datosFormulario.campos.find( campo => campo.nombre.toLowerCase()  === nameCampo.toLowerCase() );
        }, 

        getParamsCalculoCosto( consulta_api , params, tipo_costo_obj){
            let paramsCosto = {};
            if(this.tipoTramite =='normal'  ){
                if( consulta_api == "/getcostoImpuesto" ){
                    // CAMPOS CALCULO IMPUESTO
                    let campoMonto              = this.getCampoByName(CAMPO_MONTO_DE_OPERACIÓN);
                    let campoMulta              = this.getCampoByName(CAMPO_MULTA_POR_CORRECCION_FISCAL);
                    let campoFechaMinuta        = this.getCampoByName(CAMPO_FECHA_DE_ESCRITURA_O_MINUTA);
                    let campoPagoProvisional    = this.getCampoByName(CAMPO_PAGO_PROVISIONAL_CONFORME_AL_ARTICULO_126_LISR);
                    let campoGananciaObtenida   = this.getCampoByName(CAMPO_GANANCIA_OBTENIDA);

                    paramsCosto.fecha_escritura = campoFechaMinuta.valor.split("-").map(dato => Number(dato)).join("-");
                    paramsCosto.monto_operacion = this.formatoNumero(campoMonto.valor);
                    paramsCosto.ganancia_obtenida = this.formatoNumero(campoGananciaObtenida.valor);    
                    paramsCosto.pago_provisional_lisr = this.formatoNumero(campoPagoProvisional.valor);
                    if( campoMulta ){
                        paramsCosto.multa_correccion_fiscal = this.formatoNumero(campoMulta.valor);
                    }
                } else {

                    if ( tipo_costo_obj.tipo_costo == '1' && (tipo_costo_obj.tipoCostoRadio == 'hoja'||tipo_costo_obj.tipoCostoRadio == 'lote') ){
                        paramsCosto.tipo_costo = tipo_costo_obj.tipo_costo;
                        paramsCosto.tipoCostoRadio = tipo_costo_obj.tipoCostoRadio;
                        paramsCosto.hojaInput = tipo_costo_obj.hojaInput;
                    }  else {
                        let campoLote           = this.getCampoByName(CAMPO_LOTE);
                        let campoHoja           = this.getCampoByName(CAMPO_HOJA);
                        let campoSubsidio       = this.getCampoByName(CAMPO_SUBSIDIO);
                        let campoCatastral      = this.getCampoByName(CAMPO_VALOR_CATASTRAL);
                        let campoValorOperacion = this.getCampoByName(CAMPO_VALOR_OPERACION);  

                        if( campoCatastral ){
                            paramsCosto.valor_catastral = this.formatoNumero(campoCatastral.valor);
                        }

                        if(campoSubsidio){                            
                            if( campoSubsidio.tipo == 'select'  ){
                                //paramsCosto.subsidio = campoSubsidio.valor[0][0];//62 
                                paramsCosto.subsidio = campoSubsidio.valor.clave;
                            } else {
                                paramsCosto.subsidio = campoSubsidio.valor;//62    
                            }
                            
                        }

                        if(campoValorOperacion ){
                            paramsCosto.valor_operacion = this.formatoNumero(campoValorOperacion.valor);
                        }

                        if( campoHoja ){
                            paramsCosto.hoja = campoHoja.valor; 
                        }

                        if( campoLote ){
                            paramsCosto.lote = campoLote.valor
                        }
                    }                 
                }
                let campoDivisas              = this.getCampoByName(CAMPO_DIVISAS);
                if( campoDivisas ){
                    paramsCosto.divisa = campoDivisas.valor.clave;
                    //paramsCosto.divisa = campoDivisas.valor[0][0];
                }
            } else {
                return this.datosComplementaria;
            }

            return Object.assign(params, paramsCosto);
        },

        
        formatoNumero(numberStr){
            let valor =  Number((numberStr+"").replace(/[^0-9.-]+/g,""));
            return valor;
        },


        encodeData(){
            var urlDataGeneric = 'http://Insumos.test.nl.gob.mx/api/data_generic';
            var url = "http://Insumos.test.nl.gob.mx/api/v2/signature/iframe?id=";
            var urlDocumento = process.env.APP_URL +'/formato-declaracion/400';
            var urlDocumento2 = process.env.APP_URL +'/formato-declaracion/149';
            var doc = [ urlDocumento, urlDocumento2 ];
            var tramite_id = '5637';
            var llave = ['999666007' ,'999666006'];
            // var llave = '999666006';
            var folio =[ '213333113' , '213333112'];
            // var folio ='213333112';
            var rfc = 'GOFF951130TJ0';
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

        
        async obtenerCosto(){    
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

    },
 
}




          

        
          
           


          


      
 


</script>