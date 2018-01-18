import VueRouter from 'vue-router'
import Admin from '../components/Admin.vue'
import Chat from '../views/chat/Chat.vue'

export default new VueRouter({
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            component: Admin,
            name: 'Home',
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard'
                },
                {
                    path: 'appchat',
                    name: 'app-chat',
                    component: Chat
                }

            ]
        },
        // {
        //     path: '/*',
        //     redirect: '/dashboard'
        // },
    ]
});
