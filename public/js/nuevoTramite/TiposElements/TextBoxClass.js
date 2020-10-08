var TextBox = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
    this.descripcion = "";
    this.tipo = "textarea";
};
TextBox.prototype = {
    setInfo: function( campo) {
      this.name = campo.nombre.toLowerCase().split(" ").join("_");
      this.id = campo.nombre.toLowerCase().split(" ").join("_");
      this.caracteristicas = JSON.parse(campo.caracteristicas);
      this.descripcion = campo.nombre;
      return this;
    },

    build: function(){
      let element =  $("<textarea>").attr({
        name: this.name,
        id: this.id,
        required: !!this.caracteristicas.required
      }).addClass("form-control");
      return element;
    }
};