<template>
    <div class="app flex-row align-items-center">

        <loading :show="loading.show" />

        <div class="container">
            <b-row class="justify-content-center">
                <b-col md="6">
                    <b-card-group>
                        <b-card no-body class="p-4">
                            <b-card-body>
                                <h1>{{ $t('textLogin') }}</h1>
                                <p class="text-muted">{{ $t('textSignToAccount') }}</p>
                                <div class="text-right text-danger">{{ errors.email }}</div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                    <input
                                        type="email" class="form-control" placeholder="Email"
                                        v-model="loginForm.email"
                                    />
                                </div>
                                <div class="text-right text-danger">{{ errors.password }}</div>
                                <div class="input-group mb-4">
                                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                                    <input
                                        type="password" class="form-control" placeholder="Password"
                                        v-model="loginForm.password"
                                    />
                                    <div></div>
                                </div>
                                <b-row>
                                    <b-col cols="6">
                                        <b-button variant="primary" class="px-4" @click="submitLogin">
                                            {{ $t('textLogin') }}
                                        </b-button>
                                    </b-col>
                                    <b-col cols="6" class="text-right">
                                        <b-button variant="link" class="px-0">{{ $t('textForgotPassword') }}</b-button>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </b-card-group>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
import { STORAGE_AUTH, PERMISSION_ADMIN } from '../../store/auth'
import loading from 'vue-full-loading'

export default {
    name: 'Login',
    components: { loading },

    beforeMount() {
        let checkAuthAdmin = auth => {
            return auth
                && auth.user && auth.user.is_active
                && auth.user.permission == PERMISSION_ADMIN
                && auth.token && auth.token.access_token
        }

        let auth = JSON.parse(localStorage.getItem(STORAGE_AUTH)) || { user: {}, token: {} };

        if (checkAuthAdmin(auth)) {
            return this.$router.push({ path: '/dashboard' })
        }
    },

    data() {
        return {
            loginForm: {
                email: '',
                password: ''
            },
            loading: {
                show: false
            },
            errors: {
                email: '',
                password: ''
            }
        }
    },

    methods: {
        submitLogin() {
            this.loading.show = true;

            axios.post('/login', this.loginForm)
            .then( response => {
                localStorage.setItem(STORAGE_AUTH, JSON.stringify(response.data))

                let token = response.data.token;
                axios.defaults.headers.common['Authorization'] = `${token.token_type} ${token.access_token}`;

                this.$toaster.success(this.$i18n.t('textLoginAdminSuccess'))
                this.loading.show = false;

                return this.$router.push({ path: '/dashboard' })
            })
            .catch((error) => {
                this.loading.show = false;

                let errors = error.response.data.errors
                this.errors.email = errors.email;
                this.errors.password = errors.password;

                return this.$toaster.error(errors.message)
            })
        }
    }
}
</script>
