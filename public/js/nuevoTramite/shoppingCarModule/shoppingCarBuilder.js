ShoppingCarBuilder = {

    build: function( tramitesGuardar ) {
    	$("#listTramites").empty();
		let totalTramites = $("<h5>").addClass("mb-4").append( "  <span>" + tramitesGuardar.length  + "</span> tramités " )
    	$("#listTramites").append(totalTramites).addClass("shadow-sm p-3 bg-white rounded");

		tramitesGuardar.forEach( ( tramite, index ) => {
			let divInicial = $("<div>").addClass("row mb-4");

			let divSecundario = $("<div>").addClass("col-md-7 col-lg-9 col-xl-9");

			let divTres = $("<div>");

			let divContenedorPrincipal = $("<div>").addClass("d-flex justify-content-between");
			let divContenedorDatos = $("<div>").append("<h5>" +  tramite.id_tramite + "</h5>");
				divContenedorDatos.append('<p class="mb-3 text-muted text-uppercase small">Shirt - blue</p>');
				divContenedorDatos.append('<p class="mb-2 text-muted text-uppercase small">Color - blue</p>');
				divContenedorDatos.append('<p class="mb-3 text-muted text-uppercase small">Size - M</p>');

				divContenedorPrincipal.append( divContenedorDatos );
				divTres.append( divContenedorPrincipal );
				

			let divContenedorSecundario= $("<div>").addClass("d-flex justify-content-between align-items-center");
			let btnDl = "<a type='button' class='card-link-secondary small text-uppercase mr-3' onclick='deleteTramite(" +  JSON.stringify( tramite ) +")' ><i class='fas fa-trash-alt mr-1'></i>Eliminar</a>";

			// <a href="#!" type="button" class="card-link-secondary small text-uppercase mr-3"><i class="fas fa-trash-alt mr-1"></i> Eliminar </a>
			let divContenedorAccion = $("<div>").append( btnDl );
				divContenedorSecundario.append( divContenedorAccion );
				divContenedorSecundario.append('<p class="mb-0"><span><strong id="summary">$17.99</strong></span></p class="mb-0">');

				divTres.append( divContenedorSecundario );

				
				divSecundario.append( divTres );
				divInicial.append( divSecundario );
				$("#listTramites").append( divInicial );
				$("#listTramites").append( '<hr class="mb-4">' );


		});

		//return arrToDOm;
		
    }
};