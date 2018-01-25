import { callFetchMenus, callApiAddMenu } from '../api/adminMenu'
import { callApiEditMenu, callApiDeleteMenu } from '../api/adminMenu'
import Helper from '../library/Helper'

export const MENU_POSITION_MAIN = 'main'
export const MENU_POSITION_ON_TOP_LEFT = 'top_left'
export const MENU_POSITION_ON_TOP_RIGHT = 'top_right'


export const ADMIN_MENU_POSITION_OPTION = [
    { value: MENU_POSITION_MAIN, text: 'textPositionMain' },
    { value: MENU_POSITION_ON_TOP_LEFT, text: 'textPositionOnTopLeft' },
    { value: MENU_POSITION_ON_TOP_RIGHT, text: 'textPositionOnTopRight' }
]

const ADMIN_MENU_FETCH = 'admin_menu_fetch'
const ADMIN_MENU_MODAL_ADD = 'admin_menu_modal_add'
const ADMIN_MENU_ADD = 'admin_menu_add'
const ADMIN_MENU_MODAL_EDIT = 'admin_menu_modal_edit'
const ADMIN_MENU_EDIT = 'admin_menu_edit'
const ADMIN_MENU_DELETE = 'admin_menu_delete'

const state = {
    menus: [],
    modalAdd: {
        open: false
    },
    modalEdit: {
        open: false,
        formData: {}
    }
}

const mutations = {
    async [ADMIN_MENU_FETCH](state, { vue, params }) {
        let loading = vue.$store.state.storeLoading.loading
        vue.$store.dispatch('setAdminLoading', { ...loading, show: true })

        let response = await callFetchMenus(params);

        vue.$store.dispatch('setAdminLoading', { ...loading, show: false })

        if (response.status == 200) {
            return state.menus = response.data
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    [ADMIN_MENU_MODAL_ADD](state, { vue, modalAdd }) {
        return state.modalAdd = modalAdd;
    },

    [ADMIN_MENU_MODAL_EDIT](state, { vue, modalEdit }) {
        return state.modalEdit = modalEdit;
    },

    async [ADMIN_MENU_ADD](state, { vue, params }) {
        let response = await callApiAddMenu(params)
        if (response.status == 200) {
            state.modalAdd = { ...state.modalAdd, open: false }
            vue.$store.commit(ADMIN_MENU_FETCH, { vue })

            return vue.$toaster.success(response.data.message);
        }

        state.modalAdd = { ...state.modalAdd, open: true }
        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async [ADMIN_MENU_EDIT](state, { vue, id, params }) {
        let response = await callApiEditMenu(id, params)
        if (response.status == 200) {
            state.modalEdit = { ...state.modalEdit, open: false }
            vue.$store.commit(ADMIN_MENU_FETCH, { vue })

            return vue.$toaster.success(response.data.message);
        }

        state.modalEdit = { ...state.modalEdit, open: true }
        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    },

    async [ADMIN_MENU_DELETE](state, { vue, id }) {
        let response = await callApiDeleteMenu(id)

        if (response.status == 200) {
            vue.$store.commit(ADMIN_MENU_FETCH, { vue })

            return vue.$toaster.success(response.data.message);
        }

        return vue.$toaster.error(Helper.getFirstError(response, vue.$i18n.t('textDefaultErrorRequest')));
    }
}

const actions = {
    callFetchMenus({ commit }, { vue, params }) {
        return commit(ADMIN_MENU_FETCH, { vue, params });
    },

    callMenuAdd({ commit }, { vue, params }) {
        return commit(ADMIN_MENU_ADD, { vue, params })
    },

    setMenuModalAdd({ commit }, { vue, modalAdd }) {
        return commit(ADMIN_MENU_MODAL_ADD, { vue, modalAdd })
    },

    callMenuEdit({ commit }, { vue, id, params }) {
        return commit(ADMIN_MENU_EDIT, {vue, id, params})
    },

    setMenuModalEdit({ commit }, { vue, modalEdit }) {
        return commit(ADMIN_MENU_MODAL_EDIT, {vue, modalEdit})
    },

    callMenuDelete({ commit }, { vue, id }) {
        return commit(ADMIN_MENU_DELETE, { vue, id })
    }
}

const storeAdminMenu = {
    state,
    actions,
    mutations
}

export default storeAdminMenu;
