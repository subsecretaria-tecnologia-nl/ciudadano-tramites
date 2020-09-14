FormularioBuilder = {
    build: function( campos ) {
		let arrCampos = JSON.parse( campos );
		let arrElementos = [];
		arrCampos.forEach( ( campo, index ) => {
			arrElementos.push(	ElementFactory.create( campo ) );
		});

		let arrToDOm= [];
		arrElementos.forEach( element => {
			let divFormGroup = $("<div>").addClass("form-group");
			let divElem = $("<div>").addClass("").append( element.build() );
			divFormGroup.append($('<label>').addClass("control-label") ).append(element.name.toUpperCase());
			divFormGroup.append(divElem);
			let divCol =  $("<div>").addClass("col-lg-4").append(divFormGroup);
			arrToDOm.push( divCol )
		});
		console.log( arrElementos );
		console.log( arrToDOm );
		return arrToDOm;
		
    },
};