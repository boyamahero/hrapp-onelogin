<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue">
            <p class="header text-bold" style="color:white">แก้ไขข้อมูลสถานที่ทำงาน</p>
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
          อาคาร
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input v-model="PWAH_Building" clearable/></p>
      </q-card-main>
      </q-card>
      <q-card class="q-ma-md" v-if="SL_Floor">
        <q-select
          dense
          inverted-light
          color="white"
          float-label="ชั้น"
          v-model="PWAH_Floor"
          separator
          :options="SL_Floor"
   />
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
       <div class="col-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue">
            <p class="header text-bold" style="color:white">ผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน</p>
          </q-card-main>
        </q-card>
      </div>
      <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          ชื่อ-สกุล
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input type="text"  v-model="INTM_NAME" clearable/></p>
      </q-card-main>
      </q-card>
       <q-card class="q-ma-md q-px-xs">
       <q-card-title>
          เบอร์โทรศัพท์
        </q-card-title>
        <q-card-separator />
      <q-card-main>
        <p><q-input type="text"  v-model="INTM_TEL" clearable/></p>
      </q-card-main>
      </q-card>
         <q-card class="q-ma-md" v-if="SL_Floor">
        <q-select
          dense
          inverted-light
          color="white"
          float-label="ความสัมพันธ์"
          v-model="INTM_RELATION"
          separator
          :options="SL_RELATION"
   />
     </q-card>
      <div class="row justify-center">
      <q-btn class="q-ma-lg center" label="คืนค่าเริ่มต้น" color="warning" @click="getTempWL"/>
      <q-btn class="q-ma-lg center" label="บันทึกการปรับปรุง" color="secondary" @click="checkForm"/>
      </div>
      </div>
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
      listtempdata: [],
      WL_Province: '',
      WL_District: '',
      WL_SubDistrict: '',
      WL_Name: null,
      WL_Type: null,
      INTM_NAME: null,
      INTM_TEL: null,
      INTM_RELATION: null,
      PWAH_MobilePhoneNumber: null,
      PWAH_Building: null,
      PWAH_Floor: null,
      PWAH_PhoneNumber: null,
      PWAH_Room: null
    }
  },
  created () {
    this.getUser()
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
      if (!this.PWAH_Room) {
        this.errors.push('ไม่ได้กรอกข้อมูลห้อง')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกข้อมูลห้อง',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
       if (!this.INTM_NAME) {
        this.errors.push('ไม่ได้กรอกชื่อผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกชื่อผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
       if (!this.INTM_TEL) {
        this.errors.push('ไม่ได้กรอกเบอร์ผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกเบอร์ผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน',
              icon: 'report_problem',
              ok: 'ok'
            })
      }
       if (!this.INTM_RELATION) {
        this.errors.push('ไม่ได้กรอกความสัมพันธ์ผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน')
        this.$q.dialog({
              color: 'negative',
              message: 'ไม่ได้กรอกความสัมพันธ์ผู้ที่สามารถติดต่อได้กรณีฉุกเฉิน',
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
    getUser () {
      this.$axios.get('/user')
      .then((res) => {
        this.user = res.data
      })
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
          if (this.SL_WL_Name || this.SL_WL_Name.length > 0) {
          this.WL_Name = res.data.tempdata.ZZCODE
          } else {
              this.getWLList()
              this.WL_Name = res.data.tempdata.ZZCODE
          }
          this.getWLdetail()
          this.PWAH_MobilePhoneNumber = res.data.tempdata.ZZMOBL
          this.PWAH_Building = res.data.tempdata.ZZBLD
          this.PWAH_Floor = res.data.tempdata.ZZFL
          this.PWAH_PhoneNumber = res.data.tempdata.ZZOFTEL
          this.PWAH_Room = res.data.tempdata.ZZROMNO
          this.INTM_NAME = res.data.tempdata.INTM_NAME
          this.INTM_TEL = res.data.tempdata.INTM_TEL
          this.INTM_RELATION = res.data.tempdata.INTM_RELATION
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
      fd.append('PWAH_Floor', this.PWAH_Floor)
      fd.append('PWAH_PhoneNumber', this.PWAH_PhoneNumber)
      fd.append('PWAH_Room', this.PWAH_Room)
      fd.append('INTM_NAME', this.INTM_NAME)
      fd.append('INTM_TEL', this.INTM_TEL)
      fd.append('INTM_RELATION', this.INTM_RELATION)
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
          if (this.SL_WL_Name || this.SL_WL_Name.length > 0) {
          this.WL_Name = this.user.location.PWAH_WorkLocationCode
          } else {
            this.getWLList()
            this.WL_Name = this.user.location.PWAH_WorkLocationCode
          }
          this.getWLdetail()
          this.PWAH_MobilePhoneNumber = this.user.mobile_number
          if (this.user.location.PWAH_Building) {
          let splbld = this.user.location.PWAH_Building.split(' ชั้น ')
          this.PWAH_Building = splbld[0]
          this.PWAH_Floor = splbld[1]
          }
          // this.PWAH_Building = this.user.location.PWAH_Building
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
