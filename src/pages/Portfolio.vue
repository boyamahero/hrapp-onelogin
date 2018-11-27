<template>
  <q-page>
    <div class="row justify-center" v-cloak>
      <div class="col-md-9 col-xs-12">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">Portfolio พนักงาน กฟผ.</p>
          </q-card-main>
        </q-card>

          <div class="row">

            <div class="col-xs-12 col-lg-6">
              <q-card class="q-mx-md q-mb-md">
                <q-card-main class="bg-indigo-1">
                  <p class="header text-bold">การศึกษา : ระดับสูงสุด {{highest_degree}}</p>
                  <div class="row q-body-1 bg-white" v-for="(education, index) in portfolio.educations" :key="'education-'+index">
                    <div class="col-xs-4 col-md-3 q-pl-xs text-bold">{{education.degree_name}}</div>
                    <div class="col-xs-8 col-md-9">
                      <div class="col-12 text-bold" v-if="education.certificate_name!=='-'">{{education.certificate_name}}</div>
                      <div class="col-12">({{education.branch_name}})</div>
                      <div class="col-12">{{education.school_name}}</div>
                    </div>
                  </div>
                </q-card-main>
              </q-card>

              <q-card class="q-ma-md">
                <q-card-main class="bg-green-2">
                  <p class="header text-bold">ประสบการณ์การทำงานและตำแหน่งงานที่คาดหวัง</p>
                    <div class="row q-body-1 bg-white" v-for="(history_work, index) in portfolio.history_works" :key="'history_work-'+index">
                      <div class="col-3 q-pl-xs text-bold">
                        {{history_work.works_date | yearFromDate}}
                      </div>
                      <div class="col-9" v-html="replaceUnderscore(history_work.works_dsc)">
                      </div>
                    </div>
                </q-card-main>
              </q-card>

              <q-card class="q-ma-md">
                <q-card-main class="bg-deep-orange-2">
                  <p class="header text-bold">วิสัยทัศน์และผลงานที่โดดเด่นย้อนหลัง 5 ปี</p>
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
                      <div class="text-bold">ผลงานปี {{portfolioInfo.finish_year}}</div>
                    </div>
                    <div class="col-xs-9">
                      <div class="text-bold">{{portfolioInfo.achievement}}</div>
                      <div>{{portfolioInfo.result}}</div>
                      <div>ผลงานด้าน {{portfolioInfo.category_type}}</div>
                      <div v-if="portfolioInfo.value_added > 0">มูลค่า {{portfolioInfo.value_added}} บาท</div>
                    </div>
                  </div>
                </q-card-main>
              </q-card>
            </div>

            <div class="col-xs-12 col-lg-6">
              <q-card class="q-mx-md q-mb-md">
                <q-card-main class="bg-amber-5">
                  <p class="header text-bold text-black" >ผลการประเมินเฉลี่ย 3 ปี : {{avg_all_kpi_score | formatNumber}}</p>
                  <div class="row q-caption justify-center">
                      <div class="col-xs-6 bg-amber-4"><center>ปีที่ประเมิน</center></div>
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
                      <div class="col-xs-6 bg-amber-1 q-pl-xs">Soft KPI : 30%</div>
                      <div class="col-xs-2 bg-amber-1 text-center" v-for="(soft_kpi, index) in portfolio.soft_kpis" :key="'soft_kpi-'+index">
                        {{soft_kpi.total  | formatNumber}}
                      </div>
                  </div>
                  <div class="row q-caption bg-white">
                      <div class="col-xs-6 q-pl-xs">
                        <div class="q-ml-xs" v-for="(speedList, index) in speedLists" :key="'speedList-'+index">
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

              <q-card class="q-ma-md">
                <q-card-main class="bg-blue-5">
                  <p class="header text-bold text-white" >ผลการประเมิน Competency</p>
                  <div class="row q-caption bg-blue-1" v-for="(row, index) in transposed" :key="index">

                    <div class="col-6 bg-blue-3 text-center" v-if="index==0">
                      ปีที่ประเมิน
                    </div>
                    <div class="col-2 bg-blue-3 text-center" v-if="index==0" v-for="(n, i) in [parseInt(Math.max(...row))-2, parseInt(Math.max(...row))-1, parseInt(Math.max(...row))]" :key="'year'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-3 text-center" v-if="index==1">
                      ผู้ประเมิน
                    </div>
                    <div class="col-1 bg-blue-3 text-center" v-if="index==1" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div class="col-1 bg-blue-3 text-center" v-if="index==1" v-for="(n, i) in row" :key="'evaluator'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-2 text-center" v-if="index==2">
                      Core competency
                    </div>
                    <div class="col-1 bg-blue-2 text-center" v-if="index==2" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div class="col-1 bg-blue-2 text-center" v-if="index==2" v-for="(n, i) in row" :key="'level'+i">
                      L{{ parseInt(n) }}
                      <q-tooltip anchor="center left" self="center right" :offset="[10, 10]" class="bg-blue">
                        ระดับ {{ parseInt(n) }}<br/>ความควาดหวัง {{ parseInt(n) | expectedCore}}
                      </q-tooltip>
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==3">
                      - {{ coreLists.C1 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==3" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==3" v-for="(n, i) in row" :key="'C1'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==4">
                      - {{ coreLists.C2 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==4" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==4" v-for="(n, i) in row" :key="'C2'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==5">
                      - {{ coreLists.C3 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==5" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==5" v-for="(n, i) in row" :key="'C3'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==6">
                      - {{ coreLists.C4 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==6" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==6" v-for="(n, i) in row" :key="'C4'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==7">
                      - {{ coreLists.C5 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==7" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==7" v-for="(n, i) in row" :key="'C5'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-1" v-if="index==8 && checkProperties(row)">
                      - {{ coreLists.C6 }}
                    </div>
                    <div class="col-1 bg-blue-1 text-center" v-if="index==8" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==8" v-for="(n, i) in row" :key="'C6'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-blue-2 text-bold" v-if="index==9">
                      ผลรวม (ร้อยละ)
                    </div>
                    <div class="col-1 bg-blue-2 text-center" v-if="index==9" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div class="col-1 bg-blue-2 text-center" v-if="index==9" v-for="(n, i) in row" :key="'sum'+i">
                      {{ parseInt(n).toFixed(0)}}
                    </div>

                    <div class="col-6 bg-cyan-2 text-center" v-if="index==10 && parseInt(Math.max(...row)) > 7">
                      Managerial competency
                    </div>
                    <div class="col-1 bg-cyan-2 text-center" v-if="index==10 && parseInt(Math.max(...row)) > 7" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div class="col-1 bg-cyan-2 text-center" v-if="index==10 && parseInt(Math.max(...row)) > 7" v-for="(n, i) in row" :key="'Manageriallevel'+i">
                      L{{ parseInt(n) }}
                      <q-tooltip anchor="center left" self="center right" :offset="[10, 10]" class="bg-cyan">
                        ระดับ {{ parseInt(n) }}<br/>ความควาดหวัง {{ parseInt(n) | expectedManagerial }}
                      </q-tooltip>
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==11 && checkProperties(row)">
                      - {{ managerialLists.M1 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==11" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==11" v-for="(n, i) in row" :key="'M1'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==12 && checkProperties(row)">
                      - {{ managerialLists.M2 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==12" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==12" v-for="(n, i) in row" :key="'M2'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==13 && checkProperties(row)">
                      - {{ managerialLists.M3 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==13" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==13" v-for="(n, i) in row" :key="'M3'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==14 && checkProperties(row)">
                      - {{ managerialLists.M4 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==14" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==14" v-for="(n, i) in row" :key="'M4'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==15 && checkProperties(row)">
                      - {{ managerialLists.M5 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==15" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==15" v-for="(n, i) in row" :key="'M5'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-1" v-if="index==16 && checkProperties(row)">
                      - {{ managerialLists.M6 }}
                    </div>
                    <div class="col-1 bg-cyan-1 text-center" v-if="index==16" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div :class="'col-1 text-center ' + (n == 'G'?'bg-red':((n == 'A')?'bg-yellow':'bg-green'))" v-if="index==16" v-for="(n, i) in row" :key="'M6'+i">
                      {{ n }}
                    </div>

                    <div class="col-6 bg-cyan-2 text-bold" v-if="index==17 && parseInt(Math.max(...row)) > 0">
                      ผลรวม (ร้อยละ)
                    </div>
                    <div class="col-1 bg-cyan-2 text-center" v-if="index==17 && parseInt(Math.max(...row)) > 0" v-for="(n, i) in (6 - row.length)" :key="i">
                    </div>
                    <div class="col-1 bg-cyan-2 text-center" v-if="index==17 && parseInt(Math.max(...row)) > 0" v-for="(n, i) in row" :key="'Sum_Managerial'+i">
                      {{ parseInt(n).toFixed(0)}}
                    </div>

                  </div>
                </q-card-main>
              </q-card>

              <q-card class="q-ma-md">
                <q-card-main>
                  <p class="q-caption text-bold">เกณฑ์ในการประเมินสมรรถนะความสามารถ (Competency)</p>
                  <div class="row q-ml-xs">
                    <div class="col-4">
                      S = Strength
                    </div>
                    <div class="col-8">
                      หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<span class="text-red">สูงกว่า</span>ค่าความคาดหวังในระดับ
                    </div>
                  </div>
                  <div class="row q-ml-xs">
                    <div class="col-4">
                      A = Acceptable
                    </div>
                    <div class="col-8">
                      หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<span class="text-red">ตาม</span>ค่าความคาดหวังในระดับ
                    </div>
                  </div>
                  <div class="row q-ml-xs">
                    <div class="col-4">
                      G = Growth Opportunity
                    </div>
                    <div class="col-8">
                      หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<span class="text-red">ต่ำกว่า</span>ค่าความคาดหวังในระดับ
                    </div>
                  </div>
                </q-card-main>
              </q-card>

            </div>

          </div>

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
    formatNumber (value) {
     return parseFloat(value).toFixed(2)
    },
    expectedCore (value) {
      if (value <= 4) {
        return '1'
      }
      if (value >= 5 && value <= 7) {
        return '2'
      }
      if (value >= 8 && value <= 10) {
        return '3'
      }
      if (value >= 11 && value <= 12) {
        return '4'
      }
      if (value >= 13 && value <= 14) {
        return '5'
      }
    },
    expectedManagerial (value) {
      if (value <= 4) {
        return '-'
      }
      if (value >= 5 && value <= 7) {
        return '-'
      }
      if (value === 8) {
        return '1'
      }
      if (value >= 9 && value <= 10) {
        return '2'
      }
      if (value >= 11 && value <= 12) {
        return '3'
      }
      if (value === 13) {
        return '4'
      }
      if (value === 14) {
        return '5'
      }
    }
  },
  computed: {
    transposed () {
        let columns = ['Test_Year', 'Test_Type', 'Zlevel', 'C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'Sum_Core', 'Zlevel', 'M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'Sum_Managerial']
        return columns.reduce((a, v) => {
          a.push(this.competencies.map(f => f[v]))
          return a
        }, [])
    }
  },
  data () {
    return {
      portfolio: [],
      speedLists: ['S - รักองค์การ', 'P - มุ่งงานเลิศ', 'E - เทิศคุณธรรม', 'E - นำด้วยนวัตกรรม', 'D - ทำประโยชน์เพื่อสังคม'],
      coreLists: { C1: 'การทำงานเป็นทีม', C2: 'การวางแผน แก้ไขปัญหาและตัดสินใจเชิงรุก', C3: 'คุณธรรมและธรรมาภิบาล', C4: 'ความเชี่ยวชาญและความเป็นมืออาชีพ', C5: 'ความคิดสร้างสรรค์และนวัตกรรม', C6: 'การสื่อสารที่ดี' },
      managerialLists: { M1: 'ภาวะผู้นำ', M2: 'วิสัยทัศน์และวางแผนเชิงยุทธศาสตร์', M3: 'การสร้างความสัมพันธ์กับผู้เกี่ยวข้อง', M4: 'การบริหารจัดการให้เกิดผลลัพธ์อย่างยั่งยืน', M5: 'ศักยภาพเพื่อนำการเปลี่ยนแปลง', M6: 'ความสามารถเชิงธุรกิจ' },
      colors: ['red-9', 'yellow-5', 'green-10'], // S=green / A=yellow / G=red
      employee: [],
      avg_all_kpi_score: 0,
      highest_degree: '',
      competencies: []
    }
  },
  mounted () {
    this.getDataAll()
  },
  methods: {
    checkProperties (obj) {
      for (var key in obj) {
        if (obj[key] !== null) {
          return true
        }
      }
      return false
    },
    replaceUnderscore (value) {
      return value.replace(/(?:_|_)/g, '<br/>')
    },
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
          this.avg_all_kpi_score = res.data.data.sum_kpi.avg_all_kpi_score
          this.highest_degree = res.data.data.highest_degree.degree_name
          this.competencies = res.data.data.competencies
          this.setNewToken(res.headers.authorization)
        }).catch(() => {
            this.$q.dialog({
              color: 'negative',
              message: 'ไม่สามารถติดต่อฐานข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            }).then(() => {
              this.$store.commit('destroyToken')
              this.$router.push({name: 'login'})
            })
        })
    }
  }
}
</script>

<style>
</style>
