<template>
  <div class=" fv-plugins-icon-container">
    <label>
        {{ campo.nombre }}
    </label>
    <span class="currencyinput">
      <input
        type="text"
        class="form-control  form-control-lg "
        style="background-color: #e5f2f5 !important"
        :placeholder="[[campo.nombre]]"
        :id="[[campo.campo_id]]"
        v-model="campo.valor"
        @change="validar"
        @focus="validar"
      />
    </span>
    <small  v-if="campo.mensajes && campo.mensajes.length > 0 && ( showMensajes || estadoFormulario > 0)">
        <span v-for="mensaje in campo.mensajes" class="form-text text-danger">
          {{ mensaje.mensajeStr }}
        </span>
    </small>
  </div>
</template>

<script>

    export default {
      
      props: ['campo', 'estadoFormulario', 'showMensajes'],
      created() {
        this.validar();
      },
      methods: {
        formatear(){
          var number = this.campo.valor ? Number((this.campo.valor+"").replace(/[^0-9.-]+/g,"")) : "";
          let caracteristicas= this.getCaracteristicas();
          if( caracteristicas.formato == "moneda" && this.campo.valido){
            const formatter  = new Intl.NumberFormat('en-US', {
              style: 'currency',
              currency: 'MXN',
              minimumFractionDigits: 0
            });
            this.campo.valor = formatter.format(number);
            
          }
          if (this.campo.valor) {
            if( caracteristicas.formato == 'curp' && this.campo.valor.length  ==  18  ){
              var self = this;
                console.log('------');
                let url = "http://10.153.144.228/consultar-curp/" + this.campo.valor ;  
                $.ajax({
                  type: "GET",
                    dataType: 'json', 
                    url,
                    success:function(data){
                      // self.rellenarForm(data);
                        console.log('..se consulto el curp respuesta : ' + data );
                        // this.$data = data.data.nombres;
                        self.$emit('curpSearch', data)
                    },
                    error:function(error){
                      console.log('error: ', error);
                    },
                    complete:function(){
                      console.log('ya quedo');
                    }
                });
            }
          }
          this.$forceUpdate();
        },

        getCaracteristicas(){
          let caracteristicas = {};
          try {
            caracteristicas = JSON.parse(this.campo.caracteristicas + '');
          }catch(err){
            console.log(err);
          }
          return caracteristicas;
        },

        validar(a){
          // let curpValido = true;
          console.log('------');
          let requeridoValido = true;
          let caracteristicas = {};
          var caracteristicasStr = this.campo.caracteristicas;
          this.campo.mensajes = [];
            
          try {
            caracteristicas = this.getCaracteristicas();
          }catch(err){
            console.log(err);
          }

          // if( caracteristicas.expreg){
          //   var re = new RegExp(caracteristicas.expreg, "i");
          //   curpValido =  re.test(this.campo.valor) ;
          //   if(  !curpValido ){
          //     let mensaje = { 
          //       tipo:'regex',
          //       mensajeStr: "El campo " + this.campo.nombre + " no es válido"
          //     }
          //     this.campo.mensajes.push( mensaje );
          //   }
          // } 
          // console.log(caracteristicas.hasOwnProperty('required') && caracteristicas.required === 'true');
          if( caracteristicas.hasOwnProperty('required') && caracteristicas.required === 'true') {
            requeridoValido =  !!this.campo.valor && (this.campo.valor+"").length > 0;
            if( !requeridoValido ){
              let mensaje = { 
                tipo:'required',
                mensajeStr: "El campo " + this.campo.nombre + " es requerido"
              }
              this.campo.mensajes.push( mensaje );
            }
          }
          this.campo.valido =  requeridoValido;
          this.formatear();
          this.$emit('updateForm', this.campo);
          
        }
      }
    }
</script>