require('./bootstrap');

//require('dotenv').config();


window.Vue = require('vue');
import UUID from "vue-uuid";
import Vuetify from 'vuetify';
Vue.use(UUID);
Vue.use(Vuetify);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

document.getElementById("close-header").addEventListener("click", () => {
    let sideBar = document.getElementById("kt-header-sidebar");
    let content = document.getElementById("kt_content");
    let fas = document.getElementById("close-header").querySelector(".fas");
    if(!sideBar.classList.contains("close")){
        fas.classList.remove("fa-chevron-left")
        fas.classList.add("fa-chevron-right")
        sideBar.classList.add("close");
        content.classList.add("header-closed");
    }else{
        fas.classList.remove("fa-chevron-right")
        fas.classList.add("fa-chevron-left")
        sideBar.classList.remove("close");
        content.classList.remove("header-closed");
    }
})

Vue.component('listado-tramites-component', require('./components/ListadoTramitesComponent.vue').default);
Vue.component('tramite-component', require('./components/TramiteComponent.vue').default);
Vue.component('wizard-component', require('./components/WizardComponent.vue').default);
Vue.component('tramite-component', require('./components/TramiteComponent.vue').default);
Vue.component('campos-tramite-component', require('./components/CamposTramiteComponent.vue').default);
Vue.component('solicitantes-component', require('./components/SolicitantesComponent.vue').default);
Vue.component('resumen-tramite-component', require('./components/ResumenTramiteComponent.vue').default);
/*Componentes tipo de campos*/
// Vue.component('input-component', require('./components/tiposElementos/InputComponent.vue').default);
Vue.component('car-shop-component', require('./components/carShop/CarShopComponent.vue').default);
Vue.component('metodos-pago-component', require('./components/carShop/MetodosDePagoComponent.vue').default);
Vue.component('item-solictud-carshop-component', require('./components/carShop/ItemSolicitudCarShopComponent.vue').default);
Vue.component('detalle-pago-component', require('./components/carShop/DetallePagoComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter("capitalize", function (value) {
    if (!value) 
        return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

const app = new Vue({
    el: '#app',
});
