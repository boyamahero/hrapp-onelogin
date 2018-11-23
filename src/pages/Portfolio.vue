<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md q-pb-md">
          <q-card-main class="bg-light-blue-1">
            <p class="header ">Portfolio พนักงาน กฟผ.</p>
          </q-card-main>

          <q-card class="q-ma-md">
            <q-card-main class="bg-light-blue-1">
              <p class="header">การศึกษา : ระดับสูงสุด {{portfolio.highest_degree.degree_name}}</p>
              <div class="row q-body-1 bg-white" v-for="(education, index) in portfolio.educations" :key="'education-'+index">
                <div class="col-xs-3 col-md-1 q-pl-xs">{{education.degree_name}}</div>
                <div class="col-xs-9 col-md-11">
                  <div class="col-12">{{education.certificate_name}}</div>
                  <div class="col-12">{{education.branch_name}}</div>
                  <div class="col-12">{{education.school_name}}</div>
                </div>
              </div>
            </q-card-main>
          </q-card>

          <q-card class="q-ma-md">
            <q-card-main class="bg-light-blue-1">
              <p class="header">ประสบการณ์การทำงานและตำแหน่งงานที่คาดหวัง</p>
                <div class="row q-body-1 bg-white" v-for="(history_work, index) in portfolio.history_works" :key="'history_work-'+index">
                  <div class="col-xs-3 q-pl-xs">
                    {{history_work.works_date | yearFromDate}}
                  </div>
                  <div class="col-xs-9">
                    <div>{{history_work.works_dsc | replaceUnderscore}}</div>
                  </div>
                </div>
            </q-card-main>
          </q-card>

          <q-card class="q-ma-md">
            <q-card-main class="bg-light-blue-1">
              <p class="header">วิสัยทัศน์และผลงานที่โดดเด่นย้อนหลัง 5 ปี</p>
              <div class="row q-body-1 bg-white" v-for="(vision, index) in portfolio.visions" :key="'vision-'+index">
                <div class="col-xs-3">
                  วิสัยทัศน์
                </div>
                <div class="col-xs-9">
                  <div>{{vision.vision}}</div>
                  <div>{{vision.objective}}</div>
                  <div> approved by : {{vision.empn_approver}}</div>
                </div>
              </div>
              <div class="row q-body-1 bg-white" v-for="(portfolioInfo, index) in portfolio.portfolios" :key="'portfolioInfo-'+index">
                <div class="col-xs-3">
                  <div>ผลงานปี {{portfolioInfo.finish_year}}</div>
                </div>
                <div class="col-xs-9">
                  <div>{{portfolioInfo.achievement}}</div>
                  <div>{{portfolioInfo.result}}</div>
                  <div>{{portfolioInfo.category_type}}</div>
                  <div>มูลค่า {{portfolioInfo.value_added}} บาท</div>
                </div>
              </div>
            </q-card-main>
          </q-card>

          <q-card class="q-ma-md">
            <q-card-main class="bg-light-blue-1">
              <p class="header" >ผลการประเมิน KPI เฉลี่ย 3 ปี : <b>{{portfolio.sum_kpi.avg_all_kpi_score | formatNumber}}</b></p>
              <div class="row q-caption justify-center">
                  <div class="col-xs-6 bg-amber-4"><center>ปีที่ประเมิน KPI</center></div>
                  <div class="col-xs-2 bg-amber-4 text-center" v-for="(kpi, index) in portfolio.kpis" :key="'kpi-'+index">
                    {{index}}
                  </div>
              </div>
              <div class="row q-caption">
                  <div class="col-xs-6 bg-amber-2">KPI : 100%</div>
                  <div class="col-xs-2 bg-amber-2 text-center" v-for="(kpi, index) in portfolio.kpis" :key="'kpi1-'+index">
                    {{kpi  | formatNumber}}
                  </div>
              </div>
                <div class="row q-caption">
                  <div class="col-xs-6 bg-amber-1">Soft KPI : 30%</div>
                  <div class="col-xs-2 bg-amber-1 text-center" v-for="(soft_kpi, index) in portfolio.soft_kpis" :key="'soft_kpi-'+index">
                    {{soft_kpi.total  | formatNumber}}
                  </div>
              </div>
              <div class="row q-caption">
                  <div class="col-xs-6">
                    <div v-for="(speedList, index) in speedLists" :key="'speedList-'+index">
                      {{speedList}}
                    </div>
                  </div>
                  <div class="col-xs-2" v-for="(soft_kpi, index) in portfolio.soft_kpis" :key="'soft_kpi1-'+index">
                    <div class="text-center">
                      {{soft_kpi.B10 | formatNumber}}
                    </div>
                    <div class="text-center">
                      {{soft_kpi.B20 | formatNumber}}
                    </div>
                    <div class="text-center">
                      {{soft_kpi.B30 | formatNumber}}
                    </div>
                    <div class="text-center">
                      {{soft_kpi.B40 | formatNumber}}
                    </div>
                    <div class="text-center">
                      {{soft_kpi.B50 | formatNumber}}
                    </div>

                  </div>
              </div>
            </q-card-main>
          </q-card>

        </q-card>
      </div>
    </div>
  </q-page>
</template>
<script>
export default {
  filters: {
    yearFromDate (value) {
      return value.substring(0, 4)
    },
    replaceUnderscore (value) {
      return value.replace(/(?:_|_)/g, '\r\n')
    },
    formatNumber (value) {
     return parseFloat(value).toFixed(2)
    },
    dateNow () {
      // return
    }
  },
  data () {
    return {
      portfolio: [],
      speedLists: ['S - รักองค์การ', 'P - มุ่งงานเลิศ', 'E - เทิศคุณธรรม', 'E - นำด้วยนวัตกรรม', 'D - ทำประโยชน์เพื่อสังคม'],
      coreLists: ['การทำงานเป็นทีม', 'การวางแผน แก้ไขปัญหาและตัดสินใจเชิงรุก', 'คุณธรรมและธรรมาภิบาล', 'ความเชี่ยวชาญและความเป็นมืออาชีพ', 'ความคิดสร้างสรรค์และนวัตกรรม', 'การสื่อสารที่ดี'],
      managerialLists: ['ภาวะผู้นำ', 'วิสัยทัศน์และวางแผนเชิงยุทธศาสตร์', 'การสร้างความสัมพันธ์กับผู้เกี่ยวข้อง', 'การบริหารจัดการให้เกิดผลลัพธ์อย่างยั่งยืน', 'ศักยภาพเพื่อนำการเปลี่ยนแปลง', 'ความสามารถเชิงธุรกิจ'],
      colors: ['red-9', 'yellow-5', 'green-10'], // S=green / A=yellow / G=red
      employee: []
    }
  },
  mounted () {
    this.getDataAll()
    // this.showManagerialTable()
  },
  methods: {
    setNewToken (value) {
      if (value) {
        this.$axios.defaults.headers.common['Authorization'] = value
        localStorage.setItem('access_token', (value).replace('Bearer ', ''))
        this.$store.commit('retrieveToken', (value).replace('Bearer ', ''), { root: true })
      }
    },
    getDataAll () {
      this.$axios.get('portfolioInfo',
        {headers: {
            'Authorization': `Bearer ${this.$store.state.token.token}`
          }
        })
        .then((res) => {
          this.portfolio = res.data.data
          this.setNewToken(res.headers.authorization)
        }
      )
    },
    showManagerialTable () {
      this.$axios.get('employee',
        {headers: {
            'Authorization': `Bearer ${this.$store.state.token.token}`
          }
        })
        .then((res) => {
          this.employee = res.data.data
          this.setNewToken(res.headers.authorization)
        }
      )
    }
  }
}
</script>

<style>
</style>
