var Select = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
   	this.descripcion = "";
   	this.tipo = "select";
};
Select.prototype = {
    setInfo: function( campo) {
	    this.name = campo.nombre.toLowerCase().split(" ").join("_");
	    this.id = campo.nombre.toLowerCase().split(" ").join("_");
	    this.caracteristicas = JSON.parse(campo.caracteristicas);
	   	this.descripcion = campo.nombre;
	    return this;
    },

   	build: function(){
    	return	$("<select>").attr({
			name: this.name,
			id: this.id,
			required: !!this.caracteristicas.required
		}).addClass("select2me form-control browser-default custom-select mb-4");
    }
};