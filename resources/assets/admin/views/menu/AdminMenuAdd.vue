<template>
    <b-modal
        :title="$t('textAddMenu')"
        v-model="openModalValue"
        @ok="submitModalAddMenu"
        @hidden="hideModalAddMenu"
        :centered="true" size="lg"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textName')">
                                <b-form-input type="text" :placeholder="$t('textName')" v-model="formData.name" required />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPosition')">
                                <b-form-select
                                    :plain="true" required
                                    :options="optionPositionMenu"
                                    v-model="formData.position"
                                >
                                </b-form-select>
                            </b-form-fieldset>
                        </b-col>
                        <!-- <b-col sm="6">
                            <b-form-fieldset :label="$t('textParentMenu')">
                                <b-form-select
                                    :plain="true"
                                    :options="parentMenuOption"
                                    v-model.number="formData.parent_id"
                                />
                            </b-form-fieldset>
                        </b-col> -->
                    </b-row>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textLink')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textLink')"
                                    v-model="formData.path"
                                />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="number" :placeholder="$t('textPrioty')" v-model.number="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-input
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                        />
                    </b-form-fieldset>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
        <div slot="modal-footer" class="w-100 text-center">
            <b-button type="submit" size="xs" variant="primary" @click="clickAddMenu">
                <i class="fa fa-dot-circle-o"></i>
                {{ $t('textAddNew') }}
            </b-button>
            <b-button type="reset" size="xs" variant="danger" @click="hideModalAddMenu">
                <i class="fa fa-ban"></i>
                {{ $t('textCancel') }}
            </b-button>
       </div>
    </b-modal>
</template>

<script>
import { ADMIN_MENU_POSITION_OPTION } from '../../store/menus'

export default {
    name: 'AdminMenuAdd',

    props: {
        modalAdd: {
            type: Object,
            required: true
        },
        submitModalAddMenu: {
            type: Function,
            required: true
        },
        hideModalAddMenu: {
            type: Function,
            required: true
        },
        parentMenuOption: {
            type:Array,
            required: true
        }
    },

    data() {
        return {
            optionPositionMenu: ADMIN_MENU_POSITION_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            )),
            formData: {
                name: '',
                prioty: 0,
                description: '',
                path: '',
                position: ADMIN_MENU_POSITION_OPTION[0].value,
            }
        }
    },

    methods: {
        resetData() {
            return this.formData = {
                name: '',
                prioty: 0,
                description: '',
                path: '',
                position: ADMIN_MENU_POSITION_OPTION[0].value,
            }
        },

        clickAddMenu() {
            let params = this.formData

            // params.parent_id = params.parent_id ? params.parent_id : 0;

            if (!params.name || !params.path || !params.position) {
                return this.$toaster.error(this.$i18n.t('textNotFillEnough'))
            }

            this.resetData()
            return this.submitModalAddMenu(params)
        }
    },

    computed: {
        openModalValue: {
            get() {
                return this.modalAdd.open
            },
            set(val) {
            }
        }
    }
}
</script>
