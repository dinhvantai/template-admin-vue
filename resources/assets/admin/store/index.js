import Vue from 'vue'
import Vuex from 'vuex'

import storeAuth from './auth'
import storeAdminMenu from './menus'
import storeLoading from './loading'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        storeAuth,
        storeAdminMenu,
        storeLoading
    }
})
