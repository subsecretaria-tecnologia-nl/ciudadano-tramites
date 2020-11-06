<template>
    <div data-app>
        <!-- busqueda y numero de usuarios por pagina -->
        <div class="row">
            <v-col class="col-md-6 col-sm-1 " >
                    <v-select
                        :items="pageSizes"
                        v-model="porPagina"
                        label="Usuarios por pagina"
                        @change="handlePageSizeChange"
                    >
                    </v-select>       
            </v-col>
            <div class="col-md-6 col-sm-8">
                <v-text-field v-model="searchTitle" label="buscar usuario"></v-text-field>
            </div>
        </div>

        <!-- lista de usuarios -->
        <div class="row ">            
            <div class="col-md-3" v-for="usuario in filteredHelper" :key="usuario.id"> 
                <div class="card" style="height: 300px;;width: 300px;">
                        <div class="card-body" >
                            <div class="text-center">
                                <a type="button" ><img src="images/avatar6.png" class="mt-8" style="max-width: 70px;border-radius: 50%" ></img></a>
                            </div>
                        <div class="text-center pt-2">
                            <div>
                                    <span style="font-style: oblique;font-size: 15px">{{usuario.name }} {{usuario.mothers_surname}}  {{usuario.fathers_surname}}</span>
                            </div>
                            <div>
                                <span class="form-text text-muted">{{usuario.email}} </span>
                            </div>
                        </div>
                            <div class="text-center pt-10" >
                                <a :href="'mailto:'+ usuario.email " class="p-3 m-2" type="button" style="background-color: #d7e4f4;border-radius: 50%" ><i style="color: #347ab6" class="fas flaticon-multimedia"></i></a>
                                <a class="p-3 m-2" type="button" style="background-color: #d2dae0;border-radius: 50%" ><i style="color: #25457e" class="fas fas fa-phone-alt"></i></a>
                                <a class="p-3 m-2" type="button" style="background-color: #ddd5ea;border-radius: 50%" ><i style="color: #3f2174" class="fas flaticon2-arrow"></i></a>
                            </div>
                        </div>
                </div>
            </div>
        

        </div>

        <!-- paginado -->
        <div  class="row">
            <div class="col-md-12 col-sm-12">
            <v-pagination
                v-model="page"
                :length="totalPaginas"
                circle
                total-visible="7"
                next-icon="mdi-menu-right"
                prev-icon="mdi-menu-left"                
            ></v-pagination>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import Vuetify from 'vuetify';

Vue.use(Vuetify);
export default {
  vuetify: new Vuetify(),
    data() {
        return{
            usuarios:  [
                {
                    id: 99123123,
                    username: "titula12r",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "Raymundo",
                    mothers_surname: "1",
                    fathers_surname: "Serrato",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 3453419,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "PINK",
                    mothers_surname: "2",
                    fathers_surname: "X",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 453129,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "DEXTER",
                    mothers_surname: "3",
                    fathers_surname: "",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 35232229,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "THANIA",
                    mothers_surname: "4",
                    fathers_surname: "BECK",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 443219,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "JAIME",
                    mothers_surname: "5",
                    fathers_surname: "CAMARGO   ",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 939,
                    username: "titula12r",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "Raymundo",
                    mothers_surname: "6",
                    fathers_surname: "Serrato",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 19222,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "PINK",
                    mothers_surname: "7",
                    fathers_surname: "X",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 2941,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "DEXTER",
                    mothers_surname: "8",
                    fathers_surname: "",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 393121,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "THANIA",
                    mothers_surname: "9",
                    fathers_surname: "BECK",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 12312,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "JAIME",
                    mothers_surname: "10",
                    fathers_surname: "CAMARGO   ",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 923429,
                    username: "titula12r",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "Raymundo",
                    mothers_surname: "11",
                    fathers_surname: "Serrato",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 13429,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "PINK",
                    mothers_surname: "12",
                    fathers_surname: "X",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 29523,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "DEXTER",
                    mothers_surname: "13",
                    fathers_surname: "",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 346339,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "THANIA",
                    mothers_surname: "14",
                    fathers_surname: "BECK",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 49444,
                    username: "pink guys",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "JAIME",
                    mothers_surname: "15",
                    fathers_surname: "CAMARGO   ",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
                {
                    id: 9449,
                    username: "titula12r",
                    email: "raymundo.sssalser@hotmail.com",
                    role_id: 2,
                    config_id: 0,
                    name: "Raymundo",
                    mothers_surname: "16",
                    fathers_surname: "Serrato",
                    curp: "CODG930526MNLLLR00",
                    rfc: "sasa930216eq8",
                    phone: "8186843534",
                    status: 1,
                    created_by: 1,
                    created_at: "2020-09-18T17:43:02.000000Z",
                    updated_at: "2020-10-08T15:34:25.000000Z",
                    deleted_at: null,
                    pivot: {
                        "notary_office_id": 6,
                        "user_id": 99
                    }
                },
             
            ],
            users: [],
            helper: [],            
            searchTitle: null,
            page: 1,
            totalPaginas: 0,
            porPagina: 12,
            
            items: ['Foo', 'Bar', 'Fizz', 'Buzz'],

            pageSizes: [12, 20, 32],

        }
    },
    
    methods: {
        leerDatos() {
            axios.defaults.headers.common['Authorization'] = '';

            const axiosInstance = axios.create({
            headers: {
                "Access-Control-Allow-Origin": "*",
                'Content-Type': 'application/json',
            }
            });
            let url = ('http://10.153.144.218/session-api/notary-offices/6/users'); 
            let response =axiosInstance.get(url)
                .then((data) => {
                    //sustituir por this.usuarios para que sea dinamico al api 
                    this.users = data.data.response.notary_office_users;
                    this.totalPaginas = Math.ceil(this.usuarios.length / this.porPagina);

                }).catch((error)=> {
                    console.log(error)
                    this.usuarios = 'no se encontraron uusarios perrio u_u'
                    this.porPagina = 0 
                })
            
        },
    
        handlePageSizeChange(newPorpagina){
            this.porPagina = newPorpagina;
            this.totalPaginas = Math.ceil(this.usuarios.length / this.porPagina);
            this.page = 1;
        },

    },
    computed:{
         filteredHelper(){ 
           var inicio= (this.porPagina*(this.page -1));
            var arr_aux = [...this.usuarios];
             if(this.searchTitle != null)  {
                 // parametros con los que se basa la busqueda
                arr_aux = arr_aux .filter(search =>( search.name.includes(this.searchTitle) || search.mothers_surname.includes(this.searchTitle)  || search.fathers_surname.includes(this.searchTitle)  ))
                this.totalPaginas = Math.ceil(arr_aux.length / this.porPagina);
             }   
            var filteredHelper = arr_aux.splice( inicio  , this.porPagina);
           return filteredHelper;
        },
    
    },
    beforeMount(){
        this.leerDatos();
    },

}
</script>