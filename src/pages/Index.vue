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
        <p>หมายเลขประจำตัว : {{personalData.id}}</p>
        <p>ศาสนา : {{personalData.religion_name}}</p>
        <p>สังกัด : {{personalData.org_path}}</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide >
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลการทำงาน</p>
        <q-card-separator />
        <p>วันที่เข้างาน : {{convertTHDate(personalData.entry_thai_date)}}</p>
        <p>วันที่บรรจุ : {{convertTHDate(personalData.assign_thai_date)}}</p>
        <p>อายุงาน : {{personalData.agew}}</p>
        <p>วันที่เกษียณ : {{convertTHDate(personalData.retire_thai_date)}}</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide >
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลหน่วยงาน</p>
        <q-card-separator />
        <p v-if="personalData.deputy_full !== ''">{{personalData.deputy_full}}</p>
        <p v-if="personalData.assistant_full !== ''">{{personalData.assistant_full}}</p>
        <p v-if="personalData.division_full !== ''">{{personalData.division_full}}</p>
        <p v-if="personalData.department_full !== ''">{{personalData.department_full}}</p>
        <p v-if="personalData.section_full !== ''">{{personalData.section_full}}</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide>
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลตำแหน่ง</p>
        <q-card-separator />
        <p>ตำแหน่ง : {{personalData.org_key_full}}</p>
        <p>ตำแหน่งย่อ : {{personalData.org_key}}</p>
        <p>อายุงานในตำแหน่ง : {{personalData.old_dat_age}}</p>
        <p>วันที่ได้รับตำแหน่ง : {{convertEnToTHDate(personalData.old_dat)}}</p>
      </q-card-main>
      </q-card>
      </q-carousel-slide>
      <q-carousel-slide>
        <q-card class="q-ma-xs justify-center personcard">
      <q-card-main>
        <p class="header">ข้อมูลสถานที่ทำงาน</p>
        <q-card-separator />
        <p>ตึกทำงาน : {{personalData.building}}</p>
        <p>ห้องทำงาน : {{personalData.room}}</p>
        <p>เบอร์โทร : {{personalData.phone}}</p>
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
         <div class="row text-center gutter-xs">
          <div class="col-6"><img class="full-width" src="statics/menu/menu-ess1.png" @click="$router.push('/')"></div>
          <div class="col-6"><img class="full-width" src="statics/menu/menu-infographic.png" @click="$router.push('/infographic')"></div>
          </div>
          <div class="row text-center gutter-xs">
          <div class="col-6"><img class="full-width" src="statics/menu/menu-dashboard.png" @click="$router.push('/')"></div>
          <div class="col-6"><img class="full-width" src="statics/menu/menu-search1.png" @click="$router.push('/')"></div>
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
      personalData: JSON.parse(localStorage.getItem('personalData') || '[]'),
      logoutloading: false
    }
  },
  methods: {
    convertThaiMonth (month) {
      var ThaiMonth = ''
      switch (month) {
        case '01':
          ThaiMonth = 'ม.ค.'
          break
        case '02':
          ThaiMonth = 'ก.พ.'
          break
        case '03':
          ThaiMonth = 'มี.ค.'
          break
        case '04':
          ThaiMonth = 'เม.ย.'
          break
        case '05':
          ThaiMonth = 'พ.ค.'
          break
        case '06':
          ThaiMonth = 'มิ.ย.'
          break
        case '07':
          ThaiMonth = 'ก.ค.'
          break
        case '08':
          ThaiMonth = 'ส.ค.'
          break
        case '09':
          ThaiMonth = 'ก.ย.'
          break
        case '10':
          ThaiMonth = 'ต.ค.'
          break
        case '11':
          ThaiMonth = 'พ.ย.'
          break
        case '12':
          ThaiMonth = 'ธ.ค.'
          break
      }
      return ThaiMonth
    },
    convertTHDate (date) {
      var mm = (date || '').split('.')
      return parseInt(mm[0]) + ' ' + this.convertThaiMonth(mm[1]) + ' ' + mm[2]
    },
    convertEnToTHDate (date) {
      var mm = (date || '').split('.')
      return parseInt(mm[0]) + ' ' + this.convertThaiMonth(mm[1]) + ' ' + (parseInt(mm[2]) + 543)
    }
  }
}
</script>
