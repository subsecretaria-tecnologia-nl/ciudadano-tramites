var Input = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
    this.descripcion = "";
    this.tipo = "input";
};
Input.prototype = {
    setInfo: function( campo) {
	    this.name = campo.nombre.toLowerCase().split(" ").join("_");
	    this.id = campo.nombre.toLowerCase().split(" ").join("_");
	    this.caracteristicas = JSON.parse(campo.caracteristicas);
	    this.descripcion = campo.nombre;
	    return this;
    },

    build: function(){
    	return	$("<input>").attr({
			name: this.name,
			id: this.id,
			type:"text",
			required: !!this.caracteristicas.required
		}).addClass("form-control");
    }
};