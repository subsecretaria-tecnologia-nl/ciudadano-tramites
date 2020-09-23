function JSONGeneraReferencia(token, url_retorno, importe_transaccion, id_transaccion, entidad, url_confirma_pago, tramite ) {

  this.token = token;
  this.url_retorno = url_retorno;
  this.importe_transaccion = importe_transaccion;
  this.id_transaccion = id_transaccion;
  this.entidad = entidad;
  this.url_confirma_pago = url_confirma_pago;
  this.tramite = tramite;
  

  this.getJson = function() {
    return {
      token:this.token,
      url_retorno:this.url_retorno,
      importe_transaccion:this.importe_transaccion,
      id_transaccion:this.id_transaccion,
      entidad:this.entidad,
      url_confirma_pago:this.url_confirma_pago,
      tramite:this.tramite
    }
  }
}