<template>
  <q-layout>
    <q-page-container>
      <q-page padding>
          <div class="full-width">
            <div class="row justify-center text-center">
              <div class="col-xs-9 col-lg-2">
             <img alt="EGAT HR Mobile Application" src="statics/egathr-logo-full.png" width="100%">
             <br><br>
            <!-- <img alt="EGAT HR Mobile Application" src="~assets/egathr-logo-full.svg"> -->
            <q-input class="login-input" v-model="username" type="number" placeholder="ชื่อผู้ใช้"/>
            <br>
            <q-input class="login-input" v-model="password" placeholder="รหัสผ่าน" color="secondary" type="password"/>
            <br>
            <q-btn color="primary" size="3vh" label="ลงชื่อเข้าใช้" :loading="loading" @click="login"/>
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
