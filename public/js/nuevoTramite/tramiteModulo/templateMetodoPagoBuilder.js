templateMetodoPagoBulder = {

    build: function( cuentas ) {

    	$("#containerMetodoPago").empty();
    	let tieneVentanilla =  cuentas.find( cuenta => cuenta.metodopago_id == 3 );
		let tieneSPEI =  cuentas.find( cuenta => cuenta.metodopago_id == 2 );

		let totalTramites = $("<h5>").addClass("mb-4").append( "  <span> Proceso de Pago</span>" );
    	$("#containerMetodoPago").append(totalTramites);
    	
    	if(  tieneVentanilla ){
    		this.getTemplateVentanillaBancaria();
    	}

    	if(  tieneSPEI ){
    		this.getTemplateSPEI();
    	}		

    	


		
    },


	getTemplateVentanillaBancaria: function(){
		let divContenedor = $("<div>").addClass("shadow-sm p-3 bg-white rounded");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>Ventanilla Bancaria</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default" >Referencia </button>');

			divInicial.append( divContenedorSecundario );
			divContenedor.append( divInicial );
		$("#containerMetodoPago").append( divContenedor );
		$("#containerMetodoPago").append( '<br/>' );

	},

	getTemplateSPEI: function(){
		let divContenedor = $("<div>").addClass("shadow-sm p-3 bg-white rounded");
		let divInicial = $("<div>").addClass("pt-4");
			divInicial.append('<h6 class="mb-3"><strong>SPEI Interbancario</strong></h6>');

		let divContenedorSecundario= $("<div>").addClass("text-center");
			divContenedorSecundario.append('<button type="button" class="btn btn-default" >SPEI  </button>');

			divInicial.append( divContenedorSecundario );
			divContenedor.append( divInicial );
		$("#containerMetodoPago").append( divContenedor );
		$("#containerMetodoPago").append( '<br/>' );
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