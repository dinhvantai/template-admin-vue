import Vue from 'vue'
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import BootstrapVue from 'bootstrap-vue'
import VueSocketIO from 'vue-socket.io';

import App from './App.vue'
import router from './router/router'
import messages from '../i18n/admin/index'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../config/admin/config');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter)
Vue.use(VueI18n)
Vue.use(BootstrapVue);

// Vue.use(VueSocketIO, 'http://localhost:8000')

const i18n = new VueI18n({
    locale: 'en', // set locale
    messages // set locale messages
})

new Vue({
    router,
    i18n,
    template: '<App/>',
    components: { App }
}).$mount('#admin');
