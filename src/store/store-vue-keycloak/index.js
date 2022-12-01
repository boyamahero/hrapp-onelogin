import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  auth: {
    currentUser: {
      access_token: null
    },
    userManager: null
  }
}

export default {
  state,
  actions,
  getters,
  mutations
}
