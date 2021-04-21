import { createRouter, createWebHistory } from 'vue-router'
import store from '../store'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import User from '../views/User.vue'
import error404 from '../views/404.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: {
      auth: true
    }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '/user',
    name: 'User',
    component: User,
    meta: {
      auth: true
    }
  },
  {
    path: '/404',
    name: 'Not found',
    component: error404
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

// redirect login
router.beforeEach((to, from, next) => {
  // redirect if route not found
  if (!to.matched.length) {
    next('/404')
  }

  if (to.matched.some(record => record.meta.auth)) {
    if (!localStorage.getItem('auth')) {
      next('/login')
    } else {
      next()
    }
  } else {
    if (localStorage.getItem('auth') && (to.name == 'Login' || to.name == 'Register')) {
      next('/')
    } else {
      next()
    }
  }
})

export default router
