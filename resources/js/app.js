
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import validationMixin  from 'vuelidate'
import VeeValidate from 'vee-validate';
import swal from 'sweetalert2'

window.swal=swal;
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast=toast;



window.Vue = require('vue');
Vue.use(VeeValidate);
Vue.use(validationMixin)

Vue.use(VueAxios, axios)
Vue.use(Vuetify)
Vue.use(Vuetify, {
  rtl: true
})

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




Vue.use(VueRouter)
let routes = [
  { path: '/users', component: require('./components/Users.vue') },
  { path: '/cars', component: require('./components/Cars.vue') },
  { path: '/tickets', component: require('./components/tickets.vue') },
  { path: '/orders', component: require('./components/orders.vue') },
]

const router = new VueRouter({
 
  routes // short for `routes: routes`
})

window.Fire=new Vue();

new Vue({
  el: '#app',
  router,
  data: () => ({
    message: '',
    drawer: null,
 
  }),

  props: {
    source: String
  }
})