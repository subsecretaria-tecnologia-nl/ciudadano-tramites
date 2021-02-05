<template>
	<div class=" fv-plugins-icon-container">
		<label>{{ campo.nombre }}</label>
		<select :id="[[campo.campo_id || campo.nombre.split(' ').join('_')  ]]" :name="[[campo.campo_id]]" 
			:multiple="campo.tipo == 'multiple'"
			class="form-control  form-control-lg" style="background-color: #e5f2f5 !important"
			v-model="campo.valor" @change="validar" @focus="validar">
			<option v-if="campo.nombre === 'Estado' || campo.nombre === 'Municipio'" v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
				:value="opcion.clave">
					{{ opcion.nombre }}
			</option>
			<option v-if="campo.nombre != 'Estado' && campo.nombre !=   'Municipio'"  v-for="opcion in JSON.parse(campo.caracteristicas).opciones" 
				:value="[[Object.keys(opcion)[0] ]]">
					{{ opcion[ Object.keys(opcion)[0] ] }}
			</option>
		</select>
		<small  class="form-text text-muted" v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || estadoFormulario > 0)">
			<span v-for="mensaje in campo.mensajes">
				{{ mensaje.mensajeStr }}
			</span>
		</small>
	</div>
</template>

<script>
    export default {
      props: ['campo', 'estadoFormulario', 'showMensajes', 'estado'],

      created(){
        if(this.campo.tipo == 'multiple'){
          this.campo.valor = this.campo.valor || [];  
        }
      
        this.validar();
        this.opcionesEstado();
      },
      mounted(){
        if(this.campo.nombre== "Cambio de divisas" && !this.campo.valor){
          this.campo.valor = [ [ "PESOS" ]]
          $("#"+ this.campo.nombre.split(' ').join('_') ).val("PESOS");
          this.validar();
        }
      },
      methods: {
        opcionesEstado(){
          let caracteristicas = {};
          // estado  {"required":"true","opciones":[]}
            try{
                caracteristicas = JSON.parse(this.campo.caracteristicas + '');
            }catch(err){
            console.log(err);
            }
            if( this.campo.nombre == 'Estado'){
                var self = this;
                    let url = process.env.TESORERIA_HOSTNAME + "/obtener-estados" ;  
                     axios
                      .get(url)
                      .then(data => {
                        var aux = [];
                          aux.push({"required":"true","opciones": data.data })
                          aux =  JSON.stringify(aux[0]);
                          self.campo.caracteristicas = aux;
                          console.log(self.campo);
                      })
                      .catch(error => {
                              console.log(error);
                      })
                      .finally(() => console.log('listo'))
            }
        },
        validar(){
          let requeridoValido = true;
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }
          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required === 'true') {
            requeridoValido =  this.campo.valor && this.campo.valor.length > 0;
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }
          this.campo.valido = requeridoValido;

          this.$emit('updateForm', this.campo);
          if (this.campo.nombre == 'Estado') {
            this.$emit('estadoSelected', this.campo.valor);
          }
          if (this.estado == '') {
            this.$emit('estadoSelected', 19);
          }
        }
      },

      watch: {
        estado: function() {
              if( this.campo.nombre == 'Municipio'){
                var self = this;
                let url =  process.env.TESORERIA_HOSTNAME + "/obtener-municipios/" + this.estado ;  
                console.log(url);
                  axios
                  .get(url)
                  .then(data => {
                    var aux = [];
                          aux.push({"required":"true","opciones": data.data})
                          aux =  JSON.stringify(aux[0]);
                          self.campo.caracteristicas = aux;
                          console.log('campo municipio actualizado? : ',self.campo);
                  })
                  .catch(error => {
                          console.log(error);
                  })
                  .finally(() => console.log('listo'))
          }
        }
      }
    }
</script>