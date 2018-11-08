import axios from 'axios'
axios.defaults.baseURL = process.env.api
const token = localStorage.getItem('access_token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}
const setUser = ({ commit }) => {
  return new Promise((resolve, reject) => {
    axios.get('/user')
      .then((res) => {
        commit('SET_USER', res.data)
      })
      .catch((err) => {
        console.error(err)
      })
  })
}

export {
  setUser
}
