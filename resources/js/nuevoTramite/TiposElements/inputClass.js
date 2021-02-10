var Input = function(campo) {
    
    return {
        setInfo: function( campo) {
            this.name = campo.nombre.toLowerCase().split(" ").join("_");
            this.id = campo.nombre.toLowerCase().split(" ").join("_");
            this.caracteristicas = JSON.parse(campo.caracteristicas);
            this.descripcion = campo.nombre;
            this.tipo = "input";
            return this;
        },

        build: function(){
            return  $("<input>").attr({
                name: this.name,
                id: this.id,
                type:"text",
                required: !!this.caracteristicas.required
            }).addClass("form-control");
        },

        isValid: function(){
          
        },

        getValue: () => {
            console.log( "#" + this )
            return $("#" + this.id).val();
        }
    };
};