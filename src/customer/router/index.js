import Vue from 'vue'
import Router from 'vue-router'

// Containers
import Full from '@/containers/Full'

// Views
import Home from '@/views/Home'
import Engineered_fasteners from '@/views/Engineered_fasteners'

Vue.use(Router)

export default new Router({
    mode: 'hash',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            redirect: '/home',
            name: 'Customer',
            component: Full,
            children: [
                {
                    path: 'home',
                    name: 'Home',
                    component: Home
                },
                {
                    path: 'engineered_fasteners',
                    name: 'Engineered_fasteners',
                    component: Engineered_fasteners
                }

            ]
        }
    ]
})
