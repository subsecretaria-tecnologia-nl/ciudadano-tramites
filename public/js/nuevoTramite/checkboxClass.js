var Checkbox = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
};
Checkbox.prototype = {
    setInfo: function( campo) {
	    this.name = campo.nombre.toLowerCase();
	    this.id = campo.nombre.toLowerCase();
	    this.caracteristicas = campo.caracteristicas;
	    return this;
    },

    build: function(){
    	return	$("<input>").attr({
			name: this.name,
			id: this.id,
			type:"checkbox"
		});
    }

};