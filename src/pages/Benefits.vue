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
                float-label="ปีงบประมาณ พ.ศ."
                separator
                radio
                :options="selectOptions"
                @input="getDataAll"
              />
          </q-card-main>
        </q-card>
      </div>
    </div>
    <div class="row q-ma-md q-px-lg">
      <div class="col-6 bg-primary q-pa-xs text-white">สิทธิรวมทั้งปี</div>
      <div class="col-6 text-right q-pa-xs">3,600.00 บาท</div>
    </div>
    <div class="row q-ma-md q-px-lg">
      <div class="col-6 bg-primary q-pa-xs text-white">สิทธิที่ใช้ไปแล้ว</div>
      <div class="col-6 text-right q-pa-xs">{{ used | formatNumber }} บาท</div>
    </div>
    <div class="row q-ma-md q-px-lg">
      <div class="col-6 bg-primary q-pa-xs text-white">สิทธิคงเหลือ</div>
      <div class="col-6 text-right q-pa-xs">{{ remain | formatNumber }} บาท</div>
    </div>

  </q-page>
</template>

<script>
export default {
  filters: {
    formatNumber (val) {
      let parts = val.toFixed(2).toString().split('.')
      return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',') + (parts[1] ? '.' + parts[1] : '')
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
      this.$axios.get('medical-expenses/' + this.select)
        .then((res) => {
          this.select = res.data.year
          this.used = res.data.total
          this.expenses = res.data.data
          console.log(res.data)
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
