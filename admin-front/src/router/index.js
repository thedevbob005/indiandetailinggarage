// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '',
        name: 'Home',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "home" */ '@/views/Login.vue'),
      },
    ],
  },
  {
    path: '/dashboard',
    component: () => import('@/layouts/default/App.vue'),
    children: [
      {
        path: '',
        name: 'DashboardHome',
        component: () => import(/* webpackChunkName: "dashboard" */ '@/views/Dashboard.vue'),
      },
    ],
  },
  {
    path: '/website',
    component: () => import('@/layouts/default/App.vue'),
    children: [
      {
        path: 'blogs',
        name: 'Blogs',
        component: () => import(/* webpackChunkName: "blog" */ '@/views/Blog.vue'),
      },
      {
        path: 'blogs/new',
        name: 'NewBlog',
        component: () => import(/* webpackChunkName: "newblog" */ '@/views/NewBlog.vue'),
      },
    ],
  },
  {
    path: '/ecommerce',
    component: () => import('@/layouts/default/App.vue'),
    children: [
      {
        path: 'clients',
        name: 'Clients',
        component: () => import(/* webpackChunkName: "clients" */ '@/views/WorkClients.vue'),
      },
      {
        path: 'products',
        name: 'Products',
        component: () => import(/* webpackChunkName: "products" */ '@/views/WorkProducts.vue'),
      },
      {
        path: 'products/new',
        name: 'NewProduct',
        component: () => import(/* webpackChunkName: "newproduct" */ '@/views/NewProduct.vue'),
      },
      {
        path: 'orders',
        name: 'Orders',
        component: () => import(/* webpackChunkName: "orders" */ '@/views/WorkOrders.vue'),
      },
      {
        path: 'clients/history',
        name: 'OrderHistory',
        component: () => import(/* webpackChunkName: "orderhistory" */ '@/views/OrderHistory.vue'),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
