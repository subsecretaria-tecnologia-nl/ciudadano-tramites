
var TramiteClass = function() {
		this.id_seguimiento = "";
		this.id_tipo_servicio = "";
		this.id_tramite = "";
		this.importe_tramite = "";
		this.auxiliar_1 = "";
		this.auxiliar_2 = "";
		this.auxiliar_3 = "";
		this.datos_solicitante = "";
		this.datos_factura = "";
		this.detalle = [];

		this.listaSolicitantes = [];
};
TramiteClass.prototype = {
	setIdSeguimiento: function( id_seguimiento){
    	this.id_seguimiento =  id_seguimiento;
    	return this;
  	},

	setIdTipoServicio: function( id_tipo_servicio ){
		this.id_tipo_servicio = id_tipo_servicio;
		return this;
	},

	setIdTramite: function ( id_tramite) {
		this.id_tramite = id_tramite;
		return this;
	},

	setImporteTramite: function( importe_tramite ){
		this.importe_tramite = importe_tramite;
		return this;
	},


	setAuxiliar_1: function( auxiliar_1 ){
		this.auxiliar_1 = auxiliar_1;
		return this;
	},

	setAuxiliar_2: function( auxiliar_2 ){
		this.auxiliar_2 = auxiliar_2;
		return this;
	},

	setAuxiliar_3: function( auxiliar_3 ){
		this.auxiliar_3 = auxiliar_3;
		return this;
	},

	setDatosSolicitante: function( datos_solicitante ){
		this.datos_solicitante = datos_solicitante;
		return this;
	},

	setDatosFactura: function( datos_factura){
		this.datos_factura = datos_factura;
		return this;
	},

	setDetalle: function( detalle ){
		this.detalle = detalle;
		return this;
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
	},

	obtenerSolicitante: function( id ){
		let solicitante =  this.listaSolicitantes.find(  solicitante => solicitante.id == id );
		return solicitante ? solicitante : false;
	},

	editSolicitanteToList: function( nuevoSolicitante, idSolicitante ){
		let indexSolicitanteEditar = this.listaSolicitantes.findIndex(  solicitante => solicitante.id == idSolicitante );
		this.listaSolicitantes[indexSolicitanteEditar] = nuevoSolicitante;
	},

	setTramite: function( tramite ){
		this.tramite = tramite;
	},

	build: function(  ) {
		return this.getJson();
	},

	getJson: function() {
		return {
			id_seguimiento:this.id_seguimiento,
			id_tipo_servicio:this.id_tipo_servicio,
			id_tramite: this.id_tramite,
			importe_tramite:this.importe_tramite,

			auxiliar_1:this.auxiliar_1,
			auxiliar_2:this.auxiliar_2,
			auxiliar_3:this.auxiliar_3,

			datos_solicitante: this.datos_solicitante,
			datos_factura:this.datos_factura,
			detalle:this.detalle
		}
	},

	clean: function(){
		this.id_seguimiento = "";
		this.id_tipo_servicio = "";
		this.id_tramite = "";
		this.importe_tramite = "";
		this.auxiliar_1 = "";
		this.auxiliar_2 = "";
		this.auxiliar_3 = "";
		this.datos_solicitante = "";
		this.datos_factura = "";
		this.detalle = "";
	}
};
