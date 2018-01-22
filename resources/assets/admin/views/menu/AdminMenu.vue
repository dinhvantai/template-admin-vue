<template>
    <b-row>
        <AdminMenuAdd
            :submitModalAddMenu='submitModalAddMenu'
            :openModal="modal.open"
            :hideModalAddMenu="hideModalAddMenu"
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
            <b-card :header="$t('textMenus')" lg="12">
                <b-table
                    :hover="hover" :striped="striped"
                    :bordered="bordered" :small="small"
                    :fixed="fixed" class="table-responsive-sm"
                    :items="items" :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                >
                    <!-- <template slot="status" slot-scope="data">
                        <b-badge :variant="getBadge(data.item.status)">{{data.item.status}}</b-badge>
                    </template> -->
                </b-table>
                <nav>
                    <b-pagination
                        :total-rows="totalRows"
                        :per-page="perPage" v-model="currentPage"
                        prev-text="Prev" next-text="Next"
                        hide-goto-end-buttons
                        @change='changePage'
                    />
                </nav>
            </b-card>
        </b-col>
    </b-row>
</template>

<script>
    const DEFAULT_PER_PAGE = 10;

    import AdminMenuAdd from './AdminMenuAdd.vue'

    import Helper from '../../library/Helper'

    export default {
        name: 'AdminMenu',
        components: { AdminMenuAdd },
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
            this.$store.dispatch('callFetchMenus', this, { perPage: this.perPage, page: this.currentPage })
        },

        data() {
            return {
                fields: [
                    {key: 'id'},
                    {key: this.$i18n.t('textTitle')},
                    {key: this.$i18n.t('textDescription')},
                    {key: this.$i18n.t('textLink')},
                    {key: this.$i18n.t('textPosition')},
                    {key: this.$i18n.t('textPrioty')},
                ],
                currentPage: 1,
                perPage: DEFAULT_PER_PAGE,
                modal: {
                    open: false
                }
            }
        },

        computed: {
            items() {
                return this.$store.state.storeAdminMenu.menus
            },
            totalRows() {
                return this.$store.state.storeAdminMenu.total
            }
        },

        methods: {
            getBadge(status) {
                return status === 'Active' ? 'success'
                : status === 'Inactive' ? 'secondary'
                    : status === 'Pending' ? 'warning'
                    : status === 'Banned' ? 'danger' : 'primary'
            },

            changePage(page) {
                this.currentPage = page;
                this.$store.dispatch('callFetchMenus', { perPage: this.perPage, page: this.currentPage })
            },

            clickAddNewMenu() {
                this.modal.open = true;
            },

            submitModalAddMenu(formInput) {
                let validateForm = formInput.title && formInput.link && formInput.position

                if (validateForm) {
                    this.modal.open = false;
                }

            },

            hideModalAddMenu() {
                this.modal.open = false;
            }
        }
    }
</script>
