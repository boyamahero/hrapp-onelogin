<template>
 <q-page padding>
    <div class="container">
    <div class="row justify-center">
      <div class="q-ma-xs full-width">
      <vue-highcharts :options="options" ref="pineChartMain"></vue-highcharts>
      </div>
    </div>
    <div class="row justify-center" v-if="Level1">
      <div class="q-ma-xs full-width">
      <vue-highcharts :options="options" id="Level1" ref="pineChartLevel1"></vue-highcharts>
      </div>
    </div>
    <div class="row justify-center" v-if="Level2">
      <div class="q-ma-xs full-width">
      <vue-highcharts :options="options" id="Level2" ref="pineChartLevel2"></vue-highcharts>
      </div>
    </div>
    <div class="row justify-center" v-if="Level3">
      <div class="q-ma-xs full-width">
      <vue-highcharts :options="options" id="Level3" ref="pineChartLevel3"></vue-highcharts>
      </div>
    </div>
    <div class="row justify-center" v-if="Level4">
      <div class="q-ma-xs full-width">
      <vue-highcharts :options="options" id="Level4" ref="pineChartLevel4"></vue-highcharts>
      </div>
    </div>
    </div>
   </q-page>
</template>

<script>
import VueHighcharts from 'vue2-highcharts'
import {scroller} from 'vue-scrollto/src/scrollTo'
export default {
  components: {
    VueHighcharts
  },
  data () {
    return {
      Level1: false,
      Level2: false,
      Level3: false,
      Level4: false,
      options: {
        title: {
          text: ''
        },
        subtitle: {
          text: ''
        }
      }
    }
},
  mounted () {
    this.getDataAll()
  },
  methods: {
    getDataAll () {
      let listdata = []
      this.$axios.get('manpower')
        .then((res) => {
          let data = res.data.data
        for (let i = 0; i < data.length; i++) {
            if (data[i].deputy_abb === '' || null) {
              data[i].deputy_abb = 'ส่วนกลาง'
            }
            listdata.push([data[i].deputy_abb, parseInt(data[i].employee_count)])
        }
        this.loadChart(listdata)
        })
    },
    loadChart (data) {
      this.Level1 = false
      this.Level2 = false
      this.Level3 = false
      this.Level4 = false
      let total = 0
      data.forEach(function (value) {
          total = total + value[1]
      })
      let option = {
        title: {
          text: 'ข้อมูลสถิติและอัตรากำลัง'
        },
        subtitle: {
          text: 'ภาพรวม กฟผ. จำนวน ' + total.toLocaleString() + ' คน'
        }
      }
      let asyncData = {
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: data,
        showInLegend: true,
        tooltip: {pointFormat: 'จำนวน : <b>{point.y:.f}</b>'},
        events: {
                click: function (event) {
                    this.loadLevel1(1, event.point.name) // 1 รอง
                }.bind(this)
            }
      }
      let pineChartMain = this.$refs.pineChartMain
      pineChartMain.mergeOption(option)
      pineChartMain.delegateMethod('showLoading', 'Loading...')
      setTimeout(() => {
        pineChartMain.addSeries(asyncData)
        pineChartMain.hideLoading()
      }, 2000)
    },
    loadLevel1 (level, abb) {
      this.Level1 = true
      this.Level2 = false
      this.Level3 = false
      this.Level4 = false
      let listdata = []
      let total = 0
      this.$axios.get('manpower/' + level + '/' + abb)
        .then((res) => {
          let data = res.data.data
                for (let i = 0; i < data.length; i++) {
                    if (data[i].assistant_abb === '' || null) {
                    data[i].assistant_abb = 'ส่วนกลาง'
                }
                listdata.push([data[i].assistant_abb, parseInt(data[i].employee_count)])
                total += parseInt(data[i].employee_count)
            }
      let option = {
        title: {
          text: 'หน่วยงาน ' + abb
        },
        subtitle: {
          text: 'จำนวน ' + total.toLocaleString() + ' คน'
        }
      }
      let asyncData = {
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: listdata,
        showInLegend: true,
        tooltip: {pointFormat: 'จำนวน : <b>{point.y:.f}</b>'},
        events: {
                click: function (event) {
                  if (event.point.name !== 'ส่วนกลาง') {
                    this.loadLevel2(2, event.point.name) // 2 ช
                  }
                }.bind(this)
            }
      }
      const ScrollTo = scroller()
      ScrollTo('#Level1')
      let pineChartLevel1 = this.$refs.pineChartLevel1
      pineChartLevel1.delegateMethod('showLoading', 'Loading...')
      pineChartLevel1.mergeOption(option)
      setTimeout(() => {
        pineChartLevel1.removeSeries()
        pineChartLevel1.addSeries(asyncData)
        pineChartLevel1.hideLoading()
      }, 2000)
        })
    },
    loadLevel2 (level, abb) {
      this.Level1 = true
      this.Level2 = true
      this.Level3 = false
      this.Level4 = false
      let listdata = []
      let total = 0
      this.$axios.get('manpower/' + level + '/' + abb)
        .then((res) => {
          let data = res.data.data
            for (let i = 0; i < data.length; i++) {
                if (data[i].division_abb === '' || null) {
                    data[i].division_abb = 'ส่วนกลาง'
                }
                listdata.push([data[i].division_abb, parseInt(data[i].employee_count)])
                total += parseInt(data[i].employee_count)
            }
      let option = {
        title: {
          text: 'หน่วยงาน ' + abb
        },
        subtitle: {
          text: 'จำนวน ' + total.toLocaleString() + ' คน'
        }
      }
      let asyncData = {
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: listdata,
        showInLegend: true,
        tooltip: {pointFormat: 'จำนวน : <b>{point.y:.f}</b>'},
        events: {
                click: function (event) {
                    if (event.point.name !== 'ส่วนกลาง') {
                    this.loadLevel3(3, event.point.name)
                    }
                }.bind(this)
            }
      }
      const ScrollTo = scroller()
      ScrollTo('#Level2')
      let pineChartLevel2 = this.$refs.pineChartLevel2
      pineChartLevel2.delegateMethod('showLoading', 'Loading...')
      pineChartLevel2.mergeOption(option)
      setTimeout(() => {
        pineChartLevel2.removeSeries()
        pineChartLevel2.addSeries(asyncData)
        pineChartLevel2.hideLoading()
      }, 2000)
        })
    },
    loadLevel3 (level, abb) {
      this.Level1 = true
      this.Level2 = true
      this.Level3 = true
      this.Level4 = false
      let listdata = []
      let total = 0
      this.$axios.get('manpower/' + level + '/' + abb)
        .then((res) => {
          let data = res.data.data
            for (let i = 0; i < data.length; i++) {
              if (data[i].department_abb === '' || null) {
                    data[i].department_abb = 'ส่วนกลาง'
                }
                listdata.push([data[i].department_abb, parseInt(data[i].employee_count)])
                total += parseInt(data[i].employee_count)
            }
      let option = {
        title: {
          text: 'หน่วยงาน ' + abb
        },
        subtitle: {
          text: 'จำนวน ' + total.toLocaleString() + ' คน'
        }
      }
      let asyncData = {
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: listdata,
        showInLegend: true,
        tooltip: {pointFormat: 'จำนวน : <b>{point.y:.f}</b>'},
        events: {
                click: function (event) {
                    if (event.point.name !== 'ส่วนกลาง') {
                    this.loadLevel4(4, event.point.name)
                    }
                }.bind(this)
            }
      }
      const ScrollTo = scroller()
      ScrollTo('#Level3')
      let pineChartLevel3 = this.$refs.pineChartLevel3
      pineChartLevel3.delegateMethod('showLoading', 'Loading...')
      pineChartLevel3.mergeOption(option)
      setTimeout(() => {
        pineChartLevel3.removeSeries()
        pineChartLevel3.addSeries(asyncData)
        pineChartLevel3.hideLoading()
      }, 2000)
        })
    },
    loadLevel4 (level, abb) {
      this.Level1 = true
      this.Level2 = true
      this.Level3 = true
      this.Level4 = true
      let listdata = []
      let total = 0
      this.$axios.get('manpower/' + level + '/' + abb)
        .then((res) => {
          let data = res.data.data
            for (let i = 0; i < data.length; i++) {
              if (data[i].section_abb === '' || null) {
                    data[i].section_abb = 'ส่วนกลาง'
                }
                listdata.push([data[i].section_abb, parseInt(data[i].employee_count)])
                total += parseInt(data[i].employee_count)
            }
      let option = {
        title: {
          text: 'หน่วยงาน ' + abb
        },
        subtitle: {
          text: 'จำนวน ' + total.toLocaleString() + ' คน'
        }
      }
      let asyncData = {
        type: 'pie',
        allowPointSelect: true,
        keys: ['name', 'y', 'selected', 'sliced'],
        data: listdata,
        showInLegend: true,
        tooltip: {pointFormat: 'จำนวน : <b>{point.y:.f}</b>'}
      }
      const ScrollTo = scroller()
      ScrollTo('#Level4')
      let pineChartLevel4 = this.$refs.pineChartLevel4
      pineChartLevel4.delegateMethod('showLoading', 'Loading...')
      pineChartLevel4.mergeOption(option)
      setTimeout(() => {
        pineChartLevel4.removeSeries()
        pineChartLevel4.addSeries(asyncData)
        pineChartLevel4.hideLoading()
      }, 2000)
        })
    }
  }
}
</script>
