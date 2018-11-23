<template>
  <q-page padding>
    <q-list highlight>
      <q-list-header>ข้อมูลสถิติทางด้านสารสนเทศบุคคล</q-list-header>
      <q-item-separator />
      <q-item v-for="(report , key) in reports" :key="key" link :to="report.path">
        <q-item-main :label="report.name"/>
      </q-item>
    </q-list>
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
