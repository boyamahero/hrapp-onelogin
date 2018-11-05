import axios from 'axios'
axios.defaults.baseURL = process.env.api
export default {
  state: {
    token: localStorage.getItem('access_token') || null
  },
  getters: {
    loggedIn (state) {
      return state.token !== null
    }
  },
  mutations: {
    retrieveToken (state, token) {
      state.token = token
    },
    destroyToken (state) {
      state.token = null
    }
  },
  actions: {
    destroyToken (context) {
      if (context.getters.loggedIn) {
        return new Promise((resolve, reject) => {
          axios.post('/logout')
            .then(response => {
              localStorage.removeItem('access_token')
              context.commit('destroyToken')
              resolve(response)
            })
            .catch(error => {
              localStorage.removeItem('access_token')
              context.commit('destroyToken')
              reject(error)
            })
        })
      }
    },
    retrieveToken (context, credentials) {
      return new Promise((resolve, reject) => {
        axios.post('/login', {
          username: credentials.username,
          password: credentials.password
        })
          .then(response => {
            const token = response.data.access_token
            localStorage.setItem('access_token', token)
            context.commit('retrieveToken', token)
            setAxiosHeaders(token)
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    }
  }
}
function setAxiosHeaders (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}
