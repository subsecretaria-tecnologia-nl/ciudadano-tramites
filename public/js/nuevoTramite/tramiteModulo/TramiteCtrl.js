"use strict";
var TramiteCtrl =  function(){
	return {

		agregarTramite: function( id_tramite, camposTramite, closeModal, btn, iconBtn, fnSucces ){

			let listaTramites = this.getListaTramites();
			let nuevoTramiteModal = Object.assign({},  TramiteClass.prototype);
			nuevoTramiteModal.setIdTramite( this.generarUUIDTramite() );
			nuevoTramiteModal
				.setIdSeguimiento(4254)
				.setIdTipoServicio(3)
				.setDatosSolicitante(  this.getDatosTramite() )
				.setDatosFactura( this.getDatosTramite() )
				.setAuxiliar_1("GRUPOS ICV BMU8605134I8 ")
				.setDetalle( this.getDetalleTramite() );

			let nuevoTramite = { id_tramite };
			for (var campo in camposTramite) { 
				console.log( Object.getPrototypeOf(camposTramite[campo]) )

				nuevoTramite[camposTramite[campo].id] = Object.getPrototypeOf(camposTramite[campo]).getValue() ;
			}

			//console.log( nuevoTramite )

			let tramiteFull = tramites.find( tramite => tramite.id_tramite == nuevoTramite.id_tramite ) ;
			nuevoTramiteModal.setTramite( tramiteFull );
			let data = this.getDataForCosto( nuevoTramiteModal.getIdTramite(), id_tramite );

			this.obtenerCostoTramite( data ).done( (  response )=> { 

				nuevoTramiteModal.setImporteTramite(response[0].costo_final);
				tramiteFull.descuentos = response[0].descuentos;
			    let	nuevoTramiteSave  = Object.assign({},  nuevoTramiteModal);
				listaTramites.push( nuevoTramiteSave );
				this.guardarTramites( listaTramites );
				Command: toastr.success("Se agrego el trámite a su lista", "Notifications") ;
				$("#camposDinamicosDiv").fadeOut(60).empty();
				$("#tramitesSelect").val("limpia").trigger('change');

				if( closeModal ){
					$("#addTramite").modal("hide"); 
				}
				fnSucces();
			}).fail((error)=> {
				console.log("rror")
				console.log(error);
			}).always(() => {
				btn.attr("disabled", false);  
				iconBtn.removeClass("fa-spin fa-spinner").addClass("fa-check");
			});
		},

		guardarTramites( listaTramites ){
			sessionStorage.setItem("listaTramites", JSON.stringify(listaTramites));
		},

		getListaTramites(  ){
		   	let	listaTramites = JSON.parse(sessionStorage.getItem("listaTramites")) || [];
			return listaTramites;
		},

		quitarTramite( id ){
			let listaTramites = this.getListaTramites();
			listaTramites = listaTramites.filter(  tramite => tramite.id_tramite != id );
			this.guardarTramites( listaTramites );
		},

		obtenerTramite: function( id ){
			let tramite =  this.listaTramites.find(  tramite => tramite.id == id );
			return tramite ? tramite : false;
		},

		generarUUIDTramite: function(){
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			    return v.toString(16);
			  });
		},

		reset: function(){
			this.listaTramites = [];
		},


		getDataForCosto: function( id_seguimiento, id_tramite ){
			return {
				valor_catastral: $("#valor_catastral").val(),
   				id_seguimiento: id_seguimiento,
    			tramite_id: id_tramite,
    			valor_operacion: $("#valor_de_operacion").val(),
    			oficio:62
			};
		},

		getDatosTramite: function(){
			return {
			    "nombre": "BEBIDAS MUNDIALES S DE RL DE CV",
			    "apellido_paterno": "",
			    "apellido_materno": "",
			    "razon_social": "BEBIDAS MUNDIALES S DE RL DE CV",
			    "rfc": "BMU8605134I8 ",
			    "curp": "",
			    "email": "",
			    "calle": "AV LA JUVENTUD",
			    "colonia": "BOSQUES DEL NOGALAR",
			    "numexterior": "",
			    "numinterior": "120",
			    "municipio": "SAN NICOLAS DE LOS GARZA",
			    "codigopostal": 66480
			}
		},

		getDetalleTramite: function(){
			return [
                {
                  "concepto": "REFRENDO PTE.AÑO",
                  "importe_concepto": "0",
                  "partida": 95101
                  
                }, {
                  	"concepto": "SANCION REFRENDO PTE.AÑO",
                  	"importe_concepto": "0",
                  	"partida": 95123,
                  	"descuentos": [
                    	{
                      		"concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
                      		"importe_descuento": "0",
                    	  	"partida_descuento": 95136
                    	}
                  	]
                }
            ]
		},  

		obtenerCostoTramite: function( data ){
			var $q = new $.Deferred();
			$.ajax({
			  	type: "POST",
			  	url:urlCostos,
			  	data: JSON.stringify(data),
			  	dataType:"json",
			   	headers: {
			        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
			        "Content-type":"application/json"
			    }
			}).done((response) => {
				$q.resolve( response );
			}).fail((error)=> {
				console.log("rror")
				$q.reject(error);
			});

			return $q.promise();
		}



	}
}