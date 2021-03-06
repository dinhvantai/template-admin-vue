<template>
    <b-row>
        <b-col sm="12">
            <b-row>
                <b-col lg="3"></b-col>
                <b-col lg="6" class="text-center" style="padding-bottom: 20px">
                    <b-form-input type="text" :placeholder="$t('textInputFilter')" v-model="valueFilter" />
                </b-col>
                <b-col lg="3">
                    <b-button-group class="pull-right">
                        <b-button variant="success" @click="clickAddNewItem">
                            <i class="icon-plus"></i>
                            {{ $t('textAddProduct') }}
                        </b-button>
                    </b-button-group>
                </b-col>
            </b-row>
        </b-col>
        <b-col lg="12">
            <b-card>
                <b-table
                    class="mb-0 table-outline text-center"                
                    head-variant="light"
                    :hover="true" :striped="false"
                    :bordered="true" :fixed="true" 
                    :items="filterItems"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                >
                    <template slot="status" slot-scope="data">
                        <b-button size="sm" :variant="data.item.status == 'show' ? 'success' : 'danger'">
                            {{ $t(data.item.status) }}
                        </b-button>
                    </template>
                    <template slot="category" slot-scope="data">
                        {{ getCategoryProduct(data.item) }}
                    </template>
                    <template slot="link" slot-scope="data">
                        {{ getLinkProduct(data.item) }}
                    </template>
                    <template slot="image" slot-scope="data">
                        <b-img thumbnail 
                            :src="`/${data.item.image}`" 
                            :alt="data.item.name"
                            style="width: 150px"
                            v-if="data.item.image"
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
                <nav>
                    <b-pagination 
                        :total-rows="filterItems.length" 
                        :per-page="perPage" 
                        v-model="currentPage" 
                        prev-text="< Pre" 
                        next-text="Next >" 
                        hide-goto-end-buttons
                    />
                </nav>
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

        beforeCreate() {
            Helper.changeTitleAdminPage(this.$i18n.t('textManageProduct'))
            this.$store.dispatch('callFetchProducts', { vue: this })
        },

        data() {
            return {
                fields: [
                    {key: 'id', sortable: true},
                    {key: 'name', label: this.$i18n.t('textName'), tdClass: 'text-left'},
                    {key: 'category', label: this.$i18n.t('textCategory'), tdClass: 'text-left'},
                    {key: 'link', label: this.$i18n.t('textLink'), tdClass: 'text-left'},
                    {key: 'image', label: this.$i18n.t('textImage')},
                    {key: 'price', label: this.$i18n.t('textPrice'), tdClass: 'text-left'},
                    {key: 'prioty', label: this.$i18n.t('textPrioty'), sortable: true},
                    {key: 'status', label: this.$i18n.t('textStatus')},
                    {key: 'action', label: this.$i18n.t('textAction')},
                ],
                currentPage: 1,
                perPage: 10,
                valueFilter: '',
            }
        },

        methods: {
            getCategoryProduct(product) {
                let category = product.category

                return category.parent_category 
                    ? `${category.parent_category.name} / ${category.name}`
                    : category.name
            },

            getLinkProduct(product) {
                return `/product/${product.slug}`
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

            filterItems() {
                let valueFilter = this.valueFilter.trim().toLowerCase();

                if (!valueFilter) {
                    return this.items
                }

                return this.items.filter(item => {
                    for (let i in item) {
                        if (String(item[i]).toLowerCase().indexOf(valueFilter) !== -1) return true
                    }

                    return false;
                })
            },

            items() {
                return this.$store.state.storeAdminProduct.products
            },
        },
    }
</script>
