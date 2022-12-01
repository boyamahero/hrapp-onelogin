import axios from 'axios'

import * as types from './types'

export default {
  [types.SECURITY_AUTH] (state, { currentUser, userManager }) {
    state.auth = { currentUser, userManager }
    if (currentUser) {
      axios.defaults.headers.common = {
        Authorization: 'Bearer ' + currentUser.access_token
      }
    }
  }
}
