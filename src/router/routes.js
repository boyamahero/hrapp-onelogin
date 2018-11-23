
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
        path: 'statistic',
        name: 'statistic',
        component: () => import('pages/Statistic.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'manpower',
        name: 'manpower',
        component: () => import('pages/Manpower.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'retire',
        name: 'retire',
        component: () => import('pages/Retire.vue'),
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
      },
      {
        path: 'search',
        name: 'search',
        component: () => import('pages/Search.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'portfolio',
        name: 'portfolio',
        component: () => import('pages/Portfolio.vue'),
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
