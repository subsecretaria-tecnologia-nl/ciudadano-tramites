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
            var html = 'Jaime Alberto Castillo Camargo';
            var  url = "http://Insumos.test.nl.gob.mx/signature?data=";
            // $catastroInsumos = @@catastroinsumos;
            var urlDocumento = 'http://www.orimi.com/pdf-test.pdf';
            var tramite_id = 5630;
            var llave = '19A0000001';
            var folio = '0503LTZORWRM67001';
            var rfc = 'CACJ960722HNLSMM14';


            var data = {
                'perfil' : 'AE',
                'tramite' : tramite_id,
                'llave' : llave,
                'doc' : urlDocumento,
                'folio' : folio,
                'rfc' : rfc,
                'html' : btoa(html),
                'pagado' : 1
            };

            var encodedData = btoa(encodeURIComponent(serialize(data)));
            var urlFinal = url+encodedData;
            this.firma = urlFinal;
            console.log(',,x,',encodedData);

           
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
                    /*
                    if (type === 'object') {
                        var objname = mixedValue.constructor.toString().match(/(\w+)\(\)/);
                        if (objname === undefined) {
                        return;
                        }
                        objname[1] = serialize(objname[1]);
                        val = 'O' + objname[1].substring(1, objname[1].length - 1);
                    }
                    */

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
                    // Fall-through
                    // if the JS object has a property which contains a null value,
                    // the string cannot be unserialized by PHP
                    val = 'N'
                    break
                }
                if (type !== 'object' && type !== 'array') {
                    val += ';'
                }

                return val
                }

        }
    },
    mounted() {
        this.encodeData();
    }
}
</script>

<style>

</style>