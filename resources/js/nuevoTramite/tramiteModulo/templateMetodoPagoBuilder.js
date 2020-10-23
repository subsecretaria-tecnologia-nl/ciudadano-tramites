templateMetodoPagoBulder = {

    build: function( cuentas, folio ) {

    	$("#containerMetodoPago").empty();
    	let tieneVentanilla =  cuentas.find( cuenta => cuenta.metodopago_id == 3 );
		let tienePagoBancoEnLinea =  cuentas.find( cuenta => cuenta.metodopago_id == 4 );

		let totalTramites = $("<h5>").addClass("mb-4").append( "  <span> Proceso de Pago</span>" );
    	$("#containerMetodoPago").append(totalTramites);

    	if(  tieneVentanilla ){
    		this.getTemplateVentanillaBancaria( folio, tieneVentanilla );
    	}

    	if(  tienePagoBancoEnLinea ){
    		this.getTemplateBancoEnLinea( folio, tienePagoBancoEnLinea );
    	}		
		
    },


	getTemplateVentanillaBancaria: function( folio, tieneVentanilla ){
		let divContenedor = $("<div>").addClass("card border-secondary shadow p-3 mb-5 bg-white rounded metodopago");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>Pago Referenciado</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default btn-metodopago" id="metodopagoBtnRef"> Pago Referenciado </button>');


			
			divInicial.append( divContenedorSecundario );
			divContenedor.append( divInicial );
		
			$("#containerMetodoPago").append( divContenedor );
			$("#containerMetodoPago").append( '<br/>' );

			$("#metodopagoBtnRef").on("click", () => {
				$("#metodopagoBtnRef").append('<div id="spinner-ref" class="spinner-border spinner-border-sm float-right" role="status"><span class="sr-only">Loading...</span></div>');


				let url = "https://payments-api-stage.herokuapp.com/v1/databank";
				$.ajax({
				  	type: "POST",
				  	url,
				  	data: JSON.stringify({ folio, cuenta_id: tieneVentanilla.cuenta_id }),
				   	headers: {
				        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
				        "Content-type":"application/json"
				    }
				}).done((response) => {
					if(response.response.datos.recibo.pdf )	{
						divContenedorSecundario.append('<div id="pdfContenido"><iframe id="frame" src="http://egobierno.nl.gob.mx/egob/formatoRepositorio.php?Folio=258310" width="100%" height="600"></iframe></div>')
					} else {
						window.open(response.response.datos.recibo.url);
					}
				}).fail((rror)=> {
					console.log( rror)
				}).always(() => {
					$("#spinner-ref").remove();
				});


			});

	},

	getTemplateBancoEnLinea: function( folio, tienePagoBancoEnLinea ){
		let divContenedor = $("<div>").addClass("card border-secondary  shadow p-3 mb-5 bg-white rounded metodopago");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>Banco En Linea</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default btn-metodopago" id="metodopagoBtnBanco">Banco En Linea  </button>');

			divInicial.append( divContenedorSecundario );
			divContenedor.append( divInicial );
		$("#containerMetodoPago").append( divContenedor );
		$("#containerMetodoPago").append( '<br/>' );

/*
		$("#metodopagoBtnBanco").on("click", () => {

			$("#modalSimulacion").modal("show");



		});
			$(".accionSimuluacion").on("click", () =>{
				alert();
			})*/
			let datos = [];
			$("#metodopagoBtnBanco").on("click", () => {
				$("#metodopagoBtnBanco").append('<div id="spinner-banco" class="spinner-border spinner-border-sm float-right" role="status"><span class="sr-only">Loading...</span></div>');


				let url = "https://payments-api-stage.herokuapp.com/v1/databank";
				$.ajax({
				  	type: "POST",
				  	url,
				  	data: JSON.stringify({ folio, cuenta_id:  tienePagoBancoEnLinea.cuenta_id}),
				   	headers: {
				        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
				        "Content-type":"application/json"
				    }
				}).done((response) => {
					datos = response.response.datos;
				
							let url = "http://localhost:8080/responseBanco";
								$.ajax({
							  	type: "POST",
							  	url,
							  	data: JSON.stringify(datos),
							   	headers: {
							        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
							        "Content-type":"application/json"
							    }
							}).done((response) => {
								console.log("response banco");
								console.log( response)
							}).fail((rror)=> {
								console.log( rror)
							}).always(() => {
								
							});
					$("#modalSimulacion").modal("show");
				}).fail((rror)=> {
					console.log( rror)
				}).always(() => {
					$("#spinner-banco").remove();
				});


			});


			$(".accionSimuluacion").on("click", ( e ) =>{
let key  = datos.s_transm + datos.c_referencia + datos.t_importe + "234121";
	var hash = CryptoJS.HmacSHA256(key, "Nljuk3u99D8383899XE8399NLi98I653rv8273WQ80202mUbbI28AO762i3828");
				console.log( hash );
				console.log(hash.toString());
console.log(hash.toString(CryptoJS.enc.Base64));
				let data = {
                    "mp_amount" : datos.t_importe,
                    "mp_response" : $( "#" + e.target.id).data( "stado" ),// 000 recaza  111 acepta
                    "mp_signature" : hash.toString(),
                    "c_referencia" : datos.c_referencia,
                    "n_autoriz" : "234121",
                    "s_transm" : datos.s_transm,
                    "bco_": "bmer"
                }
/*
                let data2 = {
                	    "mp_amount" : 4687.00,
    "mp_response" : $( "#" + e.target.id).data( "stado" ),
    "mp_signature" : "f808fbf5103b0d058a4d3101017c01a7c48e0ef0d28628f3b5de403e92c45482",
    "c_referencia" : "1199742085258406102342768",
    "n_autoriz" : "234121",
    "s_transm" :258406,
    "bco_" : "bmer"
                }*/


				let url = "https://payments-api-stage.herokuapp.com/v1/respuestabanco";
				$.ajax({
				  	type: "POST",
				  	url,
				  	data: JSON.stringify(data),
				   	headers: {
				        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
				        "Content-type":"application/json"
				    }
				}).done((response) => {
					console.log( response.response );
					window.open(response.response.datos.url_recibo);
					
				}).fail((rror)=> {
					console.log( rror)
				}).always(() => {
					$("#modalSimulacion").modal("hide");
				});
			});

	}


};
	
							        	

/*
		switch( metodoId ) {
			case 1:
				return "Tarjeta de Crédito y Débito";
			case 2:
				return "SPEI Interbancario"
			case 3:
				return "Ventanilla Bancaria";
			default:
				return "";
		}
*/