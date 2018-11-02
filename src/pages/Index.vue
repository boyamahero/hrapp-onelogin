<template>
  <q-page>
    <div class="row item-center">
      <div class="col">
          <q-carousel
          quick-nav
          quick-nav-icon="stop">
      <q-carousel-slide>
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลส่วนบุคคล</p>
        <q-card-separator />
        <p>หมายเลขประจำตัว : 594073</p>
        <p>ตำแหน่ง : พช.4</p>
        <p>สังกัด : รวห. อจส. กทห-ห. หพอ-ห.</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide >
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลเงินเดือน</p>
        <q-card-separator />
        <p>เงินเดือน : 12,500</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide>
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลการทำงาน</p>
        <q-card-separator />
        <p>วันที่เริ่มงาน : 1 กันยายน 2557</p>
        <p>วันที่เกษียณอายุ : 1 ตุลาคม 2593</p>
        <p>อายุงาน : 4 ปี 5 เดือน</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
    </q-carousel>
      </div>
    </div>
        <div class="row item-center">
      <div class="col">
        <q-card class="q-ma-md justify-center">
      <q-card-main>
         <p class="header">เมนู</p>
        <div class="row text-center">
          <div class="col-6"><img src="statics/menu/menu1.png"></div>
          <div class="col-6"><img src="statics/menu/menu2.png"></div>
        </div>
        <div class="row text-center">
          <div class="col-6"><img src="statics/menu/menu3.png"></div>
          <div class="col-6"><img src="statics/menu/menu4.png"></div>
        </div>
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
