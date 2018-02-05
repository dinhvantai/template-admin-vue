<template>
    <b-row>
        <b-col lg="12">
            <b-button-group class="pull-right">
                <b-button variant="success" @click="clickAddNewItem">
                    <i class="icon-plus"></i>
                    {{ $t('textAddProduct') }}
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
                    <template slot="link" slot-scope="data">
                        {{ getLinkProduct(data.item) }}
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
    import { PRODUCT_STATUS_SHOW, PRODUCT_STATUS_HIDDEN } from '../../store/product'
    import Helper from '../../library/Helper'
import category from '../../store/category';

    export default {
        name: 'AdminProduct',
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
            Helper.changeTitleAdminPage(this.$i18n.t('textManageProduct'))
            this.$store.dispatch('callFetchProducts', { vue: this })
        },

        data() {
            return {
                fields: [
                    {key: 'id'},
                    {key: 'name', label: this.$i18n.t('textName')},
                    {key: 'link', label: this.$i18n.t('textLink')},
                    {key: 'image', label: this.$i18n.t('textImage')},
                    {key: 'price', label: this.$i18n.t('textPrice')},
                    {key: 'prioty', label: this.$i18n.t('textPrioty')},
                    {key: 'status', label: this.$i18n.t('textStatus')},
                    {key: 'action', label: this.$i18n.t('textAction')},
                ],
                currentPage: 1,
                perPage: 10
            }
        },

        methods: {
            getLinkProduct(product) {
                let slug = `/${product.slug}`
                if (product.category) {
                    slug = `/${product.category.slug}${slug}`

                    if (product.category.parent_category) {
                        slug = `/${product.category.parent_category.slug}${slug}`
                    }
                }

                return slug
            },

            clickAddNewItem() {
                return this.$router.push({ path: '/products/add' })
            },

            convertDataSubmit(params) {
                return {
                    ...params,
                    parent_id: params.parent_id ? params.parent_id : null,
                    status: params.status ? PRODUCT_STATUS_SHOW : PRODUCT_STATUS_HIDDEN
                }
            },

            clickEditItem(product) {
                return this.$router.push({ path: `/products/edit/${product.id}` })
            },

            async clickDeleteItem(id) {
                return id
                    && await this.$swal({
                        title: this.$i18n.t('textConfirmDelete'),
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    && this.$store.dispatch('callProductDelete', { vue: this, id })
            }
        },

        computed: {
            loading() {
                return this.$store.state.storeLoading.loading
            },

            items() {
                return this.$store.state.storeAdminProduct.products;

                // let categories = this.$store.state.storeAdminProduct.products

                // let itemsFilter = []

                // for (let i = 0; i < categories.length; i++) {
                //     categories[i]._rowVariant = 'success'
                //     categories[i].prefix = ''
                //     categories[i].link = `/${categories[i].slug}`
                //     itemsFilter.push(categories[i])

                //     let children = categories[i].children_categories
                //     for(let j = 0; j < children.length; j++) {
                //         children[j].prefix = '| - - '
                //         children[j].type = categories[i].type
                //         children[j].link = `${categories[i].link}/${children[j].slug}`
                //         itemsFilter.push(children[j])
                //     }
                // }
                // return itemsFilter
            },

            categoryOption() {
                let categories = this.$store.state.storeAdminProduct.categories

                return [
                    { value: '', text: '' },
                    ...categories.map(category => ({ value: category.id, text: category.name})),
                ]
            }
        },
    }
</script>
