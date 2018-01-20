import Vue from 'vue'
import Vuex from 'vuex'
import storeAuth from './auth'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        storeAuth
    }
})