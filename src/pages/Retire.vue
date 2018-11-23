<template>
  <q-page padding>
    <div>
      <vue-highcharts :options="options" ref="lineCharts"></vue-highcharts>
    </div>
  </q-page>
</template>

<script>
import VueHighcharts from 'vue2-highcharts'
export default {
  components: {
    VueHighcharts
  },
  mounted () {
    this.getData()
    // this.load()
  },
  data () {
    return {
      asyncData: [],
      currentCount: 0,
      options: {
        chart: {
          type: 'spline'
        },
        title: {
          text: 'จำนวนผู้ปฏิบัติงานเกษียณอายุ'
        },
        subtitle: {
          text: '5ปีถัดไป'
        },
        xAxis: {
          categories: [],
          title: {
            text: 'ปี'
          }
        },
        yAxis: {
          title: {
            text: 'จำนวนผู้ปฏิบัติงาน'
          },
          labels: {
            formatter: function () {
              return this.value
            }
          }
        },
        tooltip: {
          crosshairs: true,
          shared: true
        },
        colors: ['#db2828', '#f2c037', '#8bbc21', '#910000', '#1aadce', '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
        credits: {
          enabled: false
        },
        plotOptions: {
          spline: {
            marker: {
              radius: 4,
              lineColor: '#666666',
              lineWidth: 1
            }
          }
        },
        series: []
      }
    }
  },
  methods: {
    getData () {
      this.$axios.get('retire-next/5')
        .then((res) => {
          // console.log(res.data.retire_years)
          this.currentCount = res.data.current_count
          this.setAsyncData(res.data.retire_years)
        })
    },
    setAsyncData (years) {
      let retireData = {
        name: 'ผู้เกษียณ',
        tooltip: {pointFormat: 'เกษียณ: <b>{point.y:.f}</b> '},
        data: []
      }
      let remainData = {
        name: 'คงเหลือ',
        tooltip: {pointFormat: 'คงเหลือ: <b>{point.y:.f}</b> '},
        data: []
      }
      let retire = []
      let remain = []
      let remainAllYear = this.currentCount
      for (var year in years) {
          // skip loop if the property is from prototype
          if (!years.hasOwnProperty(year)) {
            continue
          }
          var obj = years[year]
          this.options.xAxis.categories.push(year)
          retire.push(obj['count'])
          remain.push(remainAllYear = remainAllYear - obj['count'])
      }
      retireData.data = retire
      remainData.data = remain
      let lineCharts = this.$refs.lineCharts
      lineCharts.delegateMethod('showLoading', 'Loading...')
      setTimeout(() => {
        lineCharts.addSeries(retireData)
        lineCharts.addSeries(remainData)
        lineCharts.hideLoading()
      }, 2000)
    }
  }
}
</script>

<style>
</style>
