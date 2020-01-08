<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">แก้ไขข้อมูลสถานที่ทำงาน</p>
          </q-card-main>
        </q-card>
      </div>
      <div class="col-12">
        <q-card class="q-ma-md">
           <q-select
        inverted-light
        color="white"
        float-label="ประเภทสถานที่ทำงาน"
        v-model="WL_Type"
        separator
        @input="getWLList"
        :options="SL_WL_Type"
      />
        </q-card>
        <q-card class="q-ma-md" v-if="SL_WL_Name">
           <q-select
           dense
        inverted-light
        color="white"
        float-label="สถานที่ทำงาน"
        v-model="WL_Name"
        @input="getWLdetail"
        separator
        :options="SL_WL_Name"
      />
        </q-card>
        <q-card class="q-ma-md q-px-xs" v-if="WL_Province">
       <q-card-title>
          ที่อยู่
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p>{{WL_SubDistrict + ' ' + WL_District  + ' จ.' +  WL_Province}}</p>
  </q-card-main>
</q-card>
      <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          ห้อง
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input v-model="PWAH_Room" clearable/></p>
      </q-card-main>
      </q-card>
      <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          อาคาร และ ชั้น
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input v-model="PWAH_Building" clearable/></p>
      </q-card-main>
      </q-card>
      <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          เบอร์โทร
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input type="text" v-model="PWAH_PhoneNumber" clearable/></p>
      </q-card-main>
      </q-card>
      <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          เบอร์มือถือ
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input type="text"  v-model="PWAH_MobilePhoneNumber" clearable/></p>
      </q-card-main>
      </q-card>
      <div class="row justify-center">
      <q-btn class="q-ma-lg center" label="บันทึกการปรับปรุง" color="secondary" @click="checkForm"/>
      <q-btn class="q-ma-lg center" label="คืนค่าเริ่มต้น" color="warning" @click="getTempWL"/>
      </div>
      </div>
    </div>
  </q-page>
</template>

<script>
import { mapState } from 'vuex'
import { QSpinnerGears } from 'quasar'
export default {
  data () {
    return {
      SL_WL_Type: [],
      SL_WL_Name: [],
      WL_Data: [],
      listtempdata: [],
      WL_Province: '',
      WL_District: '',
      WL_SubDistrict: '',
      WL_Name: null,
      WL_Type: null,
      PWAH_MobilePhoneNumber: null,
      PWAH_Building: null,
      PWAH_PhoneNumber: null,
      PWAH_Room: null
    }
  },
  computed: {
    ...mapState('user', ['user'])
  },
  created () {
    this.getTempWL()
    this.getWLType()
  },
  methods: {
    checkForm: function (e) {
      this.errors = []
      if (!this.PWAH_MobilePhoneNumber) {
        this.errors.push('ไม่ได้กรอกข้อมูลมือถือ')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลมือถือ',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
      if (!this.PWAH_Building) {
        this.errors.push('ไม่ได้กรอกข้อมูลอาคาร ชั้น')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลอาคาร ชั้น',
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
      if (!this.PWAH_Room) {
        this.errors.push('ไม่ได้กรอกข้อมูลห้อง')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลห้อง',
              icon: 'report_problem',
              ok: 'ok'
            })
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
    getTempWL () {
      this.$q.loading.show({
        spinner: QSpinnerGears,
        spinnerColor: 'yellow',
        spinnerSize: 140
      })
      this.$axios.get('gettempwl')
        .then((res) => {
          this.WL_Type = res.data.tempdata.type_code
          this.getWLList()
          this.WL_Name = res.data.tempdata.ZZCODE
          this.getWLdetail()
          this.PWAH_MobilePhoneNumber = res.data.tempdata.ZZMOBL
          this.PWAH_Building = res.data.tempdata.ZZFLBLD
          this.PWAH_PhoneNumber = res.data.tempdata.ZZOFTEL
          this.PWAH_Room = res.data.tempdata.ZZROMNO
          this.$q.loading.hide()
         this.listtempdata = res.data
      }).catch(() => {
    this.getWldata()
      })
    },
    saveData () {
      const fd = new FormData()
      fd.append('WL_Type', this.WL_Type)
      fd.append('WL_Name', this.WL_Name)
      fd.append('PWAH_MobilePhoneNumber', this.PWAH_MobilePhoneNumber)
      fd.append('PWAH_Building', this.PWAH_Building)
      fd.append('PWAH_PhoneNumber', this.PWAH_PhoneNumber)
      fd.append('PWAH_Room', this.PWAH_Room)
      this.$axios.post('saveWlupdate', fd)
        .then((res) => {
          this.$q.notify({
             message: res.data.message,
             color: 'positive',
             position: 'center',
             icon: 'done',
             timeout: 1000
            })
          this.getTempWL()
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
    getWldata () {
      this.$q.loading.show({
        spinner: QSpinnerGears,
        spinnerColor: 'yellow',
        spinnerSize: 140
      })
      try {
          this.WL_Type = this.user.location.PWAH_WorkLocationCode.charAt(0)
          this.getWLList()
          this.WL_Name = this.user.location.PWAH_WorkLocationCode
          this.getWLdetail()
          this.PWAH_MobilePhoneNumber = this.user.mobile_number
          this.PWAH_Building = this.user.location.PWAH_Building
          this.PWAH_PhoneNumber = this.user.location.PWAH_PhoneNumber
          this.PWAH_Room = this.user.location.PWAH_Room
          this.$q.loading.hide()
      } catch (error) {
        this.$q.loading.hide()
            this.$q.dialog({
              color: 'negative',
              message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
    }
  }
  }
</script>

<style>
.q-if-standard {
   border: 1px solid #000;
    border-radius: 5px;
    padding: 5px;
    background-color: aliceblue;
}
</style>
