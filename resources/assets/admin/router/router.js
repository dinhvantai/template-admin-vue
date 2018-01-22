import VueRouter from 'vue-router'
import { STORAGE_AUTH } from '../store/auth'
import Login from '../views/auth/Login.vue'
import Admin from '../components/Admin.vue'
import AdminMenu from '../views/menu/AdminMenu.vue'
import Chat from '../views/chat/Chat.vue'
// import Todos from '../views/todos/Todos.vue'

const router =  new VueRouter({
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            component: Admin,
            name: 'Home',
            meta: { requiresAuth: true },
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard'
                },
                {
                    path: 'menus',
                    name: 'Menus',
                    component: AdminMenu
                },
                {
                    path: 'users',
                    name: 'Manager User',
                    component: Chat
                }
            ]
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        }
        // {
        //     path: '/*',
        //     redirect: '/dashboard'
        // },
    ]

});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        const auth = JSON.parse(window.localStorage.getItem(STORAGE_AUTH)) || {};

        if (!auth || !auth.token || !auth.token.access_token) {
            return next({ path: '/login' })
        }
    }

    return next();
})

export default router;
