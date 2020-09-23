function JSONGeneraReferencia(id_seguimiento, id_tipo_servicio, id_tramite, importe_tramite, auxiliar_1, auxiliar_2, auxiliar_3,datos_solicitante, datos_factura, detalle ) {

  this.id_seguimiento = id_seguimiento;
  this.id_tipo_servicio = id_tipo_servicio;
  this.id_tramite = id_tramite;
  this.importe_tramite = importe_tramite;
  this.auxiliar_1 = auxiliar_1;
  this.auxiliar_2 = auxiliar_2;
  this.auxiliar_3 = auxiliar_3;
  this.datos_solicitante = datos_solicitante;
  this.datos_factura = datos_factura;
  this.detalle = detalle;
  

  this.getJson = function() {
    return {
      id_seguimiento = this.id_seguimiento;
      id_tipo_servicio = this.id_tipo_servicio;
      id_tramite = this.id_tramite;
      importe_tramite = this.importe_tramite;
      auxiliar_1 = this.auxiliar_1;
      auxiliar_2 = this.auxiliar_2;
      auxiliar_3 = this.auxiliar_3;
      datos_solicitante = this.datos_solicitante;
      datos_factura = this.datos_factura;
      detalle = this.detalle;
    }
  }
}


