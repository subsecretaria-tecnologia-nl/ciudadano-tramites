var Select = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
};
Select.prototype = {
    setInfo: function( campo) {
	    this.name = campo.nombre.toLowerCase();
	    this.id = campo.nombre.toLowerCase();
	    this.caracteristicas = campo.caracteristicas;
	    return this;
    },

   	build: function(){
    	return	$("<select>").attr({
			name: this.name,
			id: this.id,
		}).addClass("select2me form-control browser-default custom-select mb-4");
    }
};