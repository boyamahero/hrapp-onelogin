
const routes = [
  {
    path: '/smartlife',
    name: 'smartlife',
    beforeEnter () { location.href = 'http://smartlife.egat.co.th' }
  },
  {
    path: '/search',
    component: () => import('layouts/MySearch.vue'),
    children: [
      {
        path: '',
        name: 'search',
        component: () => import('pages/Search.vue'),
        meta: {
          requiresAuth: true,
          title: 'HR Search',
          description: 'สอบถามข้อมูลบุคคลและหมายเลขโทรศัพท์'
        }
      }
    ]
  },
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
        path: 'portfolio',
        name: 'portfolio',
        beforeEnter () { location.href = 'https://pis.egat.co.th' },
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'salary',
        name: 'salary',
        beforeEnter () { location.href = 'https://pis.egat.co.th/psn_extra' },
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'editwl',
        name: 'editwl',
        component: () => import('pages/EditWL.vue'),
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'editwl_by_bp',
        name: 'editwl_by_bp',
        component: () => import('pages/EditWLbyBP.vue'),
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
