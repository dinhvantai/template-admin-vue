<template>
    <b-row>
        <b-col lg="12">
            <b-button-group class="pull-right">
                <b-button variant="success" @click="clickAddNewItem">
                    <i class="icon-plus"></i>
                    {{ $t('textAddPost') }}
                </b-button>
            </b-button-group>
        </b-col>
        <b-col lg="12">
            <b-card>
                <b-table
                    :hover="hover" :striped="striped"
                    :bordered="bordered" :small="small"
                    :fixed="fixed" class="table-responsive-sm"
                    :items="items"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                >
                    <template slot="category" slot-scope="data">
                        {{ getCategoryPost(data.item) }}
                    </template>
                    <template slot="link" slot-scope="data">
                        {{ getLinkPost(data.item) }}
                    </template>
                    <template slot="image" slot-scope="data">
                        <img 
                            :src="`/${data.item.image}`" 
                            :alt="data.item.name"
                            style="width: 150px"
                        />
                    </template>
                    <template slot="action" slot-scope="data">
                        <b-button
                            type="submit" size="sm"
                            variant="primary"
                            @click="clickEditItem(data.item)"
                        >
                            <i class="icon-pencil"></i>
                            {{ $t('textEdit') }}
                        </b-button>
                        <b-button
                            type="reset" size="sm"
                            variant="danger"
                            @click="clickDeleteItem(data.item.id)"
                        >
                            <i class="icon-trash"></i>
                            {{ $t('textDelete') }}
                        </b-button>
                    </template>
                </b-table>
            </b-card>            
        </b-col>
    </b-row>
</template>

<script>
    import { POST_STATUS_SHOW, POST_STATUS_HIDDEN } from '../../store/post'
    import Helper from '../../library/Helper'
    import category from '../../store/category';

    export default {
        name: 'AdminPost',
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

        beforeCreate() {
            Helper.changeTitleAdminPage(this.$i18n.t('textManagePost'))
            this.$store.dispatch('callFetchPosts', { vue: this })
        },

        data() {
            return {
                fields: [
                    {key: 'id'},
                    {key: 'name', label: this.$i18n.t('textName')},
                    {key: 'category', label: this.$i18n.t('textCategory')},
                    {key: 'link', label: this.$i18n.t('textLink')},
                    {key: 'image', label: this.$i18n.t('textImage')},
                    {key: 'prioty', label: this.$i18n.t('textPrioty')},
                    {key: 'status', label: this.$i18n.t('textStatus')},
                    {key: 'action', label: this.$i18n.t('textAction')},
                ],
                currentPage: 1,
                perPage: 10
            }
        },

        methods: {
            getCategoryPost(post) {
                let category = post.category

                return category.parent_category 
                    ? `${category.parent_category.name} / ${category.name}`
                    : category.name
            },

            getLinkPost(post) {
                return `/tin-tuc/${post.slug}`
            },

            clickAddNewItem() {
                return this.$router.push({ path: '/posts/add' })
            },

            convertDataSubmit(params) {
                return {
                    ...params,
                    parent_id: params.parent_id ? params.parent_id : null,
                    status: params.status ? POST_STATUS_SHOW : POST_STATUSostN
                }
            },

            clickEditItem(post) {
                return this.$router.push({ path: `/posts/edit/${post.id}` })
            },

            async clickDeleteItem(id) {
                return id
                    && await this.$swal({
                        title: this.$i18n.t('textConfirmDelete'),
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    && this.$store.dispatch('callPostDelete', { vue: this, id })
            }
        },

        computed: {
            loading() {
                return this.$store.state.storeLoading.loading
            },

            items() {
                return this.$store.state.storeAdminPost.posts
            }
        },
    }
</script>
