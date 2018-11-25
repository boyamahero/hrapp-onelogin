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
                <p class="header">ประวัติย่อ</p>
                <q-card-separator />
                <p>ประเภทผู้ปฏิบัติงาน : {{user.employee_group_name}}</p>
                <p>หมายเลขประจำตัว : {{user.id}}</p>
                <p>ตำแหน่ง : {{user.position_abb}}</p>
                <p>สังกัด : {{user.org_path}}</p>
              </q-card-main>
            </q-card>
          </q-carousel-slide>
          <q-carousel-slide>
            <q-card class="q-ma-xs justify-center personcard">
              <q-card-main>
                <p class="header">ข้อมูลตำแหน่งปัจจุบัน</p>
                <q-card-separator />
                <p>วันที่เปลี่ยนตำแหน่ง : {{convertTHDate(user.position_thai_date)}}</p>
                <p>อายุงานในตำแหน่ง : {{user.position_age}}</p>
                <p>วันที่เลื่อนระดับ : {{convertEnToTHDate(user.old_dat)}}</p>
                <p>อายุงานในระดับ : {{user.old_dat_age}}</p>
              </q-card-main>
            </q-card>
          </q-carousel-slide>
          <q-carousel-slide>
            <q-card class="q-ma-xs justify-center personcard">
              <q-card-main>
                <p class="header">ข้อมูลสังกัดปัจจุบัน</p>
                <q-card-separator />
                <p v-if="user.deputy_full">{{user.deputy_full + ' (' + user.deputy_abb + ')'}}</p>
                <p v-if="user.assistant_full">{{user.assistant_full + ' (' + user.assistant_abb + ')'}}</p>
                <p v-if="user.division_full">{{user.division_full + ' (' + user.division_abb + ')'}}</p>
                <p v-if="user.department_full">{{user.department_full + ' (' + user.department_abb + ')'}}</p>
                <p v-if="user.section_full">{{user.section_full + ' (' + user.section_abb + ')'}}</p>
              </q-card-main>
            </q-card>
          </q-carousel-slide>
          <q-carousel-slide >
            <q-card class="q-ma-xs justify-center personcard">
              <q-card-main>
                <p class="header">ข้อมูลการทำงาน</p>
                <q-card-separator />
                <p>วันเข้าทำงาน : {{convertTHDate(user.entry_thai_date)}}</p>
                <p>อายุงาน กฟผ. : {{user.agew}}</p>
                <p>วันบรรจุ : {{convertTHDate(user.assign_thai_date)}}</p>
                <p>{{ (user.employee_group !== "1" && user.employee_group !== "2") ?'วันที่สิ้นสุดสัญญา':'วันเกษียณ' }} : {{convertTHDate(user.retire_thai_date)}}</p>
                <p>อายุงานคงเหลือ: {{user.remain_work_age}}</p>
              </q-card-main>
            </q-card>
          </q-carousel-slide>
          <q-carousel-slide>
            <q-card class="q-ma-xs justify-center personcard">
              <q-card-main>
                <p class="header">ข้อมูลสถานที่ทำงาน</p>
                <q-card-separator />
                <p>อาคาร : {{user.building}}</p>
                <p>ห้อง : {{user.room}}</p>
                <p>เบอร์โทร : {{user.phone}}</p>
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
         <div class="row gutter-xs">
          <div class="col-lg-2 col-md-3 col-xs-6"><img class="full-width" src="statics/menu/menu-ess1.png" @click="$router.push('/portfolio')"></div>
          <div class="col-lg-2 col-md-3 col-xs-6"><img class="full-width" src="statics/menu/menu-infographic.png" @click="$router.push('/infographic')"></div>
          <div class="col-lg-2 col-md-3 col-xs-6"><img class="full-width" src="statics/menu/menu-dashboard.png" @click="$router.push('/statistic')"></div>
          <div class="col-lg-2 col-md-3 col-xs-6"><img class="full-width" src="statics/menu/menu-search1.png" @click="$router.push('/search')"></div>
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
import { mapState } from 'vuex'
export default {
  name: 'PageIndex',
  data () {
    return {
    }
  },
  computed: {
    ...mapState('user', ['user'])
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
