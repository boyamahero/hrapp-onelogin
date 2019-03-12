import Vue from 'vue'
import VueRouter from 'vue-router'

// import security from '@rockt/security-vue-keycloak'
import Keycloak from 'keycloak-js'
let keycloakAuth = new Keycloak('/statics/keycloak.json')
// console.log(keycloakAuth)

import routes from './routes'

Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation
 */

export default function ({ store }) {
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
        keycloakAuth.init({ onLoad: 'login-required' }).success(function (authenticated) {
          if (!authenticated) {
            window.location.reload()
          }
          // alert(authenticated ? 'authenticated' : 'not authenticated')
          store.dispatch('authLogin', keycloakAuth)
          next()
          setInterval(function () {
            keycloakAuth.updateToken(70)
              .success((refreshed) => {
                if (refreshed) {
                  store.dispatch('authLogin', keycloakAuth)
                } else {
                  console.log('Token not refreshed, valid for ' + Math.round(keycloakAuth.tokenParsed.exp + keycloakAuth.timeSkew - new Date().getTime() / 1000) + ' seconds')
                }
            })
          }, 60000)
        }).error(function () {
          alert('failed to login')
        })
      } else {
        next()
      }
    } else {
      next()
    }
  })

  return Router
}
