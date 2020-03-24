import axios from 'axios'

const setEmployee = ({ commit }) => {
  return new Promise((resolve, reject) => {
    axios.get('/user')
      .then((res) => {
        commit('setEmployee', res.data)
        resolve(res)
      })
      .catch((err) => {
        reject(err)
      })
  })
}

export {
  setEmployee
}
