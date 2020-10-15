var Radio = function() {
    this.name = "";
    this.id = "";
    this.caracteristicas = {};
    this.descripcion = "";
    this.tipo = "option";
};
Radio.prototype = {
    setInfo: function( campo) {
      this.name = campo.nombre.toLowerCase().split(" ").join("_");
      this.id = campo.nombre.toLowerCase().split(" ").join("_");
      this.caracteristicas = JSON.parse(campo.caracteristicas);
      this.descripcion = campo.nombre;
      return this;
    },

    build: function(){

      let divOptions = $("<div>");
      if( this.caracteristicas ){
        this.caracteristicas.opciones.forEach( (opcion, key) => {
            let clave =  Object.keys(opcion)[0];
            let element = $("<input>").attr({
              name: this.name,
              id: this.id + "_" + clave,
              type:"radio", value: clave, 
              required: !!this.caracteristicas.required
            });
            let label = $("<label>").attr({
              for: this.id + "_" + clave
            }).append( opcion[clave] );

            divOptions.append( element );
            divOptions.append( label );
        });
      }
      return divOptions;
    },

    isValid: function(){
      
    }
};