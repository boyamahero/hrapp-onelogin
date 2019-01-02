<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">ข้อมูลเงินเดือนค่าจ้าง</p>
          </q-card-main>
        </q-card>
      </div>
      <div class="col-md-9 col-xs-12" v-if="salaries.length != 0">
        <q-list class="q-ma-md" separator>
          <q-item v-for="(salary, index) in salaries" :key="index" >
            <div class="row">
              <div class="col-xs-12 col-lg-10 q-body-1">{{ salary.salary_date | dateFormatEnToTh }} {{ salary.salary_title }}</div>
              <div class="col-xs-12 col-lg-10 q-subheading text-weight-bold text-primary">{{ salary.salary_amount }} บาท</div>
            </div>
          </q-item>
        </q-list>
      </div>
      <q-pagination
        input
        v-model="page"
        :min="minPage"
        :max="maxPage"
        v-if="salaries.length != 0"
      />
    </div>
  </q-page>
</template>

<script>
import { QSpinnerGears } from 'quasar'
export default {
  data () {
    return {
      salaries: [],
      page: 1,
      minPage: 1,
      maxPage: 6
    }
  },
  watch: {
    page () {
      this.getDataAll()
    }
  },
  created () {
    this.getDataAll()
  },
  computed: {
    url () {
      return `salary?page=${this.page}`
    }
  },
  filters: {
    dateFormatEnToTh (date) {
      let dd = (date || '').split('/')
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
      return parseInt(dd[2]) + ' ' + ThaiMonth + ' ' + (parseInt(dd[0]))
    }
  },
  methods: {
    getDataAll () {
      this.$q.loading.show({
        spinner: QSpinnerGears,
        spinnerColor: 'yellow',
        spinnerSize: 140
      })
      this.$axios.get(this.url)
        .then((res) => {
          this.salaries = res.data.data
          this.maxPage = res.data.last_page
          this.$q.loading.hide()
        }).catch(() => {
            this.$q.loading.hide()
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
