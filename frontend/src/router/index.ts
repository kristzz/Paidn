import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/welcome'
    },
    {
      path: '/welcome',
      name: 'welcome',
      component: () => import('../views/auth/Welcome.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/Login.vue')
    },
    {
      path: '/register',
      name: 'typeOfAcc',
      component: () => import('../views/auth/TypeOfAcc.vue')
    },
    {
      path: '/register/user',
      name: 'userRegistration',
      component: () => import('../views/auth/Register/UserRegistration.vue')
    },
    {
      path: '/register/business',
      name: 'businessRegistration',
      component: () => import('../views/auth/Register/BusinessRegistration.vue')
    },
    {
      path: '/forgotPassword',
      name: 'forgotPassword',
      component: () => import('../views/auth/ForgotPassword.vue')
    }
  ]
})

export default router
