var Checkbox = function(campo) {
   	
    return {
        setInfo: function( campo) {
            this.name = campo.nombre.toLowerCase().split(" ").join("_");
            this.id = campo.nombre.toLowerCase().split(" ").join("_");
            this.caracteristicas = JSON.parse(campo.caracteristicas);
            this.descripcion = campo.nombre;
            this.tipo = "checkbox";
            return this;
        },

        build: function(){
            return  $("<input>").attr({
                name: this.name,
                id: this.id,
                type:"checkbox",
                required: !!this.caracteristicas.required
            });
        },

        isValid: function(){
          
        },

        getValue: () => {

        }



    };
};