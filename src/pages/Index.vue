<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-carousel
          quick-nav
          quick-nav-icon="stop"
          >
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
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-card class="q-ma-md">
      <q-card-main>
         <p class="header">เมนู</p>
         <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/menu/menu-ess1.png" @click="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/menu/menu-infographic.png" @click="$router.push('/infographic')"></div>
          </div>
          <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/menu/menu-dashboard.png" @click="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/menu/menu-search1.png" @click="$router.push('/')"></div>
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
  }
}
</script>
