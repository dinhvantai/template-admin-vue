import { callFetchMenus } from '../api/adminMenu'
import Helper from '../library/Helper'

export const MENU_POSITION_MAIN = 'main'
export const MENU_POSITION_ON_TOP = 'top'

export const ADMIN_MENU_FETCH = 'admin_ADMIN_menu_fetch'

export const ADMIN_MENU_POSITION_OPTION = [
    { value: MENU_POSITION_MAIN, text: 'textPositionMain' },
    { value: MENU_POSITION_ON_TOP, text: 'textPositionOnTop' }
]

const state = {
    menus: [],
    total: 0,
}

const mutations = {
    async [ADMIN_MENU_FETCH](state, vue, params = {}) {
        let response = await callFetchMenus(params);
        if (response.status == 200) {
            state.menus = response.data.data
            state.total = response.data.total

            return;
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    }
}

const actions = {
    callFetchMenus({ commit }, vue, params = {}) {
        return commit(ADMIN_MENU_FETCH, vue, params);
    }
}

const storeAdminMenu = {
    state,
    actions,
    mutations
}

export default storeAdminMenu;
