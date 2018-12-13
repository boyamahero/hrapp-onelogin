<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">เงินช่วยเหลือค่ารักษาพยาบาลของโรงพยาบาลและคลินิกเอกชน (3,600)</p>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main>
            <q-select
                v-model="select"
                stack-label="ปีงบประมาณ"
                separator
                radio
                :options="selectOptions"
                @input="getDataAll"
              />
          </q-card-main>
        </q-card>
      </div>
      <div class="col-md-9 col-xs-12">
        <div class="row q-ma-md q-px-lg">
          <div class="col-6 bg-light-blue-4 q-pa-xs text-white">สิทธิรวมทั้งปี</div>
          <div class="col-6 text-right q-pa-xs shadow-1">3,600.00 บาท</div>
        </div>
        <div class="row q-ma-md q-px-lg">
          <div class="col-6 bg-light-blue-4 q-pa-xs text-white">สิทธิที่ใช้ไปแล้ว</div>
          <div class="col-6 text-right q-pa-xs shadow-1">{{ used | formatNumber }}</div>
        </div>
        <div class="row q-ma-md q-px-lg">
          <div class="col-6 bg-cyan-8 q-pa-xs text-white">สิทธิคงเหลือ</div>
          <div class="col-6 text-right q-pa-xs shadow-1">{{ remain | formatNumber }}</div>
        </div>
      </div>
      <div class="col-md-9 col-xs-12" v-if="expenses.length != 0">
        <q-list class="q-ma-md" separator>
          <q-list-header class="text-bold">รายการเบิก</q-list-header>
          <q-item-separator />
          <q-collapsible v-for="(expense, index) in expenses" :key="index" :label="expense.RCPTDT | dateFormatEnToTh" :sublabel="parseFloat(expense.REIMB) | formatNumbeWithPrefix">
            <div class="row">
              <div class="col-xs-3 col-lg-2 text-bold">ผู้ป่วย</div>
              <div class="col-xs-9 col-lg-10">{{ expense.FAMEM_NAME }}</div>
            </div>
            <div class="row">
              <div class="col-xs-3 col-lg-2 text-bold">โรค</div>
              <div class="col-xs-9 col-lg-10">{{ expense.DIAG_NAME }}</div>
            </div>
            <div class="row">
              <div class="col-xs-3 col-lg-2 text-bold">สถานที่</div>
              <div class="col-xs-9 col-lg-10">{{ expense.HONAME }}</div>
            </div>
          </q-collapsible>
        </q-list>
      </div>
    </div>

  </q-page>
</template>

<script>
import { QSpinnerFacebook } from 'quasar'
export default {
  filters: {
    formatNumber (val) {
      let parts = val.toFixed(2).toString().split('.')
      return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',') + (parts[1] ? '.' + parts[1] : '') + ' บาท'
    },
    formatNumbeWithPrefix (val) {
      let parts = val.toFixed(2).toString().split('.')
      return 'ยอดเบิก ' + parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',') + (parts[1] ? '.' + parts[1] : '') + ' บาท'
    },
    dateFormatEnToTh (date) {
      let dd = (date || '').split('.')
      let ThaiMonth = ''
      switch (dd[1]) {
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
      return 'วันที่เบิก ' + parseInt(dd[2]) + ' ' + ThaiMonth + ' ' + (parseInt(dd[0]) + 543)
    }
  },
  created () {
    this.getSelectOptions()
    this.getDataAll()
  },
  data () {
    return {
      expenses: [],
      lazy: [],
      select: '',
      error: true,
      warning: false,
      selectOptions: [],
      used: 0
    }
  },
  computed: {
    remain () {
      return 3600 - this.used
    }
  },
  methods: {
    getSelectOptions () {
      let year = (new Date()).getFullYear()
      for (var i = 0; i <= (year - 2013); i++) {
        this.selectOptions.push({
          label: (year + 543 - i).toString(),
          value: year - i
        })
      }
      this.select = year
    },
    getDataAll () {
      this.$q.loading.show({
        spinner: QSpinnerFacebook,
        spinnerColor: 'primary',
        spinnerSize: 140
      })
      this.$axios.get('medical-expenses/' + this.select)
        .then((res) => {
          this.select = res.data.year
          this.used = res.data.total
          this.expenses = res.data.data
          console.log(res.data)
          this.$q.loading.hide()
        }).catch(() => {
            this.$q.dialog({
              color: 'negative',
              message: 'ไม่สามารถติดต่อฐานข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            })
        })
    }
  }
}
</script>

<style>
</style>
