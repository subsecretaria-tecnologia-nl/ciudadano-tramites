"use strict";
var TramiteCtrl =  function(){
	return {
		listaTramites: [],

		agregarTramite: function( id_tramite, camposTramite ){
			let nuevoTramiteModal = Object.assign({},  TramiteClass.prototype);
			nuevoTramiteModal.setIdTramite( generarUUIDTramite() );
			nuevoTramiteModal
				.setIdSeguimiento(4254)
				.setIdTipoServicio(3)
				.setDatosSolicitante(  this.getDatosTramite() )
				.setDatosFactura(datosTramite)
				.setAuxiliar_1("GRUPOS ICV BMU8605134I8 ")
				.setDetalle( this.getDetalleTramite() );

			let nuevoTramite = { id_tramite };
			for (var campo in camposTramite) { 
				nuevoTramite[campo] = camposTramite[campo].valor;
			}

			let tramiteFull = tramites.find( tramite => tramite.id_tramite == nuevoTramite.id_tramite ) ;

			nuevoTramiteModal.setTramite( tramiteFull );

			let data = getDataForCosto( nuevoTramiteModal.getIdTramite() );

			obtenerCostoTramite( data );
		},


		getListaTramites(  ){
			return this.listaTramites;
		},

		quitarTramite( id ){
			this.listaTramites = this.listaTramites.filter(  tramite => tramite.id != id );
		},

		obtenerTramite: function( id ){
			let tramite =  this.listaTramites.find(  tramite => tramite.id == id );
			return tramite ? tramite : false;
		},

		generarUUID: function(){
			return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
			    var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
			    return v.toString(16);
			  });
		},

		reset: function(){
			this.listaTramites = [];
		},


		getDataForCosto: function( id_seguimiento ){
			return {
				valor_catastral: $("#valor_catastral").val(),
   				id_seguimiento: id_seguimiento,
    			tramite_id: id_tramite,
    			valor_operacion: $("#valor_de_operacion").val()
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
			let url = "{{ url()->route('costo-tramite') }}";

			$.ajax({
			  	type: "POST",
			  	url,
			  	data: JSON.stringify(data),
			  	dataType:"json",
			   	headers: {
			        "Authorization":"Bearer B6C8XvbNouJj!ds@.NXjfeswtzehVN",
			        "Content-type":"application/json"
			    }
			}).done((response) => {
				nuevoTramiteModal.setImporteTramite(response)
				nuevoTramiteSave  = Object.assign({},  nuevoTramiteModal);
				tramitesGuardar.push( nuevoTramiteSave );
				
				Command: toastr.success("Se agrego el trámite a su lista", "Notifications") ;
				$("#camposDinamicosDiv").fadeOut(60).empty();
				$("#tramitesSelect").val("limpia").trigger('change');

				if( closeModal ){
					$("#addTramite").modal("hide"); 
				}
				buildTablaDetalles();
			}).fail((rror)=> {
				console.log("rror")
				console.log( rror)
			}).always(() => {
				btn.attr("disabled", false);  
				iconBtn.removeClass("fa-spin fa-spinner").addClass("fa-check");
			});
		}



	}
}