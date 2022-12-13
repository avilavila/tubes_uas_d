//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    {
        path: '/',
        name: 'beranda',
        component: () => import('@/components/DashboardLayout.vue'),
        children:[
            
        ], 
    },
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes // config routes
})

export default router;