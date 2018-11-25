<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-light-blue-1">
            <p class="header text-bold">ข้อมูลสถิติทางด้านสารสนเทศบุคคล</p>
          </q-card-main>

          <q-list highlight>
          <q-item v-for="(report , key) in reports" :key="key" link :to="report.path">
            <q-item-main :label="report.name"/>
          </q-item>
          </q-list>

        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      reports: [
        {name: 'จำนวนผู้ปฏิบัติงาน ณ ปัจจุบัน', path: '/manpower'},
        {name: 'จำนวนผู้เกษียณ 5 ปีถัดไป', path: '/retire'}
      ]
    }
  },
  methods: {
    goto (path) {
      console.log('path')
    }
  }
}
</script>

<style>
</style>
