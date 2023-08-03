import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Login from '../views/Login'
import Register from '../views/Register'
import store from '../store/main'
import Products from "../views/products/ProductList.vue";

Vue.use(VueRouter)

const routes = [
  {
    path: '/home',
    name: 'home',
    component: Home
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },
  {
    path: '/products',
    name: 'ProductList',
    component: Products
  },
  {
    path: '/products/create',
    name: 'ProductCreate',
    component: () => import('../views/products/ProductCreate.vue')
  },
  {
  path: '/products/edit/:id',
    name: 'ProductEdit',
    component: () => import('../views/products/ProductEdit.vue')
  },

{
    path: '/products',
    name: 'products',
    component: Products,
    beforeEnter: (to, from, next) => {
      if(!store.getters['auth/isAuthenticated']){
        return next({
          name: 'login'
        })
      }
      next()
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router