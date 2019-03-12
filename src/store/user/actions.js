import axios from 'axios'
// axios.defaults.baseURL = process.env.api
// const token = localStorage.getItem('access_token')
// if (token) {
//   axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
// }
const setUser = ({ commit }) => {
  return new Promise((resolve, reject) => {
    axios.get('/user')
      .then((res) => {
        commit('SET_USER', res.data)
        // if (res.headers.authorization) {
        //   axios.defaults.headers.common['Authorization'] = res.headers.authorization
        //   localStorage.setItem('access_token', (res.headers.authorization).replace('Bearer ', ''))
        //   commit('retrieveToken', (res.headers.authorization).replace('Bearer ', ''), { root: true })
        // }
        resolve(res)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

export {
  setUser
}
