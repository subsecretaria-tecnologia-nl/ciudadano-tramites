"use strict";
var SolicitantesCtrl =  function(){
	return {
		listaSolicitantes: [],

		agregarSolicitante: function( ){

			let idSolicitante = $("#idSolicitante").val();

			let solicitante = { tipoPersona: $('input[name=tipoPersona]:checked').val()  };
			solicitante.id = !!$("#idSolicitante").val() ? $("#idSolicitante").val() : this.generarUUID();

			if( solicitante.tipoPersona == "pf" ){ 
				solicitante.nombreSolicitante = $("#nombreSolicitante").val();
				solicitante.apPatSolicitante = $("#apPatSolicitante").val();
				solicitante.apMatSolicitante = $("#apMatSolicitante").val();
			} else if ( solicitante.tipoPersona == "pm" ){
				solicitante.rfc = $("#rfcSolicitante").val();
			}

			if( !idSolicitante ){
				this.setSolicitanteToList( solicitante );
			} else {
				this.editSolicitanteToList( solicitante, idSolicitante );
			}
			

			$("#modalAddSolicitante").modal("hide");

			this.construirTablaSolicitantes();
		},


		editarSolicitante: function( id ){
		  	let solicitante = this.obtenerSolicitante(id);

		  	$("#idSolicitante").val( solicitante.id );
		  	if( solicitante.tipoPersona == "pf"){
		  		$('#pfRadio').click();
		  		$("#nombreSolicitante").val( solicitante.nombreSolicitante );
		  		$("#apMatSolicitante").val( solicitante.apMatSolicitante);
		  		$("#apPatSolicitante").val( solicitante.apPatSolicitante );
		  		$("#rfcSolicitante").val("");
		  	}

		  	if( solicitante.tipoPersona == "pm"){
		  		$('#pmRadio').click();
		  		$("#nombreSolicitante").val( "" );
		  		$("#apMatSolicitante").val( "");
		  		$("#apPatSolicitante").val( "");
		  		$("#rfcSolicitante").val( solicitante.rfc );
		  	}

		  	

			$("#modalAddSolicitante").modal("show");

			$('#pfRadio').change( () => { 
				if( $('#pfRadio').is(":checked") ){
					$("#divPF").show();
					$("#divPM").hide()
				}
			});

			$('#pmRadio').change( () => { 
				if( $('#pmRadio').is(":checked") ){
					$("#divPM").show();
					$("#divPF").hide()
				}
			});
		},

		construirTablaSolicitantes: function(){
			$("#tbodySolicitantes").empty();

			let listaSolicitantes = this.listaSolicitantes;
			if( listaSolicitantes && listaSolicitantes.length > 0 ) {
				listaSolicitantes.forEach( (solicitante, index) => {
					let tr = $("<tr>");

					let tdN = $("<td>").append(index + 1);

					let txtTipoPersona = solicitante.tipoPersona == "pf" ? "Persona Física" : "Persona Moral";
					let tdTipo = $("<td>").append( txtTipoPersona );
					let txtNombreORazonSocial = solicitante.tipoPersona == "pf" ? solicitante.nombreSolicitante + " " + solicitante.apPatSolicitante + " " + solicitante.apMatSolicitante : solicitante.rfc;
					let tdNombreORazonSocial = $("<td>").append( txtNombreORazonSocial ); 
					let tdAccions = $("<td>").append( '<a type="button" onclick=editarSolicitante('  +  "'"+ solicitante.id + "'"   +   ')><i class="fas fa-edit"></i></a><a type="button" onclick=quitarSolicitante('  +  "'"+ solicitante.id + "'"   +   ')><i class="far fa-trash-alt"></i></a>');

					tr.append( tdN );
					tr.append( tdTipo );
					tr.append( tdNombreORazonSocial  );
					tr.append( tdAccions );

					$("#tbodySolicitantes").append( tr );

				});


			} else  {
				let tr = $("<tr>");
				let tdN = $("<td colspan='4' class='text-center'>").append("No se han agregado solicitantes");
				tr.append( tdN );
				$("#tbodySolicitantes").append( tr );
			}
		},

		openModalAddSolicitante: function(){
			$('#pfRadio').click();
			$("#nombreSolicitante, #apMatSolicitante, #apPatSolicitante, #rfcSolicitante, #idSolicitante").val("");

			$("#modalAddSolicitante").modal("show");

			$('#pfRadio').change( () => { 
				if( $('#pfRadio').is(":checked") ){
					$("#divPF").show();
					$("#divPM").hide()
				}
			});

			$('#pmRadio').change( () => { 
				if( $('#pmRadio').is(":checked") ){
					$("#divPM").show();
					$("#divPF").hide()
				}
			});

		},

		setSolicitanteToList( solicitante ){
			this.listaSolicitantes.push( solicitante );
			return this;
		},

		getSolicitanteToList(  ){
			return this.listaSolicitantes;
		},

		quitarSolicitante( id ){
			this.listaSolicitantes = this.listaSolicitantes.filter(  solicitante => solicitante.id != id );
			this.construirTablaSolicitantes();
		},

		obtenerSolicitante: function( id ){
			let solicitante =  this.listaSolicitantes.find(  solicitante => solicitante.id == id );
			return solicitante ? solicitante : false;
		},

		editSolicitanteToList: function( nuevoSolicitante, idSolicitante ){
			let indexSolicitanteEditar = this.listaSolicitantes.findIndex(  solicitante => solicitante.id == idSolicitante );
			this.listaSolicitantes[indexSolicitanteEditar] = nuevoSolicitante;
		},

		generarUUID: function(){
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			    return v.toString(16);
			  });
		},

		reset: function(){
			this.listaSolicitantes = [];
			this.construirTablaSolicitantes();
		}
	}
}