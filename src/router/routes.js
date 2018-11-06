
const routes = [
  {
    path: '/',
    component: () => import('layouts/MyLayout.vue'),
    children: [
      {
        path: '',
        name: 'index',
        component: () => import('pages/Index.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'stat',
        name: 'stat',
        component: () => import('pages/Stat.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'infographic',
        name: 'infographic',
        component: () => import('pages/Infographic.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'infographic_list',
        name: 'infographic_list',
        component: () => import('pages/InfographicList.vue'),
        meta: {
          requiresAuth: true
        }
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('pages/Login'),
    meta: {
      requiresVisitor: true
    }
  }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
  routes.push({
    path: '*',
    component: () => import('pages/Error404.vue')
  })
}

export default routes
