<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-12">
        <q-card class="q-mx-md q-mb-xs q-mt-md">
          <q-card-main>
            <div class="row q-ma-md">
              <q-search
                class="full-width"
                v-model="searchText"
                :debounce="2000"
                placeholder="ชื่อ/นามสกุล(TH/EN)/ สังกัด(ย่อ/เต็ม)/ ตำแหน่งย่อ/ เลขประจำตัว/ อีเมล"
                icon="person"
                float-label="คำค้น"
                clearable
                inverted
                @change="val => { searchText = val }"
                @input="search"
              />
            </div>
          </q-card-main>
        </q-card>
      </div>
    </div>

    <div
      class="row justify-between q-ma-md"
      v-if="showResult"
    >
      <div class="text-left self-center">
        <div>
          <div v-if="total > 0">พบผลการค้นหาจำนวน {{ total }} ท่าน</div>
          <div v-else>{{ message }}</div>
        </div>
        <div class="subtitle">
          <span v-if="filter.level.min !== 0 || filter.level.max !==14">ระดับ {{filter.level.min}} {{filter.level.min===filter.level.max?'':'ถึง '+filter.level.max}}</span>
          <span v-if="filter.onlyBoss"> <span v-if="filter.level.min !== 0 || filter.level.max !==14"> , </span>ผบ.เท่านั้น</span>
          <span v-if="filter.orderBySenior"> <span v-if="filter.level.min !== 0 || filter.level.max !==14 || filter.onlyBoss"> , </span>เรียงลำดับอาวุโส</span>
        </div>
      </div>
      <div class="text-right self-center">
        <q-btn
          icon="filter_list"
          round
          no-shadow
          @click.native="filterOpened = true"
          :color=" isFiltered ? 'primary':''"
        />
      </div>
    </div>

    <!-- <q-item-separator /> -->

    <div class="row justify-center">
      <div class="col-12 justify-between">
        <q-infinite-scroll
          :handler="loadMore"
          ref="infiniteScroll"
        >
          <q-card
            v-for="(employee, index) in employees"
            :key="index"
            :color="employee | blockColor"
          >
            <q-item>
              <q-item-side>
                <div class="row no-margin text-center">
                  <div
                    class="col-12"
                    :id="employee.image_path"
                  >
                    <img
                      v-lazy="employee.image_path"
                      style="width: 75px;"
                      draggable="false"
                      oncontextmenu="return false"
                    ><br>
                  </div>
                  <div class="col-12">
                    <q-icon
                      v-if="employee.can_open"
                      name="fas fa-search-plus"
                      @click.native="itemClicked(employee)"
                      :color="employee.is_boss?'white':'primary'"
                    />
                  </div>
                </div>
              </q-item-side>
              <q-item-main>
                <q-item-tile class="q-body-1 text-weight-bold">
                  {{ employee.name }} ({{ employee.code }})
                  <q-icon
                      v-if="employee.work_from_home.length > 0"
                      name="fas fa-laptop-house"
                      :color="employee.is_boss?'indigo-10':'orange'"
                      class="q-ml-xs"
                    >
                      <q-tooltip
                        color="black"
                        :class="employee.is_boss?'q-body-2 text-white text-bold bg-indigo-10':'q-body-2 text-white text-bold bg-orange'"
                        v-for="(wfh, index) in employee.work_from_home"
                        :key="index"
                      >
                        WFH {{wfh.BeginDate}} {{wfh.BeginTime}} - {{wfh.EndDate}} {{wfh.EndTime}}
                      </q-tooltip>
                    </q-icon>
                    <q-icon
                      v-if="employee.work_from_any_where.length > 0"
                      name="fas fa-globe-americas"
                      :color="employee.is_boss?'indigo-10':'orange'"
                      class="q-ml-xs"
                    >
                      <q-tooltip
                        :class="employee.is_boss?'q-body-2 text-white text-bold bg-indigo-10':'q-body-2 text-white text-bold bg-orange'"
                        v-for="(wfa, index) in employee.work_from_any_where"
                        :key="index"
                      >
                        WFA {{wfa.BeginDate}} {{wfa.BeginTime}} - {{wfa.EndDate}} {{wfa.EndTime}}
                      </q-tooltip>
                    </q-icon>
                  </q-item-tile>
                <q-item-tile class="q-body-1">
                  <q-icon name="work" />
                  <span>
                    {{ employee.secretary? employee.position_abb + ' ทนท.เลขาฯ '+ employee.secretary.position_boss.PST_TShortName : employee.position_abb }}
                    <q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >
                      {{ employee.secretary? employee.position_full + ' ' + employee.secretary.PATH_PositionName : employee.position_full }}
                    </q-tooltip>
                  </span>
                </q-item-tile>
                <q-item-tile class="q-body-1">
                  <q-icon name="business" />
                  <span> {{employee.deputy_abb }}<q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >{{ employee.deputy_full }}</q-tooltip></span>
                  <span> {{employee.assistant_abb }}<q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >{{ employee.assistant_full }}</q-tooltip></span>
                  <span> {{employee.division_abb }}<q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >{{ employee.division_full }}</q-tooltip></span>
                  <span> {{employee.department_abb }}<q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >{{ employee.department_full }}</q-tooltip></span>
                  <span> {{employee.section_abb }}<q-tooltip
                      self="center right"
                      color="black"
                      class="q-body-2 text-primary bg-green-2"
                    >{{ employee.section_full }}</q-tooltip></span>
                </q-item-tile>
                <div v-if='employee.email'>
                  <q-item-tile class="q-body-1">
                    <q-icon name="email" />
                    <span>
                      {{ employee.email }}
                    </span>
                  </q-item-tile>
                </div>
                <div v-if='employee.templocation'>
                  <q-item-tile class="q-body-1">
                    <q-icon name="room" /> {{ employee.templocation.Name }}</q-item-tile>
                  <q-item-tile class="q-body-1"> &nbsp;&nbsp;&nbsp;&nbsp; {{ employee.templocation.Building }}<span> ห้อง {{ employee.templocation.Room }}</span></q-item-tile>
                  <q-item-tile class="q-body-1">
                    <q-icon name="call" /> {{ employee.templocation.PhoneNumber }}</q-item-tile>
                  <q-item-tile
                    class="q-body-1"
                    v-if="employee.templocation.MobilePhoneNumber"
                  >
                    <q-icon name="smartphone" /> {{ employee.templocation.MobilePhoneNumber }}</q-item-tile>
                </div>
                <div v-else-if='employee.person_location'>
                  <q-item-tile class="q-body-1">
                    <q-icon name="room" /> {{ employee.person_location.Name }}</q-item-tile>
                  <q-item-tile class="q-body-1"> &nbsp;&nbsp;&nbsp;&nbsp; {{ employee.person_location.Building }}<span> ห้อง {{ employee.person_location.Room  }}</span></q-item-tile>
                  <q-item-tile class="q-body-1">
                    <q-icon name="call" /> {{ employee.person_location.PhoneNumber }}</q-item-tile>
                  <q-item-tile
                    class="q-body-1"
                    v-if="employee.person_location.MobilePhoneNumber"
                  >
                    <q-icon name="smartphone" /> {{ employee.person_location.MobilePhoneNumber }}</q-item-tile>
                </div>
                <div v-else>
                  <q-item-tile class="q-body-1">
                    <q-icon name="room" /> - </q-item-tile>
                  <q-item-tile class="q-body-1"> &nbsp;&nbsp;&nbsp;&nbsp; - </q-item-tile>
                  <q-item-tile class="q-body-1">
                    <q-icon name="call" /> - </q-item-tile>
                </div>
              </q-item-main>
            </q-item>
          </q-card>
          <back-to-top
            bottom="100px"
            right="10px"
          >
            <button
              type="button"
              class="btn btn-info btn-to-top"
            ><i class="fa fa-chevron-up"></i></button>
          </back-to-top>
          <div
            class="row justify-center"
            style="margin-bottom: 20px;"
            v-if="next_page_url"
          >
            <q-spinner-dots
              slot="message"
              :size="40"
            />
          </div>
        </q-infinite-scroll>
      </div>
    </div>

    <q-modal
      v-model="maximizedModal"
      maximized
      v-if="employee.can_open"
    >
      <q-modal-layout>
        <q-toolbar slot="header">
          <q-toolbar-title>
            ข้อมูลบุคคล
          </q-toolbar-title>
          <q-btn
            flat
            round
            dense
            @click="maximizedModal = false"
            icon="close"
          />
        </q-toolbar>
        <div class="row justify-center gutter-sm q-pa-sm">
          <div class="col-xs-10 col-md-4 col-lg-2 text-center">
            <q-card>
              <q-card-media class="q-py-md q-px-md">
                <img :src="employee.image_path">
              </q-card-media>
            </q-card>
          </div>
          <div class="col-xs-10 col-md-4 col-lg-4 text-center">
            <q-card>
              <q-card-title class="bg-primary text-white">
                {{ employee.employee_group_name }}
              </q-card-title>
              <q-card-main class="text-left">
                <p class="text-faded no-margin">หมายเลขประจำตัว</p>
                <p class="no-margin q-pl-xs">{{ employee.code }}</p>
                <p class="text-faded no-margin">ชื่อ-สกุล</p>
                <p class="no-margin q-pl-xs">{{ employee.name }}</p>
                <p class="text-faded no-margin">ชื่อ-สกุล (ภาษาอังกฤษ)</p>
                <p class="no-margin q-pl-xs">{{ employee.name_english }}</p>
                <p class="text-faded no-margin">ศาสนา</p>
                <p class="no-margin q-pl-xs">{{ employee.religion }}</p>
                <p class="text-faded no-margin">กลุ่มเลือด</p>
                <p class="no-margin q-pl-xs">{{ employee.blood_group }}</p>
              </q-card-main>
            </q-card>
          </div>
          <div class="col-xs-10 col-md-4 col-lg-4 text-center">
            <q-card>
              <q-card-title class="bg-primary text-white">
                ข้อมูลวันที่ต่างๆ
              </q-card-title>
              <q-card-main class="text-left">
                <p class="text-faded no-margin">วันเกิด (อายุตัว)</p>
                <p class="no-margin q-pl-xs">{{ employee.birth_date | dateFormatTh }} ({{ employee.age }} ปี)</p>
                <p class="text-faded no-margin">วันเข้าทำงาน (อายุงาน)</p>
                <p class="no-margin q-pl-xs">{{ employee.entry_date | dateFormatTh }} ({{ employee.work_age }})</p>
                <p class="text-faded no-margin">วันบรรจุ</p>
                <p class="no-margin q-pl-xs">{{ employee.assign_date | dateFormatTh}}</p>
                <p class="text-faded no-margin">วันเกษียณอายุ (อายุงานคงเหลือ)</p>
                <p class="no-margin q-pl-xs">{{ employee.retire_date | dateFormatTh}} ({{employee.remain_work_age }})</p>
                <p class="text-faded no-margin">วันที่เลื่อนระดับ (อายุงานในระดับ)</p>
                <p class="no-margin q-pl-xs">{{ employee.level_date | dateFormatEnToTh}} ({{ employee.level_work_age }})</p>
              </q-card-main>
            </q-card>
          </div>
          <div class="col-xs-10 col-md-12 col-lg-10 text-center">
            <q-card>
              <q-card-title class="bg-primary text-white">
                ตำแหน่ง
              </q-card-title>
              <q-card-main
                class="text-left"
                v-if="employee.positions"
              >
                <q-list
                  no-border
                  separator
                >
                  <q-item
                    v-for="(position, index) in employee.positions"
                    :key="index"
                    multiline
                  >
                    <q-item-main>
                      <q-item-tile
                        label
                        lines="5"
                      >{{ position.position_full + " (" + position.position_abb + ")"}}</q-item-tile>
                      <q-item-tile
                        sublabel
                        lines="10"
                      >
                        <span> {{position.section_full}}</span>
                        <span> {{position.department_full}}</span>
                        <span> {{position.division_full}}</span>
                        <span> {{position.assistant_full}}</span>
                        <span> {{position.deputy_full}}</span>
                        (
                        <span> {{position.section_abb}}</span>
                        <span> {{position.department_abb}}</span>
                        <span> {{position.division_abb}}</span>
                        <span> {{position.assistant_abb}}</span>
                        <span> {{position.deputy_abb}}</span>
                        )
                      </q-item-tile>
                    </q-item-main>
                  </q-item>
                </q-list>
              </q-card-main>
            </q-card>
          </div>
          <div class="col-xs-10 col-md-12 col-lg-10 text-center">
            <q-card>
              <q-card-title class="bg-primary text-white">
                การศึกษา
              </q-card-title>
              <q-card-main
                class="text-left"
                v-if="employee.educations"
              >
                <q-list
                  no-border
                  separator
                >
                  <q-item
                    v-for="(education, index) in employee.educations"
                    :key="index"
                  >
                    {{ education.degree_name + ' ' + education.certificate_name + ' ' + education.branch_name}} {{ education.school_name }} GPA.= {{ education.grade }} (ปีจบการศึกษา {{ education.graduated_year | convertToThaiYear}}) {{ education.degree_main=="X"?"(วุฒิหลัก)":""}} {{ education.degree_entry=="X"?"(วุฒิแรกเข้า)":""}}
                  </q-item>
                </q-list>
              </q-card-main>
            </q-card>
          </div>
        </div>
      </q-modal-layout>
    </q-modal>

    <q-modal v-model="filterOpened">
      <div class="q-pa-md">
        <h4>ตัวกรอง</h4>
        <div class="row">
          <div class="col-3">ระดับ</div>
          <div class="col-9">
            <q-range
              v-model="filter.level"
              :min="0"
              :max="14"
              :step="1"
              label
              snap
              color="secondary"
              label-always
            />
          </div>
        </div>
        <div class="row">
          <div class="col-6">เฉพาะผบ.</div>
          <div class="col-6">
            <q-toggle
              v-model="filter.onlyBoss"
              color="secondary"
            />
          </div>
        </div>
        <div class="row">
          <div class="col-6">เรียงลำดับอาวุโส</div>
          <div class="col-6">
            <q-toggle
              v-model="filter.orderBySenior"
              color="secondary"
            />
          </div>
        </div>
        <div class="row q-mt-lg">
          <div class="col-12">
            <q-btn
              color="primary"
              @click="search"
              label="ค้นหา"
            />
            <q-btn
              class="q-ml-sm"
              @click="clearFilter"
              label="ล้างค่า"
            />
            <q-btn
              class="q-ml-sm"
              color="red"
              @click="filterOpened = false"
              label="ปิด"
            />
          </div>
        </div>
      </div>
    </q-modal>
  </q-page>
</template>

<script>
import BackToTop from 'vue-backtotop'
import { QModalLayout } from 'quasar'
export default {
  components: {
    BackToTop,
    QModalLayout
  },
  filters: {
    convertToThaiYear (year) {
      return parseInt(year) + 543
    },
    dateFormatEnToTh (date) {
      let dd = (date || '').split('.')
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
      return parseInt(dd[0]) + ' ' + ThaiMonth + ' ' + (parseInt(dd[2]) + 543)
    },
    dateFormatTh (date) {
      let dd = (date || '').split('.')
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
      return parseInt(dd[0]) + ' ' + ThaiMonth + ' ' + parseInt(dd[2])
    },
    blockColor (employee) {
      return !employee.is_boss ? '' : (parseInt(employee.level) === 14 || parseInt(employee.level) === 0 ? 'deep-orange-5'
        : (parseInt(employee.level) === 13 ? 'orange-5'
          : (parseInt(employee.level) === 12 ? 'green-5'
            : (parseInt(employee.level) === 11 && parseInt(employee.org_level) === 3 ? 'green-5'
              : (parseInt(employee.org_level) === 4 ? 'teal-5' : 'blue-5')))))
    }
  },
  // name: 'PageName',
  data () {
    return {
      searchText: '',
      filter: {
        level: {
          min: 0,
          max: 14
        },
        onlyBoss: false,
        orderBySenior: false
      },
      employees: [],
      total: 0,
      current_page: 0,
      last_page: 0,
      next_page_url: null,
      filterOpened: false,
      maximizedModal: false,
      showResult: false,
      pages: [],
      employee: {},
      message: '',
      min_length: 3
    }
  },
  computed: {
    isFiltered: function () {
      return this.filter.level.min !== 0 || this.filter.level.max !== 14 || this.filter.onlyBoss || this.filter.orderBySenior
    }
  },
  methods: {
    log (templocation) {
      if (typeof (templocation.wlfullname) === 'undefined' || templocation.wlfullname === null) {
        console.log(templocation)
      }
    },
    itemClicked (item) {
      this.employee = item
      this.maximizedModal = true
    },
    clearFilter () {
      this.filter.level.min = 0
      this.filter.level.max = 14
      this.filter.onlyBoss = false
      this.filter.orderBySenior = false
    },
    notify (eventName) {
      this.$q.notify(`Event "${eventName}" was triggered.`)
    },
    handle () {
      console.log('toggle')
    },
    initial () {
      this.total = 0
      this.employees = []
      this.current_page = 0
      this.last_page = 0
      this.next_page_url = null
      this.showResult = false
    },
    search () {
      this.filterOpened = false
      this.employees = []
      this.loadedPages = []
      if (this.searchText.length === 0) {
        this.initial()
      }
      if (this.searchText && this.searchText.length >= 3) {
        this.initial()
        let query = ''
        this.showResult = true
        this.message = 'กำลังค้นหา......'

        if (this.filter.level.min !== 0 || this.filter.level.max !== 14) {
          query += 'levelMin=' + this.filter.level.min + '&levelMax=' + this.filter.level.max
        }
        if (this.filter.onlyBoss) {
          query += (query === '' ? 'onlyBoss=' : '&onlyBoss=') + this.filter.onlyBoss
        }
        if (this.filter.orderBySenior) {
          query += (query === '' ? 'orderBySenior=' : '&orderBySenior=') + this.filter.orderBySenior
        }
        this.$axios.get('employees/' + this.searchText + (query !== '' ? '?' + query : ''))
          .then((res) => {
            if (res.data.data) {
              this.employees = []
              this.employees = res.data.data
              this.total = res.data.meta.total
              this.current_page = res.data.meta.current_page
              this.last_page = res.data.meta.last_page
              this.showResult = true
              this.next_page_url = res.data.links.next
              this.loadedPages.push(res.data.meta.current_page)
              if (this.employees.length === 0) {
                this.message = 'ไม่พบผลการค้นหา กรุณาระบุคำค้นให้ถูกต้อง'
              }
            }
          }).catch((e) => {
            this.$q.dialog({
              color: 'negative',
              message: e.message,
              icon: 'report_problem',
              ok: 'ok'
            }).then(() => {
              // this.$router.push({name: 'login'})
            })
          })
      } else {
        this.employees = []
        this.showResult = true
        this.total = 0
        this.message = 'กรุณาระบุคำค้นจำนวน ' + this.min_length + ' ตัวอักษรขึ้นไป'
      }
    },
    loadMore (index, done) {
      setTimeout(() => {
        if ((this.next_page_url)) {
          this.$axios.get(this.next_page_url)
            .then((res) => {
              if (!this.loadedPages.includes(res.data.meta.current_page)) {
                console.log('loadmore ' + res.data.meta.current_page)
                this.employees = this.employees.concat(res.data.data)
                this.current_page = res.data.meta.current_page
                this.next_page_url = res.data.links.next
                this.loadedPages.push(res.data.meta.current_page)
              }
            }).catch(() => {
              this.$q.dialog({
                color: 'negative',
                message: 'ไม่สามารถเชื่อมต่อข้อมูลได้',
                icon: 'report_problem',
                ok: 'ok'
              }).then(() => {
                // this.$router.push({name: 'login'})
              })
            })
        }
        done()
      }, 5000)
    }
  }
}
</script>

<style>
</style>
