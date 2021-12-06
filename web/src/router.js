
import * as VueRouter from 'vue-router'

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(),
    routes: [
        {
        path: '/',
        name: 'Characters',
        component: () => import('./pages/Characters.vue')
        },
        {
        path: '/character/:id',
        name: 'Character',
        component: () => import('./pages/Character.vue')
        }
      ]
})

export default router;