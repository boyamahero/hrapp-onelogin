import Vue from 'vue'
import VueRouter from 'vue-router'
console.log(process.env.api)
// import security from '@rockt/security-vue-keycloak'
import { UserManager } from 'oidc-client'
  const mgr = new UserManager({
  authority: process.env.SubDomain,
  client_id: process.env.ClientId,
  client_secret: process.env.ClientSecret,
  response_type: 'code',
  scope: 'openid profile',
  automaticSilentRenew: true,
  redirect_uri: window.location.origin,
  silent_redirect_uri: window.location.origin,
  post_logout_redirect_uri: window.location.origin
})

// console.log(process.env.api)

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

  const setSession = (user, next) => {
    store.dispatch('authLogin', { userManager: mgr, currentUser: user })
    next()
  }

  Router.beforeEach(async function (to, from, next) {
    if (to.meta.requiresAuth) {
      const { currentUser } = store.state.security.auth
      if (!currentUser.access_token) {
        if (window.location.href.indexOf('?') >= 0) {
          mgr
            .signinRedirectCallback()
            .then(async user => {
              // send token to login api
              setSession(user, next)
            })
            .catch(err => {
              console.log('Error completing auth code + pkce flow', err)
            })
        } else {
          try {
            const user = await mgr.getUser()
            if (user) {
              setSession(user, next)
            } else {
              // ถ้ายังไม่ได้ login ก็ส่งไปหน้า login
              mgr.signinRedirect()
            }
          } catch (errorData) {
            console.error(
              '😡 Error getUser oidc-client :',
              JSON.stringify(errorData)
            )
          }
        }
      } else {
        next()
      }
    } else {
      next()
    }
  })

  return Router
}
