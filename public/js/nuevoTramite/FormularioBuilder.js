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
/*
		let botonCancel = $("<button>").addClass("btn btn-danger").attr({
			type:"button"
		}).append("Cancelar");
		let botonAdd = $("<button>").addClass("btn btn-success").attr({
			type:"button", id:"buttonSave"
		}).append("Guardar");


		botonAdd.on("click", () => {
			fnValid( arrElementos, id_tramite );
		});*/
		//arrToDOm.push(botonAdd);
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
				if( campo.tipo != "select" ){

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
    }
};