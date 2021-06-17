import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './pages/Home.vue';
import List from './pages/List.vue';
import EmailVerify from './pages/EmailVerify.vue';
import NotFound from './pages/NotFound.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/add-list',
            name: 'list',
            component: List
        },
        {
            path: '/email/verify/:any',
            name: 'email_verify',
            component: EmailVerify
        },
        {
            path: '*',
            name: '',
            component: NotFound
        }
    ]
});

export default router;