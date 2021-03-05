<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue">
            <p class="header text-bold" style="color:white">แก้ไขข้อมูลสำหรับติดต่อสื่อสาร</p>
          </q-card-main>
        </q-card>
      </div>
    </div>
     <div class="row justify-center">
       <div class="col-xs-12 col-md-12 col-lg-12">
        <!-- <q-card class="q-ma-md q-pa-md" color="indigo" text-color="white">
          <p>โหมดแก้ไขของมูลให้บุคคลอื่น</p>
          <q-card class="q-ma-xs q-pa-xs" color="blue-1" text-color="black">
          <p>กำลังแก้ไขข้อมูลของ {{ employee.employee_name}}</p>
          </q-card>
        </q-card> -->
           <q-alert type="info" class="q-mx-md" text-color="white"> <p>กำลังแก้ไขข้อมูลของ {{ employee.employee_name}} ({{ employee.employee_code}}) </p></q-alert>
      </div>
     </div>
    <div class="row justify-center">
      <div class="col-xs-12 col-md-6 col-lg-6">
        <q-card class="q-ma-md q-px-md">
          <q-select
            float-label="ประเภทสถานที่ทำงาน"
            v-model="WL_Type"
            separator
            @input="getWLList"
            :options="SL_WL_Type"
          />
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-6">
        <q-card class="q-ma-md q-px-md" v-if="SL_WL_Name">
          <q-select
            :error="SL_WL_Name_error"
            float-label="สถานที่ทำงาน"
            v-model="WL_Name"
            separator
            ref="WL_Name"
            @input="getWLdetail"
            :options="SL_WL_Name"
          />
          </q-card>
      </div>
      <div class="col-12">
        <q-card class="q-mx-md q-px-md" v-if="WL_Province">
            {{WL_SubDistrict + ' ' + WL_District  + ' จ.' +  WL_Province}}
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4">
        <q-card class="q-ma-md q-px-md">
          <q-input float-label="ห้อง" v-model="PWAH_Room" clearable/>
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4">
        <q-card class="q-ma-md q-px-md">
          <q-input float-label="อาคาร" v-model="PWAH_Building" clearable/>
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4">
        <q-card class="q-ma-md q-px-md" v-if="SL_Floor">
          <q-select
            float-label="ชั้น"
            v-model="PWAH_Floor"
            separator
            :options="SL_Floor"
          />
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4">
        <q-card class="q-ma-md q-px-md">
          <q-card-main>
            <q-input float-label="เบอร์โทรภายใน" type="text" v-model="PWAH_PhoneNumber" clearable/>
          </q-card-main>
        </q-card>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4">
        <q-card class="q-ma-md q-px-md">
          <q-card-main>
            <q-input float-label="เบอร์โทรสำหรับบุคคลภายนอก" type="text" v-model="PWAH_PhoneNumberFull" clearable/>
          </q-card-main>
        </q-card>
      </div>
    </div>
    <div class="row justify-center">
      <q-btn class="q-ma-lg" label="คืนค่าเริ่มต้น" color="warning" @click="getTemplocation"/>
      <q-btn class="q-ma-lg" label="บันทึกการปรับปรุง" color="secondary" @click="checkForm"/>
    </div>
  </q-page>
</template>

<script>
import { QSpinnerGears } from 'quasar'
export default {
  data () {
    return {
      SL_WL_Type: [],
      SL_WL_Name: [],
      SL_WL_Name_error: false,
      SL_Floor: [
      {
          label: 'ชั้น G',
          value: 'G'
        },
        {
          label: 'ชั้น B',
          value: 'B'
        },
        {
          label: 'ชั้น 1',
          value: '1'
        },
        {
          label: 'ชั้น 2',
          value: '2'
        },
        {
          label: 'ชั้น 3',
          value: '3'
        },
        {
          label: 'ชั้น 4',
          value: '4'
        },
        {
          label: 'ชั้น 5',
          value: '5'
        },
        {
          label: 'ชั้น 6',
          value: '6'
        },
        {
          label: 'ชั้น 7',
          value: '7'
        },
        {
          label: 'ชั้น 8',
          value: '8'
        },
        {
          label: 'ชั้น 9',
          value: '9'
        },
        {
          label: 'ชั้น 10',
          value: '10'
        },
        {
          label: 'ชั้น 11',
          value: '11'
        },
        {
          label: 'ชั้น 12',
          value: '12'
        },
        {
          label: 'ชั้น 13',
          value: '13'
        },
        {
          label: 'ชั้น 14',
          value: '14'
        },
        {
          label: 'ชั้น 15',
          value: '15'
        },
        {
          label: 'ชั้น 16',
          value: '16'
        },
        {
          label: 'ชั้น 17',
          value: '17'
        },
        {
          label: 'ชั้น 18',
          value: '18'
        },
        {
          label: 'ชั้น 19',
          value: '19'
        },
        {
          label: 'ชั้น 20',
          value: '20'
        }
    ],
    SL_RELATION: [
      {
          label: 'บิดา/มารดา',
          value: 'บิดา/มารดา'
        },
        {
          label: 'พี่น้อง',
          value: 'พี่น้อง'
        },
        {
          label: 'คู่สมรส',
          value: 'คู่สมรส'
        },
        {
          label: 'บุตร',
          value: 'บุตร'
        },
        {
          label: 'ญาติ',
          value: 'ญาติ'
        },
        {
          label: 'เพื่อน',
          value: 'เพื่อน'
        }
    ],
      WL_Data: [],
      WL_Province: '',
      WL_District: '',
      WL_SubDistrict: '',
      WL_Name: null,
      WL_Type: null,
      PWAH_MobilePhoneNumber: null,
      PWAH_Building: null,
      PWAH_Floor: null,
      PWAH_PhoneNumber: null,
      PWAH_PhoneNumberFull: null,
      PWAH_Room: null,
      url_redirect: null
    }
  },
  computed: {
    user () {
      return this.$store.state.employee.employee
    },
    employee () {
      return this.$route.params
    }
  },
  created () {
    if (this.$route.params.employee_code) {
    this.createForm()
    this.getWLType()
    } else {
            window.location.assign('/search')
      }
   },
  methods: {
    createForm () {
      this.url_redirect = this.$router.history.current.query.backurl
       if (this.employee) {
        this.getTemplocation()
      }
    },
    getTemplocation () {
      this.$q.loading.show({
        spinner: QSpinnerGears,
        spinnerColor: 'yellow',
        spinnerSize: 140
      })
      let templocation
       if (this.employee.employee_templocation) {
          templocation = this.employee.employee_templocation
      } else {
         templocation = this.employee.employee_person_location
      }
      this.WL_Type = templocation.WorkLocationCode.charAt(0)
      this.getWLList()
      this.WL_Name = templocation.WorkLocationCode
      this.getWLdetail()
      this.PWAH_MobilePhoneNumber = templocation.MobilePhoneNumber
       if (templocation.Building) {
            let splbld = templocation.Building.split(' ชั้น ')
            this.PWAH_Building = splbld[0]
            this.PWAH_Floor = splbld[1]
            }
      this.PWAH_PhoneNumber = templocation.PhoneNumber
      this.PWAH_PhoneNumberFull = templocation.PhoneNumberFull
      this.PWAH_Room = templocation.Room
      this.$q.loading.hide()
    },
    getWLType () {
      this.$axios.get('getwltype')
        .then((res) => {
          this.SL_WL_Type = res.data
      }).catch(() => {
        this.$q.dialog({
          color: 'negative',
          message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          // this.$router.push({name: 'login'})
        })
      })
    },
    getWLList () {
      this.SL_WL_Name = []
      this.WL_Name = ''
      this.$axios.get('getwllist/' + this.WL_Type)
        .then((res) => {
          this.SL_WL_Name = res.data
      }).catch(() => {
        this.$q.dialog({
          color: 'negative',
          message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          // this.$router.push({name: 'login'})
        })
      })
    },
    getWLdetail () {
      this.SL_WL_Name_error = false
      this.$axios.get('getwladdress/' + this.WL_Name)
        .then((res) => {
          this.WL_Province = res.data[0].WL_Province
          this.WL_District = res.data[0].WL_District
          this.WL_SubDistrict = res.data[0].WL_SubDistrict
      }).catch(() => {
        this.$q.dialog({
          color: 'negative',
          message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          // this.$router.push({name: 'login'})
        })
      })
    },
    checkForm: function (e) {
      this.errors = []
      if (!this.PWAH_Building) {
        this.errors.push('ไม่ได้กรอกข้อมูลอาคาร')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลอาคาร',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
      if (!this.PWAH_Floor) {
        this.errors.push('ไม่ได้กรอกข้อมูลชั้น')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลชั้น',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
      if (!this.PWAH_PhoneNumber) {
        this.errors.push('ไม่ได้กรอกข้อมูลเบอร์โทร')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลเบอร์โทร',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
      if (!this.PWAH_PhoneNumberFull) {
        this.errors.push('ไม่ได้กรอกข้อมูลเบอร์โทรสำหรับบุคคลภายนอก')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลเบอร์โทรสำหรับบุคคลภายนอก',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
      if (!this.PWAH_Room) {
        this.errors.push('ไม่ได้กรอกข้อมูลห้อง')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลห้อง',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
       if (!this.WL_Name) {
        this.errors.push('ไม่ได้เลือกสถานที่ทำงาน')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้เลือกสถานที่ทำงาน',
              icon: 'report_problem',
              ok: 'ok'
            })
            this.SL_WL_Name_error = true
      }
      if (this.errors.length === 0) {
        this.$q.dialog({
          title: 'ยืนยัน',
          message: 'ยันยันการบันทึก ?',
          ok: 'ยืนยัน',
          cancel: 'ยกเลิก'
        }).then(() => {
        this.saveData()
        }).catch(() => {
          return false
        })
      }
      e.preventDefault()
    },
    saveData () {
      const fd = new FormData()
      fd.append('employee_code', this.employee.employee_code)
      fd.append('WL_Type', this.WL_Type)
      fd.append('WL_Name', this.WL_Name)
      fd.append('PWAH_Building', this.PWAH_Building)
      fd.append('PWAH_Floor', this.PWAH_Floor)
      fd.append('PWAH_PhoneNumber', this.PWAH_PhoneNumber)
      fd.append('PWAH_PhoneNumberFull', this.PWAH_PhoneNumberFull)
      fd.append('PWAH_Room', this.PWAH_Room)
      this.$axios.post('saveWlupdateByBP', fd)
        .then((res) => {
          this.$q.notify({
             message: res.data.message,
             color: 'positive',
             position: 'center',
             icon: 'done',
             timeout: 1000
            })
          if (this.url_redirect) {
            window.location.assign(this.url_redirect)
          } else {
            this.$store.dispatch('employee/setEmployee').then(window.location.assign('/'))
          }
      }).catch(() => {
        this.$q.dialog({
          color: 'negative',
          message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          // this.$router.push({name: 'login'})
        })
      })
    }
  }
}
</script>

<style>
/* .q-if-standard {
   border: 1px solid #000;
    border-radius: 5px;
    padding: 5px;
    background-color: aliceblue;
} */
</style>
