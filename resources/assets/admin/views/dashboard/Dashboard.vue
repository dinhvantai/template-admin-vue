<template>
</template>

<script>
import Helper from '../../library/Helper'

export default {
    name: 'Dashboard',

    beforeCreate() {
        Helper.changeTitleAdminPage(this.$i18n.t('textDashboard'))
    },
}
</script>
