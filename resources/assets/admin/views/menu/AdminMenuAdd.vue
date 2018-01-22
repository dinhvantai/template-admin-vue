<template>
    <b-modal
        :title="$t('textAddMenu')" size="lg"
        v-model="openModalValue"
        @ok="submitModalAddMenu"
        @hidden="hideModalAddMenu"
        :centered="true"
    >
        <b-row>
            <b-col sm="12">
                <b-form validated>
                    <b-row>
                        <b-col sm="8">
                            <b-form-fieldset :label="$t('textTitle')">
                                <b-form-input type="text" :placeholder="$t('textTitle')" v-model="formData.name" required />
                            </b-form-fieldset>
                        </b-col>
                        <b-col sm="4">
                            <b-form-fieldset :label="$t('textPrioty')">
                                <b-form-input type="text" :placeholder="$t('textPrioty')" v-model="formData.prioty" />
                            </b-form-fieldset>
                        </b-col>
                    </b-row>
                    <b-form-fieldset :label="$t('textDescription')">
                        <b-form-textarea
                            v-model="formData.description"
                            :placeholder="$t('textDescription')"
                            :rows="2" :max-rows="2"
                        >
                        </b-form-textarea>
                    </b-form-fieldset>
                    <b-row>
                        <b-col sm="6">
                            <b-form-fieldset :label="$t('textLink')">
                                <b-form-input
                                    type="text" required
                                    :placeholder="$t('textLink')"
                                    v-model="formData.link"
                                />
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
                    </b-row>
                </b-form>
            </b-col><!--/.col-->
        </b-row>
    </b-modal>
</template>

<script>
import { ADMIN_MENU_POSITION_OPTION } from '../../store/menus'

export default {
    name: 'AdminMenuAdd',
    props: {
        openModal: {
            type: Boolean,
            required: true,
            default: false
        },
        submitModalAddMenu: {
            type: Function,
            required: true
        },
        hideModalAddMenu: {
            type: Function,
            required: true
        }
    },

    data() {
        return {
            formData: {
                name: '',
                prioty: 0,
                description: '',
                link: '',
                position: ADMIN_MENU_POSITION_OPTION[0].value,
            },

            optionPositionMenu: ADMIN_MENU_POSITION_OPTION.map(option => (
                { value: option.value, text: this.$i18n.t(option.text) }
            ))
        }
    },

    computed: {
        openModalValue: {
            get() {
                return this.openModal
            },
            set(val) {
            }
        }
    }
}
</script>
