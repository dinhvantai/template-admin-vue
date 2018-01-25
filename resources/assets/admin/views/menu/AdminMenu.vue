<template>
    <b-row>
        <AdminMenuAdd
            :submitModalAddMenu='submitModalAddMenu'
            :modalAdd="modalAdd"
            :hideModalAddMenu="hideModalAddMenu"
            :parentMenuOption="parentMenuOption"
        />
        <AdminMenuEdit
            :submitModalEditMenu='submitModalEditMenu'
            :modalEdit.sync="modalEdit"
            :hideModalEditMenu="hideModalEditMenu"
            :parentMenuOption="parentMenuOption"
        />
        <b-col lg="12">
            <b-button-group class="pull-right">
                <b-button variant="success" @click="clickAddNewMenu">
                    <i class="icon-plus"></i>
                    {{ $t('textAddMenu') }}
                </b-button>
            </b-button-group>
        </b-col>
        <b-col lg="12">
            <b-tabs pills card>
                <b-tab :title="$t(option.text)" v-for="option in optionPosition" :key="option.value">
                    <b-table
                        :hover="hover" :striped="striped"
                        :bordered="bordered" :small="small"
                        :fixed="fixed" class="table-responsive-sm"
                        :items="getItemFilter(option.value)"
                        :fields="fields"
                        :current-page="currentPage"
                        :per-page="perPage"
                    >
                        <template slot="position" slot-scope="data">
                            {{ getTextPosition(data) }}
                        </template>
                        <template slot="action" slot-scope="data">
                            <b-button
                                type="submit" size="sm"
                                variant="primary"
                                @click="clickEditMenu(data.item)"
                            >
                                <i class="icon-pencil"></i>
                                {{ $t('textEdit') }}
                            </b-button>
                            <b-button
                                type="reset" size="sm"
                                variant="danger"
                                @click="clickDeleteMenu(data.item.id)"
                            >
                                <i class="icon-trash"></i>
                                {{ $t('textDelete') }}
                            </b-button>
                        </template>
                    </b-table>
                </b-tab>
            </b-tabs>
        </b-col>
    </b-row>
</template>

<script>
    import AdminMenuAdd from './AdminMenuAdd.vue'
    import AdminMenuEdit from './AdminMenuEdit.vue'

    import { ADMIN_MENU_POSITION_OPTION } from '../../store/menus'
    import Helper from '../../library/Helper'

    export default {
        name: 'AdminMenu',
        components: { AdminMenuAdd, AdminMenuEdit },
        props: {
            hover: {
                type: Boolean,
                default: false
            },
            striped: {
                type: Boolean,
                default: false
            },
            bordered: {
                type: Boolean,
                default: false
            },
            small: {
                type: Boolean,
                default: false
            },
            fixed: {
                type: Boolean,
                default: false
            },
        },

        beforeMount() {
            this.$store.dispatch('callFetchMenus', { vue: this })
        },

        data() {
            return {
                fields: [
                    // {key: 'id'},
                    {key: 'name', label: this.$i18n.t('textName')},
                    // {key: 'description'},
                    {key: 'path', label: this.$i18n.t('textLink')},
                    {key: 'position', label: this.$i18n.t('textPosition')},
                    {key: 'prioty', label: this.$i18n.t('textPrioty')},
                    {key: 'action', label: this.$i18n.t('textAction')},
                ],
                currentPage: 1,
                perPage: this.totalRows,
                optionPosition: ADMIN_MENU_POSITION_OPTION
            }
        },

        methods: {
            getTextPosition(item) {
                let index = _.findIndex(ADMIN_MENU_POSITION_OPTION, (option) => option.value === item.item.position)

                return this.$i18n.t(ADMIN_MENU_POSITION_OPTION[index].text)
            },

            filterData(item) {
                let result = {}
                let fields = this.fields
                for(let i = 0; i < fields.length; i++) {
                    result[fields[i].key] = item[fields[i].key]
                }

                return result;
            },

            getItemFilter(position) {
                return this.items.filter(item => item.position == position)
            },

            clickAddNewMenu() {
                let modalAdd = { ...this.modalAdd, open: true }

                return this.$store.dispatch('setMenuModalAdd', { vue: this, modalAdd })
            },

            submitModalAddMenu(params) {
                //  params.parent_id = params.parent_id ? params.parent_id : 0;

                if (!params.name || !params.path || !params.position) {
                    return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
                }

                return this.$store.dispatch('callMenuAdd', { vue: this, params })
            },

            hideModalAddMenu(formData) {
                let modalAdd = { ...this.modalAdd, open: false }

                return this.$store.dispatch('setMenuModalAdd', { vue: this, modalAdd })
            },

            clickEditMenu(formData) {
                let modalEdit = { ...this.modalEdit, open: true, formData }

                return this.$store.dispatch('setMenuModalEdit', { vue: this, modalEdit })
            },

            submitModalEditMenu(id, params) {
                return this.$store.dispatch('callMenuEdit', { vue: this, params, id })
            },

            hideModalEditMenu() {
                let modalEdit = { ...this.modalEdit, open: false };

                return this.$store.dispatch('setMenuModalEdit', { vue: this, modalEdit })
            },

            async clickDeleteMenu(id) {
                if (id) {
                    let willDelete = await this.$swal({
                        title: this.$i18n.t('textConfirmDelete'),
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })

                    return willDelete
                        && this.$store.dispatch('callMenuDelete', { vue: this, id })
                }
            }
        },

        computed: {
            loading() {
                return this.$store.state.storeLoading.loading
            },

            items() {
                return this.$store.state.storeAdminMenu.menus

                // let menus = this.$store.state.storeAdminMenu.menus
                // let itemsFilter = []

                // for (let i = 0; i < menus.length; i++) {
                //     menus[i]._rowVariant = 'success'
                //     menus[i].prefix = ''
                //     itemsFilter.push(menus[i])

                //     let childrenMenus = menus[i].children_menus
                //     for(let j = 0; j < childrenMenus.length; j++) {
                //         childrenMenus[j].prefix = '| - - '
                //         childrenMenus[j].position = menus[i].position
                //         itemsFilter.push(childrenMenus[j])
                //     }
                // }
                // return itemsFilter
            },

            parentMenuOption() {
                let menus = this.$store.state.storeAdminMenu.menus

                return [
                    { value: '', text: '' },
                    ...menus.map(menu => ({ value: menu.id, text: menu.name})),
                ]
            },

            modalAdd() {
                return this.$store.state.storeAdminMenu.modalAdd
            },

            modalEdit() {
                return this.$store.state.storeAdminMenu.modalEdit
            },

            totalRows() {
                return this.items.length
            }
        },
    }
</script>
