templateMetodoPagoBulder = {

    build: function( cuentas, folio ) {

    	$("#containerMetodoPago").empty();
    	let tieneVentanilla =  cuentas.find( cuenta => cuenta.metodopago_id == 3 );
		let tieneSPEI =  cuentas.find( cuenta => cuenta.metodopago_id == 2 );

		let totalTramites = $("<h5>").addClass("mb-4").append( "  <span> Proceso de Pago</span>" );
    	$("#containerMetodoPago").append(totalTramites);
    	console.log( folio )
    	if(  tieneVentanilla ){
    		this.getTemplateVentanillaBancaria( folio, tieneVentanilla );
    	}

    	if(  tieneSPEI ){
    		this.getTemplateSPEI( folio, tieneSPEI );
    	}		
		
    },


	getTemplateVentanillaBancaria: function( folio, tieneVentanilla ){
		let divContenedor = $("<div>").addClass("card border-secondary shadow p-3 mb-5 bg-white rounded metodopago");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>Ventanilla Bancaria</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default btn-metodopago" id="metodopagoBtnRef">Referencia </button>');


			
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

	getTemplateSPEI: function( folio, tieneSPEI ){
		let divContenedor = $("<div>").addClass("card border-secondary  shadow p-3 mb-5 bg-white rounded metodopago");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>SPEI Interbancario</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default btn-metodopago" id="metodopagoBtnSPEI">SPEI  </button>');

			divInicial.append( divContenedorSecundario );
			divContenedor.append( divInicial );
		$("#containerMetodoPago").append( divContenedor );
		$("#containerMetodoPago").append( '<br/>' );


				$("#metodopagoBtnSPEI").on("click", () => {
				$("#metodopagoBtnSPEI").append('<div id="spinner-spei" class="spinner-border spinner-border-sm float-right" role="status"><span class="sr-only">Loading...</span></div>');


				let url = "https://payments-api-stage.herokuapp.com/v1/databank";
				$.ajax({
				  	type: "POST",
				  	url,
				  	data: JSON.stringify({ folio, cuenta_id: tieneSPEI.cuenta_id }),
				   	headers: {
				        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
				        "Content-type":"application/json"
				    }
				}).done((response) => {
					if(response.response.datos.recibo.pdf )	{
						//divContenedorSecundario.append('<div id="pdfContenido"><iframe id="frame" src="http://egobierno.nl.gob.mx/egob/formatoRepositorio.php?Folio=258310" width="100%" height="600"></iframe></div>')
					} else {
						window.open(response.response.datos.recibo.url);
					}
				}).fail((rror)=> {
					console.log( rror)
				}).always(() => {
					$("#spinner-spei").remove();
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