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

	getImporteTransaccion: function ( ) {
		return this.importe_transaccion;
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
    	/*return {
			token:this.token,
			url_retorno:this.url_retorno,
			referencia: this.referencia,
			importe_transaccion:this.importe_transaccion,
			id_transaccion:this.id_transaccion,
			entidad:this.entidad,
			url_confirma_pago:this.url_confirma_pago,
			es_referencia: this.esReferencia,
			tramite:this.tramite
    	}*/

    	return {
  "token": "DD0FDED2FE302392164520BF7090E1B3BEB7",
  "referencia": "",
  "url_retorno": "url",
  "importe_transaccion": "4687",
  "id_transaccion": "BMU8605134I82915082020",
  "entidad": 3,
  "url_confirma_pago": "url",
  "es_referencia": "1",
  "tramite": [
    {
      "id_seguimiento": 4254,
      "id_tipo_servicio": 3,
      "id_tramite": "BMU8605134I81FM5K7D80EGA56944",
      "importe_tramite": "3041",
      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
      "auxiliar_2": "",
      "auxiliar_3": "",
      "datos_solicitante": {
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
      },
      "datos_factura": {
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
      },
      "detalle": [
        {
          "concepto": "REFRENDO PTE.AÑO",
          "importe_concepto": "3041",
          "partida": 95101
          
        },
        {
          "concepto": "SANCION REFRENDO PTE.AÑO",
          "importe_concepto": "130",
          "partida": 95123,
          "descuentos": [
            {
              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
              "importe_descuento": "130",
              "partida_descuento": 95136
            }
          ]
        }
      ]
    },
    {
      "id_seguimiento":334,
      "id_tipo_servicio": 3,
      "id_tramite": "BMU8605134I81GBKC34J9WJ108483",
      "importe_tramite": "820",
      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
      "auxiliar_2": "",
      "auxiliar_3": "",
      "datos_solicitante": {
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
      },
      "datos_factura": {
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
      },
      "detalle": [
        {
          "concepto": "REFRENDO PTE.AÑO",
          "importe_concepto": "3035",
          "partida": 95101,
          "descuentos": [
            {
              "concepto_descuento": "SUBSIDIO ANTIGUEDAD 15 AÑOS",
              "importe_descuento": "2215",
              "partida_descuento": 95106
            }
          ]
        },
        {
          "concepto": "SANCION REFRENDO PTE.AÑO",
          "importe_concepto": "130",
          "partida": 95123,
          "descuentos": [
            {
              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
              "importe_descuento": "130",
              "partida_descuento": 95136
            }
          ]
        }
      ]
    },
    {
      "id_seguimiento":43,
      "id_tipo_servicio": 3,
      "id_tramite": "BMU8605134I81GBKC34JXWJ103325",
      "importe_tramite": "826",
      "auxiliar_1": "GRUPOS ICV BMU8605134I8 ",
      "auxiliar_2": "",
      "auxiliar_3": "",
      "datos_solicitante": {
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
      },
      "datos_factura": {
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
      },
      "detalle": [
        {
          "concepto": "REFRENDO PTE.AÑO",
          "importe_concepto": "3041",
          "partida": 95101,
          "descuentos": [
            {
              "concepto_descuento": "SUBSIDIO ANTIGUEDAD 15 AÑOS",
              "importe_descuento": "2215",
              "partida_descuento": 95106
            }
          ]
        },
        {
          "concepto": "SANCION REFRENDO PTE.AÑO",
          "importe_concepto": "130",
          "partida": 95123,
          "descuentos": [
            {
              "concepto_descuento": "SUBSIDIO PAPV REFRENDO PA",
              "importe_descuento": "130",
              "partida_descuento": 95136
            }
          ]
        }
      ]
    }
    
  ]
}
  	}
};


