<template>
  <q-page>
    <div class="row justify-center">
      <q-breadcrumbs>
  <q-breadcrumbs-el label="หน้าหลัก" icon="home" @click.native="$router.push('/')"/>
  <q-breadcrumbs-el label="ข้อมูลที่เป็นประโยชน์ด้านบุคคล" />
</q-breadcrumbs>
      <div class="col-md-9 col-xs-12">
      <q-card class="q-ma-md">
      <q-card-main>
         <p class="header">ข้อมูลที่เป็นประโยชน์ด้านบุคคล</p>
         <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/modules1.png" @click.native="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/modules2.png" @click.native="$router.push('/infographic')"></div>
          </div>
          <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/modules3.png" @click.native="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/modules4.png" @click.native="$router.push('/')"></div>
         </div>
              <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/modules5.png" @click.native="$router.push('/')"></div>
         </div>
        <!-- <div class="row text-center menupic">
          <div class="col-6"><img src="statics/menu/menu1.png"></div>
          <div class="col-6"><img src="statics/menu/menu2.png"></div>
        </div>
        <div class="row text-center menupic">
          <div class="col-6"><img src="statics/menu/menu3.png"></div>
          <div class="col-6"><img src="statics/menu/menu4.png"></div>
        </div> -->
      </q-card-main>
    </q-card>
    </div>
     </div>
  </q-page>
</template>

<style>
</style>

<script>
export default {
  name: 'PageIndex',
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false
    }
  },
  methods: {
    async makeRequest () {
      let response
      let color = 'negative'
      this.loading = true

      try {
        response = ''
        let req = await fetch(process.env.api + '/test')

        if (!req.ok) throw new Error('error request')

        let {data} = await req.json()
        response = data
        color = 'positive'
      } catch (err) {
        console.log(err)
        response = err.message
      }

      setTimeout(() => {
        this.response = response
        this.color = color
        this.loading = false
      }, 700)
    },
    logout () {
      this.logoutloading = true
      this.$store.dispatch('destroyToken')
        .then(response => {
          this.logoutloading = false
          this.$router.push({name: 'login'})
        })
        .catch(e => {
          this.logoutloading = false
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
