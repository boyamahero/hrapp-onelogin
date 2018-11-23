<template>
  <q-page>
      <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-card class="q-ma-md">
      <q-card-main>
         <p class="header">Portfolio พนักงาน กฟผ.</p>
      </q-card-main>
        <q-card class="q-ma-md">
          <q-card-main>
            <p class="header bg-light-blue-1">การศึกษา : ระดับสูงสุด {{portfolio.highest_degree.degree_name}}</p>
              <q-item v-for="(education, index) in portfolio.educations" :key="index">
                <div class="row q-caption" >
                  <div class="col-xs-5">
                    {{education.degree_name}}
                  </div>
                  <div class="col-xs-7">
                    <div>{{education.certificate_name}}</div>
                    <div>{{education.branch_name}}</div>
                    <div>{{education.school_name}}</div>
                  </div>
                </div>
              </q-item>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main>
            <p class="header bg-light-blue-1">ประสบการณ์การทำงานและตำแหน่งงานที่คาดหวัง</p>
              <q-item v-for="(history_work, index) in portfolio.history_works" :key="index">
                <div class="row q-caption" >
                  <div class="col-xs-3">
                    {{history_work.works_date | yearFromDate}}
                  </div>
                  <div class="col-xs-9">
                    <div>{{history_work.works_dsc | replaceUnderscore}}</div>
                  </div>
                </div>
              </q-item>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main>
            <p class="header bg-light-blue-1">วิสัยทัศน์และผลงานที่โดดเด่นย้อนหลัง 5 ปี</p>
             <q-item v-for="(vision, index) in portfolio.visions" :key="index">
                <div class="row q-caption" >
                  <div class="col-xs-3">
                    วิสัยทัศน์
                  </div>
                  <div class="col-xs-9">
                    <div>{{vision.vision}}</div>
                    <div>{{vision.objective}}</div>
                    <div> approved by : {{vision.empn_approver}}</div>
                  </div>
                </div>
              </q-item>
              <q-item v-for="(portfolioInfo, index) in portfolio.portfolios" :key="index">
                <div class="row q-caption" >
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
              </q-item>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main>
            <p class="header bg-light-blue-1" >ผลการประเมิน KPI เฉลี่ย 3 ปี : {{portfolio.sum_kpi.avg_all_kpi_score | formatNumber}}</p>
             <div class="row q-caption justify-center">
                <div class="col-xs-6 bg-amber-4"><center>ปีที่ประเมิน KPI</center></div>
                <div class="col-xs-2 bg-amber-4 text-center" v-for="(kpi, index) in portfolio.kpis" :key="index">
                  {{index}}
                </div>
             </div>
             <div class="row q-caption justify-center">
                <div class="col-xs-6 bg-amber-2">KPI : 100%</div>
                <div class="col-xs-2 bg-amber-2 text-center" v-for="(kpi, index) in portfolio.kpis" :key="index">
                  {{kpi  | formatNumber}}
                </div>
             </div>
              <div class="row q-caption justify-center">
                <div class="col-xs-6 bg-amber-1">Soft KPI : 30%</div>
                <div class="col-xs-2 bg-amber-1 text-center" v-for="(soft_kpi, index) in portfolio.soft_kpis" :key="index">
                  {{soft_kpi.total  | formatNumber}}
                </div>
             </div>
             <div class="row q-caption justify-center">
                <div class="col-xs-6" v-for="(speedList, index) in speedLists" :key="index">
                  &nbsp;&nbsp;&nbsp;{{speedList}}
                </div>
                <div class="col-xs-2 bg-amber-1 text-center" v-for="(soft_kpi, index) in portfolio.soft_kpis" :key="index">
                  {{soft_kpi.B10}}
                  {{soft_kpi.B20}}
                  {{soft_kpi.B30}}
                  {{soft_kpi.B40}}
                  {{soft_kpi.B50}}
                </div>
             </div>
          </q-card-main>
        </q-card>
        <q-card class="q-ma-md">
          <q-card-main>
            <p class="header bg-light-blue-1">ผลการประเมิน Competency</p>
            <div class="row q-caption justify-center">
              <div class="col-xs-6 bg-blue-3"><center>ปีที่ประเมิน Competency</center></div>
              <div class="col-xs-2 bg-blue-3 text-center" v-for="(kpi, index) in portfolio.kpis" :key="index">
                {{index}}
              </div>
            </div>
              <!--Core Competency-->
            <div class="row q-caption justify-center">
              <div class="col-xs-6 bg-blue-2 text-center">Core<br>Competency</div>
              <div class="col-xs-2 bg-blue-2 text-center">ระดับ - <br>คาดหวัง-</div>
                <div class="row q-caption justify-center">
                </div>
              <div class="col-xs-2 bg-blue-2 text-center">ระดับ - <br>คาดหวัง-</div>
                <div class="row q-caption justify-center">
                </div>
              <div class="col-xs-2 bg-blue-2" v-for="(expectCompetency, index) in portfolio.expectCompetencies" :key="index">
                <center>
                  ระดับ {{expectCompetency.level}}<br>
                  คาดหวัง {{expectCompetency.expectC}}
                  <div class="row justify-center">
                    <div class="q-caption col-xs-6 bg-blue-1 text-center">self</div>
                    <div class="q-caption col-xs-6 bg-blue-1 text-center">360</div>
                  </div>
                </center>
              </div>
            </div>
            <div class="row q-caption justify-center">
              <div class="col-xs-12" v-for="(coreList, index) in coreLists" :key="index">
                {{coreList}}
              </div>
              <div class="q-caption col-xs-6" v-for="(competency, index) in portfolio.competencies" :key="index">
                {{competency.Test_Type}}
                {{competency.C1}}
                {{competency.C2}}
                {{competency.C3}}
                {{competency.C4}}
                {{competency.C5}}
                {{competency.C6}}
              </div>
            </div>
            <div class="row q-caption justify-center">
              <div class="col-xs-6 bg-blue-3 text-center">ผลรวม (ร้อยละ)</div>
              <div class="q-caption col-xs-3 bg-blue-3" v-for="(competency, index) in portfolio.competencies" :key="index">
                {{competency.Sum_Core  | formatNumber}}
            </div>
            </div><br>
            <!--Managerial Competency-->
            <div class="row q-caption justify-center" v-if(showManagerialTable)>
              <div class="col-xs-6 bg-cyan-2"><center>Managerial<br>Competency</center></div>
              <div class="col-xs-2 bg-cyan-2"><center>ระดับ - <br>คาดหวัง-</center></div>
                <div class="row q-caption justify-center">
                </div>
              <div class="col-xs-2 bg-cyan-2"><center>ระดับ - <br>คาดหวัง-</center></div>
                <div class="row q-caption justify-center">
                </div>
              <div class="col-xs-2 bg-cyan-2" v-for="(expectCompetency, index) in portfolio.expectCompetencies" :key="index">
                <center>
                  ระดับ {{expectCompetency.level}}<br>
                  คาดหวัง {{expectCompetency.expectC}}
                <div class="row justify-center">
                  <div class="q-caption col-xs-6 bg-cyan-1">self</div>
                  <div class="q-caption col-xs-6 bg-cyan-1">360</div>
                </div>
                </center>
              </div>
            </div>
            <div class="row q-caption justify-center">
              <div class="col-xs-12" v-for="(managerialList, index) in managerialLists" :key="index">
                {{managerialList}}
              </div>
              <div class="q-caption col-xs-6" v-for="(competency, index) in portfolio.competencies" :key="index">
                {{competency.Test_Type}}
                {{competency.M1}}
                {{competency.M2}}
                {{competency.M3}}
                {{competency.M4}}
                {{competency.M5}}
                {{competency.M6}}
              </div>
            </div>
            <div class="row q-caption justify-center">
              <div class="col-xs-6 bg-cyan-3 text-center">ผลรวม (ร้อยละ)</div>
              <div class="q-caption col-xs-3 bg-cyan-3" v-for="(competency, index) in portfolio.competencies" :key="index">
                {{competency.Sum_Managerial  | formatNumber}}
              </div>
            </div><br>
            <!--Rules-->
            <div class="q-caption">
                <strong>เกณฑ์ในการประเมินสมรรถนะความสามารถ</strong><br>
                S = Strength หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<br><u>สูงกว่า</u> ค่าความคาดหวังในระดับ<br>
                A = Acceptable หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<br><u>ตาม</u> ค่าความคาดหวังในระดับ<br>
                G = Growth Opportunity หมายถึง ผู้รับการประเมินแสดงพฤติกรรมได้<br><u>ต่ำกว่า</u> ค่าความคาดหวังในระดับ
            </div>
            </q-card-main>
        </q-card>
        <q-card-main>
          <div class="header q-body-1 bg-light-blue-1 text-center">
            จัดทำโดย ฝ่ายทรัพยากรบุคคลและพัฒนาองค์การ<br>
            จัดทำข้อมูล ณ วันที่
             {{employee.employee.employee_subgroup}}
          </div>
        </q-card-main>
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
      return value.replace('&#95', '\n')
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
    this.showManagerialTable()
  },
  methods: {
    getDataAll () {
      this.$axios.get('portfolioInfo/452939') // 452939
        .then((res) => {
          this.portfolio = res.data.data
        }
      )
    },
    showManagerialTable () {
      this.$axios.get('employee/452939') // 452939
        .then((res) => {
          this.employee = res.data.employee
        }
      )
    }
  }
}
</script>

<style>
</style>
