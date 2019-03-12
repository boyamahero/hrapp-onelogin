import * as types from './types'

export default {
  authLogin ({ commit }, keycloakAuth) {
    commit('SECURITY_AUTH', keycloakAuth)
  },
  authLogout ({ commit }) {
    commit(types.SECURITY_AUTH)
  }
}
