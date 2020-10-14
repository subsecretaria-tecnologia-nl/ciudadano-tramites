JSONGeneraReferenciaBuilder = {

	setToken: function( token ){
		this.token = token;
		return this;
	},

  	setReferencia: function( referencia){
    	this.referencia =  referencia;
    	return this;
  	},

	setUrlRetorno: function( url_retorno ){
		this.url_retorno = url_retorno;
		return this;
	},

	setImporteTransaccion: function ( importe_transaccion) {
		this.importe_transaccion = importe_transaccion;
		return this;
	},

	setIdTransaccion: function( id_transaccion ){
		this.id_transaccion = id_transaccion;
		return this;
	},

	setEntidad: function( entidad ){
		this.entidad = entidad;
		return this;
	},

	setUrlConfirmaPago: function( url_confirma_pago ){
		this.url_confirma_pago = url_confirma_pago;
		return this;
	},

	setEsReferencia: function( esReferencia){
		this.esReferencia = esReferencia;
		return this;
	},

	setTramites: function( tramites ){
		this.tramite = tramites;
		return this;
	},

  	build: function(  ) {
  		return this.getJson();
  	},

  	getJson: function() {
    	return {
			token:this.token,
			url_retorno:this.url_retorno,
			referencia: this.referencia,
			importe_transaccion:this.importe_transaccion,
			id_transaccion:this.id_transaccion,
			entidad:this.entidad,
			url_confirma_pago:this.url_confirma_pago,
			es_referencia: this.esReferencia,
			tramite:this.tramite
    	}
  	}
};
