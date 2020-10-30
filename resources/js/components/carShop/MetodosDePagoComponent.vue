<template>
    <div class="mb-3" id="divMetodoPago" >
        <div id="containerMetodoPago" > 
            <div class="card border-secondary shadow p-3 mb-5 bg-white rounded metodopago"" id="idVentanilla" v-if="tieneVentanilla">
                <div class="pt-4" >
                    <h6 class="mb-3"><strong>Pago Referenciado</strong></h6>

                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-metodopago" id="metodopagoBtnRef"  v-on:click="obtenerReciboPagoVentanilla()"> 
                            Pago Referenciado  
                            <div id="spinner-ref" class="spinner-border spinner-border-sm float-right" role="status" v-if="obteniendoRecibo">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-secondary shadow p-3 mb-5 bg-white rounded metodopago"" id="idNetPay" v-if="tienePagoNetPay">
                <div class="pt-4" >
                    <h6 class="mb-3"><strong>Pago NetPay</strong></h6>

                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-metodopago" id="metodopagoBtnNP"  v-on:click="pagoNetPay()"> 
                            NetPay 
                            <div id="spinner-ref" class="spinner-border spinner-border-sm float-right" role="status" v-if="obteniendoPagoEnLinea">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                        <form v-if="urlNetPay.length > 0" id="formulariosNetPay" :action="urlNetPay" method="post">
                            <input type="hidden" name="jwt" :value="JWT">
                            <button type="submit" style="display: none;">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>     

    </div>

</template>

<script>
    export default {
        props: ['infoMetodosPago'],
        mounted() {
            this.cuentas = this.infoMetodosPago.cuentas;
            this.folio = this.infoMetodosPago.folio;
            
            this.cuentas.forEach( cuenta => {
                console.log( cuenta.metodopago_id )
            } )

            this.tienePagoNetPay = this.cuentas.find( cuenta => cuenta.metodopago_id == 1 );
            this.tieneVentanilla =  this.cuentas.find( cuenta => cuenta.metodopago_id == 3 );
            this.tienePagoBancoEnLinea = this.cuentas.find( cuenta => cuenta.metodopago_id == 4 );
        },

        data(){
            return {
                tieneVentanilla: false,
                tienePagoNetPay:false,
                cuentas:[],
                folio:0,
                obteniendoRecibo:false,
                obteniendoPagoEnLinea:false,
                urlNetPay:"", JWT:""
            }
        },
  
        methods: {
            obtenerReciboPagoVentanilla: function () {
                this.obteniendoRecibo = true;
                let url = process.env.PAYMENTS_HOSTNAME +  "/v1/databank";  
                $.ajax({
                    type: "POST",
                    url,
                    data: JSON.stringify({ folio:this.folio, cuenta_id: this.tieneVentanilla.cuenta_id }),
                    headers: {
                        "Authorization":"Bearer " + process.env.PAYMENTS_KEY,
                        "Content-type":"application/json"
                    }
                }).done((response) => {
                    console.log(  response )
                    if(response.response.datos.recibo.pdf ) {
                        divContenedorSecundario.append('<div id="pdfContenido"><iframe id="frame" src="http://egobierno.nl.gob.mx/egob/formatoRepositorio.php?Folio=258310" width="100%" height="600"></iframe></div>')
                    } else {
                        window.open(response.response.datos.recibo.url);
                    }
                }).fail((rror)=> {
                    console.log( rror)
                }).always(() => {
                    $("#spinner-ref").remove();
                });

            },

            pagoNetPay(){
                this.obteniendoPagoEnLinea = true;
                let url = process.env.PAYMENTS_HOSTNAME +  "/v1/databank"; 
                console.log( this.tienePagoNetPay )
                let data = JSON.stringify({ folio:this.folio, cuenta_id: this.tienePagoNetPay.cuenta_id });

                axios.post(url, 
                    data,
                    {
                    headers:{
                        "Authorization":"Bearer " + process.env.PAYMENTS_KEY,
                        "Content-type":"application/json"
                    },
                } )
                .then(response => {
                    console.log( response.data.response.url_response );
                    this.urlNetPay = response.data.response.url_response;
                    this.JWT= response.data.response.datos.jwt;

                    
                    setTimeout(function(){ 
                        $("#formulariosNetPay").submit();
                    }, 3000);
                    /*
                    $.ajax({
                      type: "POST",
                      url: response.data.response.url_response,
                      data: response.data.response.datos,
                    }).then( ( response) => {
                        console.log( response )
                    });*/
                }).catch((error)=> {
                    console.log(error)
                }).finally(() => {
                    this.obteniendoPagoEnLinea = false;
                });
            }


        }
    }
</script>

