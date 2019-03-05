import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '@rockt/vue-keycloak'
import security from '@rockt/vue-keycloak/security'

import routes from './routes'

document.addEventListener('backbutton', function (evt) {
  if (window.location.hash !== '#/login') {
      window.history.back()
  } else {
      navigator.app.exitApp()
  }
}, false)

Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation
 */

export default function () {
  const Router = new VueRouter({
    scrollBehavior: () => ({ y: 0 }),
    routes,

    // Leave these as is and change from quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    mode: process.env.VUE_ROUTER_MODE,
    base: process.env.VUE_ROUTER_BASE
  })

  Router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
      const auth = store.state.security.auth
      if (!auth.authenticated) {
        security.init(next, to.meta.roles)
      } else {
        if (to.meta.roles) {
          if (security.roles(to.meta.roles[0])) {
            next()
          } else {
            next({ name: 'unauthorized' })
          }
        } else {
          next()
        }
      }
    } else {
      next()
    }
  })

  return Router
}
