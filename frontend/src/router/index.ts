import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/Register.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../views/Home.vue')
    },
    {
      path: '/profile',
      name: 'profile',
      component: () => import('../views/Profile.vue')
    },
    {
      path: '/settings',
      name: 'settings',
      component: () => import ('../views/Settings.vue')
    },
    {
      path: '/admin',
      name: 'admin',
      component: () => import ('../views/Admin.vue')
    }
  ]
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('authToken');

  if (isAuthenticated && (to.path === '/login' || to.path === '/register')) {
    next({ path: '/home' });
  }
  else if(!isAuthenticated && (to.path === '/home' || to.path === '/profile' || to.path === '/settings' || to.path === '/admin')) {
    next({ path: '/login' });
  }else {
    next();
  }
});

export default router;
