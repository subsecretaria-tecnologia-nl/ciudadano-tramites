<template>
  <div class="col-md-6 col-sm-6 col-xs-6 col-md-12 col-sm-12 col-xs-12">
    <div   class="form-group fv-plugins-icon-container">

        <div class="alert text-center" role="alert" style="background-color:#e1f5fe !important; border-color:#e1f5fe;">
        Expediente Catastral : 
        </div>
        <div class="alert p-8" role="alert" style="background-color:#fbe3e4 !important ; border-color:#fbe3e4l ; color:red">
        Informacion! los siguientes detalles deben de tomarse en cuenta
            <li class="pl-6" style="color:red">Debe de existir un porcentaje de venta</li>
        </div>

        <div class="progress" style="height: 3px;">
            <div class="progress-bar " role="progressbar" :style=" 'width: ' + progress + '%'" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <label>{{ campos.nombre }}</label>
        <table class="table ">
            <thead>
                <tr>
                    <th>
                            Tipo de persona
                    </th>
                    <th>
                            Nombre
                    </th>
                    <th>
                            RFC 
                    </th>
                    <th>
                            CURP
                    </th>
                    <th>
                            % Propiedad 
                    </th>
                    <th>
                            Unsufructo 
                    </th>
                    <th>
                            % Venta 
                    </th>
                    <th>
                            Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="">
                <tr  v-for="(registro, key) in campos[0].registros"  :key="registro.rfc" >
                    <td>
                        {{registro.clasePro}}
                    </td>	
                    <td>
                        {{registro.nombrePro}}	{{registro.apePat}} {{registro.apeMat}}
                    </td>	
                    <td>
                        {{registro.rfc}}
                    </td>	
                    <td>
                        {{registro.curp}}
                        {{registro.id_propietario}}
                    </td>	
                    <td>
                        {{registro.nuda}}
                    </td>	
                    <td>
                        {{registro.usufructo}}
                    </td>	
                    <td>
                        {{registro.porcentajeVenta}}
                    </td>	
                    <td>
                            <button type="button" @click="editar(key, registro)"  class="text-center p-2 btn btn-info eddit" ><i class="la la-pencil-alt"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="btn bg-success w-80 mb-4 " @click="add()">
                <div style="color:white"><i class="la la-plus" style="color:white"></i> Agregar vendedor </div>	
        </div>
        <div class="progress" style="height: 3px;">
            <div class="progress-bar " role="progressbar" :style=" 'width: ' + progress + '%'" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>

    <!-- <code> {{campos}} </code> -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title left" v-if="helper==1">Editar Vendedor</h4>
                    <h4 class="modal-title left" v-if="helper==0">Agregar Vendedor</h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        <p>Seleccione una nacionalidad</p>
                        <div class="form-check form-check-inline pb-4">
                            <input class="form-check-input" type="radio" id="Extranjero" name="nacionalidad" value="Extranjero"  v-model="modalx.nacionalidad">
                            <label class="form-check-label">Extranjero</label><br>
                            <input class="form-check-input ml-6" type="radio" id="Mexicano" name="nacionalidad" value="Mexicano"  v-model="modalx.nacionalidad">
                            <label class="form-check-label" for="other">Mexicano</label>	
                        </div>
                        <small v-if="!modalx.nacionalidad">
                            <span class="form-text text-danger" :id="[[modalx.nacionalidad]]">  
                                Nacionalidad: {{mensajeRequerido}}
                            </span>
                        </small>
                        <div v-if="modalx.nacionalidad == 'Mexicano'">
                            <p>Seleccione el tipo de persona</p>
                            <div class="form-check form-check-inline pb-4">
                                <input class="form-check-input" type="radio" id="Fisica" name="persona" value="Fisica"  v-model="modalx.persona">
                                <label class="form-check-label">Fisica</label><br>
                                <input class="form-check-input ml-6" type="radio" id="Moral" name="persona" value="Moral"  v-model="modalx.persona">
                                <label class="form-check-label" for="other">Moral</label>	
                            </div>
                            <small v-if="!modalx.persona">
                                <span class="form-text text-danger" :id="[[modalx.persona]]">  
                                  Tipo de persona: {{mensajeRequerido}}
                                </span>
                            </small>
                        </div>
                        <div class="col" >
                            <label for="">Tipo de propietario</label>
                            <select v-model="modalx.tipoPropietario" class="row form-control">
                                <option  selected disabled value="0">Seleccione</option>
                                <option value="PROPIETARIO">Propietario</option>
                                <option value="Nuda Propiedad">Nuda Propiedad</option>
                                <option value="Unsufructuario">Unsufructuario</option>
                                <option value="Copropietario">Copropietario</option>
                            </select>
                             <small v-if="!modalx.tipoPropietario">
                                <span class="form-text text-danger" :id="[[modalx.tipoPropietario]]">  
                                  Tipo de propietario: {{mensajeRequerido}}
                                </span>
                            </small>
                        </div>
                        
                        <div v-if="modalx.nacionalidad== 'Extranjero'">
                            <div class=" form-group row">
                                <div class="col">
                                    <label for="">Nombre(s):</label>
                                    <input v-model="modalx.nombre" type="text" class="form-control">
                                    <small v-if="!modalx.nombre">
                                        <span class="form-text text-danger" :id="[[modalx.nombre]]">  
                                        Nombre: {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                                <div class="col">
                                    <label for="">Apellido Paterno:</label>
                                    <input v-model="modalx.apellidoP" type="text" class="form-control">
                                    <small v-if="!modalx.apellidoP">
                                        <span class="form-text text-danger" :id="[[modalx.apellidoP]]">  
                                        Apellido Paterno: {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <div class="col">
                                    <label for="">Apellido Materno:</label>
                                    <input v-model="modalx.apellidoM" type="text" class="form-control">
                                    <small v-if="!modalx.apellidoM">
                                        <span class="form-text text-danger" :id="[[modalx.apellidoM]]">  
                                        Apellido Materno: {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                                <div class="col">
                                    <label for="">Fecha de Nacimiento:</label>
                                    <input v-model="modalx.fechaNac" type="text" class="form-control">
                                    <small v-if="!modalx.fechaNac">
                                        <span class="form-text text-danger" :id="[[modalx.fechaNac]]">  
                                        Fecha de nacimiento: {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                            </div>
                            <div class="col">
                                <label  class="form-check-label " for="">País de nacimiento:</label>
                                    <select v-model="modalx.country" class="row form-control">
                                    <option  selected disabled value="0">Seleccione</option>
                                    <option value="USA">Estados Unidos </option>
                                    <option value="Canada">Canada</option>
                                </select>
                                <small v-if="!modalx.country">
                                        <span class="form-text text-danger" :id="[[modalx.country]]">  
                                        Pais: {{mensajeRequerido}}
                                        </span>
                                </small>
                            </div>
                        </div>

                        <div v-if="modalx.persona== 'Fisica'">

                            <p>¿Cuenta con el curp del vendedor?</p>
                            <div class="form-check form-check-inline pb-4">
                                <input class="form-check-input" type="radio" id="Si" name="nacionalidad" value="Si"  v-model="modalx.curpExist">
                                <label class="form-check-label">Si</label><br>
                                <input class="form-check-input ml-6" type="radio" id="No" name="nacionalidad" value="No"  v-model="modalx.curpExist">
                                <label class="form-check-label" for="other">No</label>	
                            </div>
                                <small v-if="!modalx.curpExist">
                                        <span class="form-text text-danger" :id="[[modalx.curpExist]]">  
                                        Campo requerido
                                        </span>
                                </small>
                            <div v-if="modalx.curpExist != ''">  
                                <div class=" form-group row">
                                    <div class="col">
                                        <label for="">Curp:</label>
                                        <input v-model="modalx.curp" :disabled="modalx.curpExist == 'No'" @blur='buscarCurp(modalx.curp)' type="text" class="form-control">
                                        <small v-if="!modalx.curp && modalx.curpExist != 'No'"> 
                                            <span class="form-text text-danger" :id="[[modalx.curp]]">  
                                            Curp: {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="col">
                                        <label for="">RFC:</label>
                                        <input v-model="modalx.rfc" type="text" class="form-control">
                                        <small v-if="!modalx.rfc">
                                            <span class="form-text text-danger" :id="[[modalx.rfc]]">  
                                            Rfc: {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                                <div class=" form-group row">
                                    <div class="col">
                                        <label for="">Nombre(s):</label>
                                        <input v-model="modalx.nombre" :disabled="modalx.curpExist == 'Si'" type="text" class="form-control">
                                        <small v-if="!modalx.nombre">
                                            <span class="form-text text-danger" :id="[[modalx.nombre]]">  
                                            Nombre: {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="col">
                                        <label for="">Apellido Paterno:</label>
                                        <input v-model="modalx.apellidoP" :disabled="modalx.curpExist == 'Si'" type="text" class="form-control">
                                        <small v-if="!modalx.apellidoP">
                                                <span class="form-text text-danger" :id="[[modalx.apellidoP]]">  
                                                Apellido Paterno {{mensajeRequerido}}
                                                </span>
                                        </small>
                                    </div>
                                </div>
                                <div class=" form-group row">
                                    <div class="col">
                                        <label for="">Apellido Materno:</label>
                                        <input v-model="modalx.apellidoM" :disabled="modalx.curpExist == 'Si'" type="text" class="form-control">
                                        <small v-if="!modalx.apellidoM">
                                            <span class="form-text text-danger" :id="[[modalx.apellidoM]]">  
                                            Apellido Materno {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="col">
                                        <label for="">Fecha de Nacimiento:</label>
                                        <input v-model="modalx.fechaNac" :disabled="modalx.curpExist == 'Si'" type="text" class="form-control">
                                        <small v-if="!modalx.fechaNac">
                                            <span class="form-text text-danger" :id="[[modalx.fechaNac]]">  
                                            Fecha nacimiento {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            
                                <div class=" form-group row">
                                    <div class="col">
                                        <label for="">Genero:</label>
                                        <input v-model="modalx.sexo"  :disabled="modalx.curpExist == 'Si'" type="text" class="form-control">
                                        <small v-if="!modalx.sexo">
                                            <span class="form-text text-danger" :id="[[modalx.sexo]]">  
                                            Genero {{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="col">
                                        <label for="">Estado de Nacimiento:</label>
                                        <input type="text" v-model="modalx.EstadoNac" :disabled="modalx.curpExist == 'Si'" class="form-control">
                                        <small v-if="!modalx.fec">
                                            <span class="form-text text-danger" :id="[[modalx.EstadoNac]]">  
                                            Fecha nacimiento{{mensajeRequerido}}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            </div>    
                           
                        </div>

                        <div v-if="modalx.persona== 'Moral'">
                            <div class=" form-group row">
                                <div class="col">
                                    <label for="">RFC:</label>
                                    <input v-model="modalx.rfc" type="text" class="form-control">
                                    <small v-if="!modalx.rfc">
                                        <span class="form-text text-danger" :id="[[modalx.rfc]]">  
                                        Rfc {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                                <div class="col">
                                    <label for="">Razon Social:</label>
                                    <input v-model="modalx.razonS" type="text" class="form-control">
                                    <small v-if="!modalx.razonS">
                                        <span class="form-text text-danger" :id="[[modalx.razonS]]">  
                                        Razon social {{mensajeRequerido}}
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="col">
                                <label for="">Porcentaje de propiedad</label>
                                <input v-model="modalx.porcentajePropiedad" class="form-control" type="number" name="porcentaje" id="">
                                <small v-if="!modalx.porcentajePropiedad">
                                        <span class="form-text text-danger" :id="[[modalx.porcentajePropiedad]]">  
                                        Porcentaje de propiedad {{mensajeRequerido}}
                                        </span>
                                </small>
                            </div>
                            <div class="col pt-8" >
                                <input v-model="modalx.unsufructo" class="form-check pt-8" style="margin-left:28%" type="checkbox" name="unsufructo" id="">
                                <label for="">Presentar unsufructo?</label>
                            </div>
                        </div>
                        <div class="col-6 form-group row">
                            <label for="">Porcentaje de venta</label>
                            <input v-model="modalx.porcentajeVenta" class="form-control" type="number" name="venta" id="">
                            <small v-if="!modalx.porcentajeVenta">
                                    <span class="form-text text-danger" :id="[[modalx.porcentajeVenta]]">  
                                    Porcentaje de venta {{mensajeRequerido}}
                                    </span>
                            </small>
                        </div>
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem ipsum esse dignissimos, quas ab quia libero itaque enim aut repellendus molestias sunt totam hic. Nisi, eius cumque.</p>
                        <div class="dropdown-divider"></div>
                        <div class="text-center pt-8">
                            <h3>Direccion de notificacion en el estado</h3>
                            <h3>No obligatorio</h3>
                        </div>

                        <div class="col">
                            <label for=""> Correo </label>
                            <input type="email" class="row form-control ">
                        </div>
                        <div class=" form-group row">
                            <div class="col">
                                <label for="">Telefono fijo</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Telefono de casa</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class=" form-group row">
                            <div class="col-6">
                                <label for="">Tipo de vialidad</label>
                                <input type="select" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Nombre de vialidad</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class=" form-group row">
                            <div class="col-4">
                                <label for="">No. Exterior</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="">No. Interior</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="">Codigo postal</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class=" form-group row">
                            <div class="col">
                                <label for="">Colonia</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col">
                                <label for="">Municipio</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Referencia</label>
                            <input type="text" name="" id="" class="form-control">
                        </div>
                    </form>
                    
                </div>
                <div class="modal-footer row">
                    <button type="button" class="btn btn-danger" style="width: 48%;" data-dismiss="modal">Cancelar</button>
                    <button v-if="helper == 1" type="button" class="btn btn-primary" style="width: 48%;" data-dismiss="modal" @click="saveEdit()">Guardar</button>
                    <button v-if="helper == 0" type="button" class="btn btn-primary" style="width: 48%;" data-dismiss="modal" @click="saveNew()">Guardar</button>
                </div>
            </div>
            
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            campos:[
                {
                    "relationship":229,
						"tipo":"selecction",
						"nombre":"Vendedores",
						"registros" : [
                            {id:1221 , nacionalidad: 'Mexicano' , nombre:"jaime",  tipoPersona:"Fisica" , tipoPropietario: 'Propietario' , rfc: "CACJ9607222L1", curp: "CACJ960722HNLSMM14" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''},
							{id:1222 , nacionalidad: 'Mexicano' , nombre:"dexter",  tipoPersona:"Fisica" ,  tipoPropietario: 'Copropietario', rfc: "BEBT9509042L1", curp: "BEBT950904FCOBK22" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''},
							{id:1223 , nacionalidad: 'Mexicano' ,nombre:"thania", tipoPersona:"Moral",  tipoPropietario: 'Nuda Propiedad' ,rfc: "GATO" , curp: "---" , porcentajePropiedad : '', unsufructo: '', porcentajeVenta: ''}
						],
						"caracteristicas":"{\"required\":\"false\"}",
						"campo_id":79,
						"agrupacion_id":8,
						"orden":2,
						"nombre_agrupacion":"Expediente"
					}
            ],
            modalx: {
                persona: '',
                tipoPropietario: '',
                porcentajePropiedad: '',
                unsufructo: '',
                porcentajeVenta: '',
                rfc: '',
                nacionalidad: '',
                curp: '',
                curpExist: '',
                country: '' ,
                fechaNac: '',
                nombre: '',
                apellidoP: '',
                apellidoM: '',
                razonS: '',
                sexo: '',
                EstadoNac: '',
            },
            helper: '',
            progress: '',
            rowSelected: '',
            access_token: '',
            mensajeRequerido: ' es requerido'
        }
    },
    methods: {
            editar: function (key , registro) {
				console.log('editar');
				console.log('...' + key);
                $('#myModal').modal();
                this.helper = 1;
                this.rowSelected = key;
				this.modalx.nacionalidad = registro.nacionalidad;
				this.modalx.tipoPropietario = registro.tipoPro;
				this.modalx.persona = registro.clasePro;
				this.modalx.porcentajePropiedad = registro.nuda;
				this.modalx.porcentajeVenta = registro.porcentajeVenta;
				this.modalx.curp = registro.id_propietario;
				this.modalx.nombre = registro.nombrePro;
				this.modalx.rfc = registro.rfc;

			},
			add(){
				$('#myModal').modal();
                this.helper  = 0 ;
                this.cleanModal();
			},
			saveNew(){
                if(  ( parseInt(this.progress) + parseInt(this.modalx.porcentajeVenta) ) <= 100 ){
                    this.progress = parseInt(this.progress) + parseInt(this.modalx.porcentajeVenta);
                    this.campos[0].registros.push({tipoPersona: this.modalx.persona, porcentajeVenta: this.modalx.porcentajeVenta, porcentajePropiedad: this.modalx.porcentajePropiedad, unsufructo:  this.modalx.unsufructo = true ? 'si': 'no' })
                     console.log('guardado nuevo');
                }else{
                    alert('el porcentaje de venta no puede ser mayor a 100')
                }
                this.cleanModal();
            },
            saveEdit(){
                //todo
                this.campos[0].registros[this.rowSelected] =     {  clasePro: this.modalx.persona, 
                                                                    porcentajeVenta: this.modalx.porcentajeVenta, 
                                                                    nuda: this.modalx.porcentajePropiedad, 
                                                                    unsufructo:  this.modalx.unsufructo = true ? 'si': 'no',
                                                                    id:1221 , 
                                                                    nacionalidad: this.modalx.nacionalidad , 
                                                                    nombrePro: this.modalx.nombre,  
                                                                    tipoPro: this.modalx.tipoPropietario , 
                                                                    rfc: this.modalx.rfc, 
                                                                    curp: this.modalx.curp , 
                                                                    // porcentajePropiedad : this.modalx.porcentajePropiedad, 
                                                                    unsufructo: this.modalx.unsufructo, 
                                                                    porcentajeVenta: this.modalx.porcentajeVenta

                                                                    
                }
                console.log('edicion guardada');

                if(  ( this.progress + this.modalx.porcentajeVenta ) <= 100 ){
                    this.progress = this.progress + this.modalx.porcentajeVenta;
                }
                console.log(this.progress);

            },
            cleanModal(){
                this.modalx.nacionalidad = '';
				this.modalx.tipoPropietario = '';
				this.modalx.persona = '';
				this.modalx.porcentajePropiedad = '';
				this.modalx.porcentajeVenta = '';
				this.modalx.curp = '';
				this.modalx.nombre = '';
				this.modalx.sexo = '';
            },
            rellenarForm(data){
                this.modalx.nombre = data.data.nombres;
                this.modalx.apellidoP = data.data.apePat;
                this.modalx.apellidoM = data.data.apeMat;
                this.modalx.fechaNac = data.data.fechaNac;
                this.modalx.sexo = data.data.sexo;
            },
            accesToken(){
                var self = this;
                let url = "https://insumos.nl.gob.mx/api/auth" ;  
                var data = { 'username' : 'fun1' , 'password': 'prueba123' };
                $.ajax({
                    type: "POST",
                    data: data,
                    dataType: 'json', 
                    url,
                    success:function(data){
                        // console.log('..... ' + data.token);
                        self.access_token = data.token;
                        console.log(data.token);
                    },
                    error:function(error){
                        console.log(error);
                    },
                    complete:function(){
                        console.log('accestoken generado');
                    }
                });
            },
            buscarCurp(curp) {
                var self = this;
                let url = "https://insumos.nl.gob.mx/api/consultacurp" ;  
                // let url = "http://10.153.144.228/insumos-catastro-consulta/7090036008";  
                var data = { 'access_token' : self.access_token , 'curp' : curp  };
                $.ajax({
                    type: "GET",
                    data: data,
                    dataType: 'json', 
                    url,
                    success:function(data){
                        self.rellenarForm(data);
                        // this.$data = data.data.nombres;
                    },
                    error:function(error){
                        console.log(error);
                    },
                    complete:function(){
                        console.log('ya quedo');
                    }
                });
            },
            Vendedores() {
                let url = "http://10.153.144.228/insumos-catastro-consulta/7090036008";  
                $.ajax({
                    type: "GET",
                    url,
                    headers: {
                        "Authorization":"Bearer " + process.env.PAYMENTS_KEY,
                        "Content-type":"application/json"
                    }
                }).done((response) => {
                    if(response) {   
                        response = JSON.parse( response)
                        this.campos[0].registros = response.datos_propietarios;
                    } else {
                        alert('error en la busqueda de propietarios');
                    }
                }).fail((error)=> {
                    console.log( error)
                })
            },

    },
    mounted() {
        this.accesToken();
        this.Vendedores();
    }
}
</script>

<style>

</style>