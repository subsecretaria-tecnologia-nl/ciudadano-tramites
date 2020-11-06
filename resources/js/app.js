require('./bootstrap');

//require('dotenv').config();


//window.Vue = require('vue');
import Vue from 'vue'
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
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)));

document.getElementById("close-header").addEventListener("click", () => {
    let sideBar = document.getElementById("kt-header-sidebar");
    let content = document.getElementById("kt_content");
    let fas = document.getElementById("close-header").querySelector(".fas");
    if (!sideBar.classList.contains("close")) {
        fas.classList.remove("fa-chevron-left")
        fas.classList.add("fa-chevron-right")
        sideBar.classList.add("close");
        content.classList.add("header-closed");
    } else {
        fas.classList.remove("fa-chevron-right")
        fas.classList.add("fa-chevron-left")
        sideBar.classList.remove("close");
        content.classList.remove("header-closed");
    }
})

Vue.component('listado-tramites-component', () =>
    import ( /* webpackChunkName: "js/components/listado-tramites-component" */ './components/ListadoTramitesComponent.vue'));
Vue.component('tramite-component', () =>
    import ( /* webpackChunkName: "js/components/tramite-component" */ './components/TramiteComponent.vue'));
Vue.component('wizard-component', () =>
    import ( /* webpackChunkName: "js/components/wizard-component" */ './components/WizardComponent.vue'));

Vue.component('tramite-component', () =>
    import ( /* webpackChunkName: "js/components/tramite-component" */ './components/TramiteComponent.vue'));
Vue.component('campos-tramite-component', () =>
    import ( /* webpackChunkName: "js/components/campos-tramite-component" */ './components/CamposTramiteComponent.vue'));
Vue.component('solicitantes-component', () =>
    import ( /* webpackChunkName: "js/components/solicitantes-component" */ './components/SolicitantesComponent.vue'));
Vue.component('resumen-tramite-component', () =>
    import ( /* webpackChunkName: "js/components/resumen-tramite-component" */ './components/ResumenTramiteComponent.vue'));
Vue.component('usuarios-component', () =>
    import ( /* webpackChunkName: "tramite-component" */ './components/Usuarios.vue'));

Vue.component('car-shop-component', () =>
    import ( /* webpackChunkName: "js/components/car-shop-component" */ './components/carShop/CarShopComponent.vue'));
Vue.component('metodos-pago-component', () =>
    import ( /* webpackChunkName: "js/components/metodos-pago-component" */ './components/carShop/MetodosDePagoComponent.vue'));

Vue.component('item-solictud-carshop-component', () =>
    import ( /* webpackChunkName: "js/components/item-solictud-carshop-component" */ './components/carShop/ItemSolicitudCarShopComponent.vue'));
Vue.component("detalle-pago-component", () =>
    import ( /* webpackChunkName: "js/components/detalle-pago-component" */ './components/carShop/DetallePagoComponent.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter("capitalize", function(value) {
    if (!value)
        return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

const app = new Vue({
    el: '#app',
});