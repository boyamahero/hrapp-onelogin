import * as types from './types'

export default {
  authLogin: ({ commit }, { userManager, currentUser }) => {
    commit('SECURITY_AUTH', { userManager, currentUser })
  },
  authLogout: ({ commit }) => {
    commit(types.SECURITY_AUTH, { userManager: null, currentUser: null })
  }
}
