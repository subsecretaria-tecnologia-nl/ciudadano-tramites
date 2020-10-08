FormularioBuilder = {
	arrElementos: [],

    build: function( campos ) {
		let arrCampos = JSON.parse( campos );

		this.arrElementos = [];
		arrCampos.forEach( ( campo, index ) => {
			this.arrElementos.push(	ElementFactory.create( campo ) );
		});

		let arrToDOm= [];
		this.arrElementos.forEach( element => {
			let divFormGroup = $("<div>").addClass("form-group");
			let divElem = $("<div>").addClass("").append( element.build() );
			divFormGroup.append($('<label>').addClass("control-label") ).append(element.descripcion.toUpperCase());
			divFormGroup.append(divElem);
			let divCol =  $("<div>").addClass("col-lg-4").append(divFormGroup);
			arrToDOm.push( divCol )
		});
		return arrToDOm;
		
    },

    getElements: function(){
    	return this.arrElementos;
    },

    isValid: function( campos){
    	let tramite = {};
    	let valido = true;
		campos.forEach( ( campo, index ) => {
			let idElement = campo.id;
			let valor = $("#" + idElement).val();
			if( campo.tipo != "checkbox" ){
				if( campo.tipo != "select" && campo.tipo != "option"){

					if( campo.caracteristicas.required && (!valor || valor.length < 1 ) ){
						tramite[idElement] = { isValid: false };
					} else {
						tramite[idElement] = { isValid: true, valor };
					}
				}
			} else {
				tramite[idElement] = {valor:$("#" + idElement).prop("checked"), isValid: true};
			}
		});
		return valido ? tramite : valido;
    },


    buildSeccionSolicitantes: function( campos ){
    	let tieneSeccionSolicitante = campos.find( campo => campo.tipo == "option" && campo.nombre == "Razón Social" );

    }



};