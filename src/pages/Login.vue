<template>
  <q-layout>
    <q-page-container>
      <q-page padding>
        <div class="flex flex-center">
          <div class="full-width" style="max-width: 90vw;">
            <img alt="EGAT HR Mobile Application" src="~assets/egathr-logo-full.svg">
            <q-input v-model="username" type="number" float-label="Username" color="secondary"/>
            <br>
            <q-input v-model="password" float-label="Password" color="secondary" type="password" />
            <br>
            <q-btn color="warning" size="3vh" label="Login" class="full-width" :loading="loading" @click="login"/>
            <br>
            <br>
            <q-alert
              v-if="showAlert"
              color="negative"
              icon="warning"
              :actions="[{ label: 'x', handler: () => { showAlert = false } }]"
              class="q-mb-sm"
              >
              {{ error }}
            </q-alert>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { QInput, QAlert } from 'quasar'

export default {
  name: 'login',
  components: {
    QInput,
    QAlert
  },
  data () {
    return {
      username: '',
      password: '',
      showAlert: false,
      error: '',
      loading: false
    }
  },
  methods: {
    login () {
      this.loading = true
      this.$store.dispatch('retrieveToken', {
        username: this.username,
        password: this.password
      })
        .then(response => {
          this.loading = false
          this.$router.push({name: 'index'})
        })
        .catch(e => {
          console.log(e.message)
          this.loading = false
          if (e.message === 'Request failed with status code 401') {
            this.showAlert = true
            this.error = 'ยืนยันตนไม่ผ่าน รหัสผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง'
          }
          if (e.message === 'Request failed with status code 500') {
            this.showAlert = true
            this.error = 'เครื่องแม่ข่ายเว็ปไซต์มีปัญหา'
          }
          if (e.message === 'Network Error') {
            this.showAlert = true
            this.error = 'เครื่องแม่ข่ายมีปัญหา'
          }
        })
    }
  }
}
</script>

<style>
</style>
