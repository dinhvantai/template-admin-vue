import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import VueI18n from 'vue-i18n'
import BootstrapVue from 'bootstrap-vue'
import Toaster from 'v-toaster'
import VueSwal from 'vue-swal'

// import VueSocketIO from 'vue-socket.io';

import 'v-toaster/dist/v-toaster.css'

Vue.use(Vuex)

Vue.use(VueRouter)

Vue.use(VueI18n)

Vue.use(BootstrapVue);

Vue.use(Toaster, { timeout: 5000 })

Vue.use(VueSwal)
// Vue.use(VueSocketIO, 'http://localhost:8000')
