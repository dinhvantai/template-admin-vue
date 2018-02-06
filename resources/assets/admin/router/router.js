import VueRouter from 'vue-router'
import { STORAGE_AUTH } from '../store/auth'
import Login from '../views/auth/Login.vue'
import Admin from '../components/Admin.vue'
import Dashboard from '../views/dashboard/Dashboard.vue'
import AdminMenu from '../views/menu/AdminMenu.vue'
import AdminCategory from '../views/category/AdminCategory.vue'

import AdminProduct from '../views/product/AdminProduct.vue'
import AdminProductAdd from '../views/product/AdminProductAdd.vue'
import AdminProductEdit from '../views/product/AdminProductEdit.vue'

import AdminPost from '../views/post/AdminPost.vue'
import AdminPostAdd from '../views/post/AdminPostAdd.vue'
import AdminPostEdit from '../views/post/AdminPostEdit.vue'

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
                    name: 'Dashboard',
                    component: Dashboard
                },
                {
                    path: 'menus',
                    name: 'Menus',
                    component: AdminMenu
                },
                {
                    path: 'categories',
                    name: 'Categories',
                    component: AdminCategory
                },
                {
                    name: 'Products',
                    path: '/',
                    redirect: 'products',
                    component: {
                        render(c) { 
                            return c('router-view')
                        }
                    },
                    children: [
                        {
                            path: 'products',
                            name: 'List Product',
                            component: AdminProduct
                        },
                        {
                            path: 'products/add',
                            name: 'Add Product',
                            component: AdminProductAdd
                        },
                        {
                            path: 'products/edit/:id',
                            name: 'Edit Product',
                            component: AdminProductEdit
                        }
                    ]
                },
                {
                    name: 'Posts',
                    path: '/',
                    redirect: 'posts',
                    component: {
                        render(c) { 
                            return c('router-view')
                        }
                    },
                    children: [
                        {
                            path: 'posts',
                            name: 'List Post',
                            component: AdminPost
                        },
                        {
                            path: 'posts/add',
                            name: 'Add Post',
                            component: AdminPostAdd
                        },
                        {
                            path: 'posts/edit/:id',
                            name: 'Edit Post',
                            component: AdminPostEdit
                        }
                    ]
                },
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
