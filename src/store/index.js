import Vue from 'vue'
import Vuex from 'vuex'

import security from './store-vue-keycloak'
import token from './token'
import user from './user'
import employee from './employee'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      security,
      token,
      user,
      employee
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: process.env.DEV
  })

  /*
    if we want some HMR magic for it, we handle
    the hot update like below. Notice we guard this
    code with "process.env.DEV" -- so this doesn't
    get into our production build (and it shouldn't).
  */

  if (process.env.DEV && module.hot) {
    module.hot.accept(['./employee'], () => {
      const Employee = require('./employee').default
      Store.hotUpdate({ modules: { employee: Employee } })
    })
  }

  return Store
}
