<template>
    <b-nav-item-dropdown right no-caret>
        <template slot="button-content">
            <img src="static/img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">
        </template>
        <b-dropdown-item @click="logout">
            <i class="fa fa-lock"></i>
            {{ $t('textLogout') }}
        </b-dropdown-item>
    </b-nav-item-dropdown>
</template>
<script>
import loading from 'vue-full-loading'
import { STORAGE_AUTH } from '../../store/auth'

export default {
    name: 'header-dropdown',
    components: { loading },

    methods: {
        logout() {
            this.$swal({
                title: this.$i18n.t('confirmLogout'),
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    let resetAuth = () => {
                        let defaultAuth = JSON.stringify({ user: {}, token: {} })
                        localStorage.setItem(STORAGE_AUTH, defaultAuth)

                        return this.$router.push({ path: '/login' })
                    }

                    axios.post('/logout')
                    .then(() => {
                        return resetAuth()
                    })
                    .catch(() => {
                        return resetAuth()
                    })

                }
            });
        }
    }
}
</script>
