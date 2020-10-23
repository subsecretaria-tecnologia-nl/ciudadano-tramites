require('./bootstrap');

//require('dotenv').config();


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('listado-tramites-component', require('./components/ListadoTramitesComponent.vue').default);
Vue.component('tramite-component', require('./components/TramiteComponent.vue').default);
Vue.component('wizard-component', require('./components/WizardComponent.vue').default);
Vue.component('tramite-component', require('./components/TramiteComponent.vue').default);
Vue.component('campos-tramite-component', require('./components/CamposTramiteComponent.vue').default);
Vue.component('solicitantes-component', require('./components/SolicitantesComponent.vue').default);
Vue.component('resumen-tramite-component', require('./components/ResumenTramiteComponent.vue').default);
/*Componentes tipo de campos*/
// Vue.component('input-component', require('./components/tiposElementos/InputComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
console.log(process.env);
 Vue.filter("capitalize", function (value) {
    if (!value) 
        return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

const app = new Vue({
    el: '#app',
});
