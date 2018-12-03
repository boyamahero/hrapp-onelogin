<template>
  <q-page>
    <div class="row justify-center" v-cloak>
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">เงินช่วยเหลือค่ารักษาพยาบาลของโรงพยาบาลและคลินิกเอกชน (3,600)</p>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <q-select
              stack-label="ปีใบเสร็จ"
              inverted-light
              color="amber"
              separator
              v-model="select"
              :options="options"
            />
          </q-card-main>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  created () {
    this.getDataAll()
  },
  data () {
    return {
      expenses: [],
      lazy: [],
      select: '',
      error: true,
      warning: false,
      options: []
    }
  },
  methods: {
    getDataAll () {
      this.$axios.get('medical-expenses')
        .then((res) => {
          this.select = res.data.year
          let year = new Date().getFullYear()
          this.options = Array.from({length: 5}, (value, index) => (year - 1))
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
