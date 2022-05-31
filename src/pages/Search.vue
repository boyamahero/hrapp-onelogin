<template>
  <q-page>
    <!-- <snowflask/> -->
    <!-- search box -->
    <div class="row justify-center q-pt-none q-pt-none">
      <div class="col-12">
        <q-card class="q-mx-md q-mb-xs q-mt-md">
          <q-card-main>
            <div class="row q-ma-md">
              <q-search
                class="full-width"
                v-model="searchText"
                :debounce="2000"
                placeholder="ชื่อ/นามสกุล(TH/EN)/ สังกัด(ย่อ/เต็ม)/ ตำแหน่งย่อ/ เลขประจำตัว/ อีเมล/เลขา สังกัดย่อ"
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
    <!-- count result and filter -->
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
    <!-- results set -->
    <div class="row justify-center">
      <div class="col-xs-12 col-md-10 col-lg-8 justify-between">
        <q-infinite-scroll
          :handler="loadMore"
          ref="infiniteScroll"
        >
          <q-card
            v-for="(employee, index) in employees" :key="index"
            :color="employee | blockColor"
          >
            <q-item>
              <q-item-side>
                <div class="row no-margin text-center">
                  <div
                    class="col-12"
                    :id="employee.image_path"
                  >
                    <lazy-component :key="employee.image_path">
                    <img
                      v-auth-image="employee.image_path"
                      style="width: 75px;border-radius: 20%"
                      draggable="false"
                      oncontextmenu="return false"
                      v-if="employee.image_path.includes(employee.code)"
                    />
                    </lazy-component>
                  </div>
                  <div class="col-12">
                    <q-icon
                      v-if="employee.can_open"
                      name="fas fa-search-plus"
                      @click.native="openModal(employee)"
                      :color="employee.is_boss?'white':'primary'"
                    />
                  </div>
                </div>
              </q-item-side>
              <q-item-main>
                <q-item-tile class="q-body-1 text-weight-bold">
                  {{ employee.name }} ({{ employee.code }})
                  <q-chip
                    v-if="employee.work_from_home.length > 0"
                    color="deep-orange" text-color="white" icon="fas fa-home" dense>
                    WFH
                    <q-tooltip
                      class="q-body-2 text-white text-bold bg-deep-orange"
                      v-for="(wfh, index) in employee.work_from_home"
                      :key="index"
                      :offset="[5, 5]"
                    >
                      WFH {{wfh.BeginDate}} {{wfh.BeginTime}} - {{wfh.EndDate}} {{wfh.EndTime}}
                    </q-tooltip>
                  </q-chip>
                  <q-chip
                    v-if="employee.work_from_any_where.length > 0"
                    color="deep-orange" text-color="white" icon="fas fa-globe-americas" dense>
                    WFA
                    <q-tooltip
                      class="q-body-2 text-white text-bold bg-deep-orange"
                      v-for="(wfa, index) in employee.work_from_any_where"
                      :key="index"
                      :offset="[5, 5]"
                    >
                      WFA {{wfa.BeginDate}} {{wfa.BeginTime}} - {{wfa.EndDate}} {{wfa.EndTime}}
                    </q-tooltip>
                  </q-chip>
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
                      {{ employee.secretary? employee.position_full + ' ทนท.เลขานุการ ' + employee.secretary.position_boss.PST_TLongName : employee.position_full }}
                    </q-tooltip>
                    <span v-if="$q.platform.is.desktop">({{employee.secretary? employee.position_full + ' ' + employee.secretary.PATH_PositionName : employee.position_full }} )</span>
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
                    <q-icon name="room" /> {{ employee.templocation.Name }}
                    <q-icon
                      class="text-red"
                      style="margin-left : 10px;cursor: pointer"
                      v-if="employee.can_edit_work_location"
                      name="fas fa-edit"
                      @click.native="$router.push({ name: 'editwl_by_bp', params: {
                        employee_code: employee.code,
                        employee_name: employee.name,
                        employee_templocation: employee.templocation,
                        employee_person_location: employee.person_location
                        } })"
                    /></q-item-tile>
                  <q-item-tile class="q-body-1"> &nbsp;&nbsp;&nbsp;&nbsp; {{ employee.templocation.Building }}<span> ห้อง {{ employee.templocation.Room }}</span></q-item-tile>
                  <q-item-tile class="q-body-1">
                    <q-icon name="call" /> {{ employee.templocation.PhoneNumber }} {{employee.templocation.PhoneNumberFull ? '( '+employee.templocation.PhoneNumberFull+' )' :''}} </q-item-tile>
                  <q-item-tile
                    class="q-body-1"
                    v-if="employee.templocation.MobilePhoneNumber"
                  >
                  <div v-if="!employee.canshow_mobilephone">
                    <q-icon name="smartphone" /> {{ employee.templocation.MobilePhoneNumber }}
                    <q-chip
                    @click.native="showconsent({employee_code: employee.code,id: index,from: 'templocation'})"
                    style="cursor: pointer;padding-left:8px;"
                    color="cyan-2" text-color="black" icon="fas fa-eye" dense>
                    แสดงข้อมูล
                  </q-chip>
                  </div>
                  <div v-else>
                    <q-chip
                    @click.native="coppynumber(employee.templocation.MobilePhoneNumber)"
                    style="cursor: pointer;padding-left:8px;font-size:14px"
                    color="#000" text-color="black" dense>
                    <q-icon name="smartphone" /> {{employee.templocation.MobilePhoneNumber}}
                  </q-chip>
                    <q-btn
                      v-if="isMobile && $q.platform.is.cordova"
                      round dense type="a" :href="'tel:'+employee.templocation.MobilePhoneNumber" target="_blank"
                      icon="fa fa-phone-volume"
                      class="q-mx-sm"
                      color="cyan-2" text-color="black" label="โทรออก" />
                    <q-chip
                      v-else-if="isMobile"
                      class="q-mx-sm"
                      @click.native="callto(employee.templocation.MobilePhoneNumber)"
                      style="cursor: pointer;padding-left:8px;"
                      color="cyan-2" text-color="black" icon="fa fa-phone-volume" dense>
                      โทรออก
                    </q-chip>
                  </div>
                  </q-item-tile>
                </div>
                <div v-else-if='employee.person_location'>
                  <q-item-tile class="q-body-1">
                    <q-icon name="room" /> {{ employee.person_location.Name }}
                    <q-icon
                      class="text-red"
                      style="margin-left : 10px;cursor: pointer"
                      v-if="employee.can_edit_work_location"
                      name="fas fa-edit"
                      @click.native="$router.push({ name: 'editwl_by_bp', params: {
                        employee_code: employee.code,
                        employee_name: employee.name,
                        employee_person_location: employee.person_location
                        } })"
                    /></q-item-tile>
                  <q-item-tile class="q-body-1"> &nbsp;&nbsp;&nbsp;&nbsp; {{ employee.person_location.Building }}<span> ห้อง {{ employee.person_location.Room  }}</span></q-item-tile>
                  <q-item-tile class="q-body-1">
                    <q-icon name="call" /> {{ employee.person_location.PhoneNumber }}</q-item-tile>
                  <q-item-tile
                    class="q-body-1"
                    v-if="employee.person_location.MobilePhoneNumber"
                  >
                    <!-- <q-icon name="smartphone" /> {{ employee.person_location.MobilePhoneNumber }} -->
                    <div v-if="!employee.canshow_mobilephone">
                    <q-icon name="smartphone" /> {{ employee.person_location.MobilePhoneNumber }}
                    <q-chip
                    @click.native="showconsent({employee_code: employee.code,id: index,from: 'person_location'})"
                    style="cursor: pointer;padding-left:8px;"
                    color="cyan-2" text-color="black" icon="fas fa-eye" dense>
                    แสดงข้อมูล
                  </q-chip>
                  </div>
                  <div v-else>
                    <q-chip
                    @click.native="coppynumber(employee.person_location.MobilePhoneNumber)"
                    style="cursor: pointer;padding-left:8px;font-size:14px"
                    color="#000" text-color="black" dense>
                    <q-icon name="smartphone" /> {{employee.person_location.MobilePhoneNumber}}
                  </q-chip>
                    <q-btn
                      v-if="isMobile && $q.platform.is.cordova"
                      round dense type="a" :href="'tel:'+employee.person_location.MobilePhoneNumber" target="_blank"
                      icon="fa fa-phone-volume"
                      class="q-mx-sm"
                      color="cyan-2" text-color="black" label="โทรออก" />
                    <q-chip
                      v-else-if="isMobile"
                      class="q-mx-sm"
                      @click.native="callto(employee.person_location.MobilePhoneNumber)"
                      style="cursor: pointer;padding-left:8px;"
                      color="cyan-2" text-color="black" icon="fa fa-phone-volume" dense>
                      โทรออก
                    </q-chip>
                  </div>
                  </q-item-tile>
                </div>
                <div v-else>
                  <q-item-tile class="q-body-1">
                    <q-icon name="room" /> -
                    <q-icon
                      class="text-red"
                      style="margin-left : 10px;cursor: pointer"
                      v-if="employee.can_edit_work_location"
                      name="fas fa-edit"
                      @click.native="$router.push({ name: 'editwl_by_bp', params: {
                        employee_code: employee.code,
                        employee_name: employee.name
                        } })"
                    />
                    </q-item-tile>
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
             <q-modal v-model="showConsentModal"
             :content-css="{maxWidth: '40vw'}"
              minimized
              no-esc-dismiss
              no-backdrop-dismiss
              :passedObject="objectToPass"
              ref="modalRef">
            <div style="padding: 15px;">
            <div class="q-headline q-mb-md" :style="isMobile ? 'font-size: 16px' : null">ข้อตกลงและเงื่อนไขการใช้งาน</div>
            <q-alert color="red-4">
              <p  :style="isMobile ? 'font-size: 12px' : null">การใช้หรือเปิดเผยข้อมูลนอกเหนือจากวัตถุประสงค์เพื่อกิจการของ กฟผ. หรือเพื่อแสวงหาผลประโยชน์ที่มิควรได้โดยไม่ได้รับความยินยอมจากเจ้าของข้อมูล ต้องระวางโทษจำคุกไม่เกิน 6 เดือนถึง 1 ปี หรือปรับไม่เกิน 500,000 ถึง 1,000,000 บาท หรือทั้งจำทั้งปรับ
              <br>กรณีกดปุ่มยอมรับระบบจะบันทึกข้อมูลการเรียกดูเบอร์โทรศัพท์ เพื่อตรวจจับ ป้องกัน หรือตรวจสอบปัญหาด้านความปลอดภัย</p>
            </q-alert>
            <div class="row justify-between q-pa-lg">
              <q-btn color="white" text-color="red" v-close-overlay label="ไม่ยอมรับ" />
              <q-btn color="green" label="ยอมรับ" @click="requestmobilenumber(objectToPass)"/>
            </div>
            </div>
            </q-modal>
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
    <detail-modal :employee="employee" v-model="showDetailModal"></detail-modal>
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
import Snowflask from '../components/search/snowflask.vue'
import DetailModal from '../components/search/detail-modal.vue'
import { QModalLayout, openURL } from 'quasar'
export default {
  components: {
    BackToTop,
    QModalLayout,
    DetailModal,
    Snowflask
  },
  filters: {
    blockColor (employee) {
      return !employee.is_boss ? '' : parseInt(employee.level) === 0 ? 'red-5'
      : (parseInt(employee.level) === 14 ? 'deep-orange-5'
        : (parseInt(employee.level) === 13 ? 'orange-8'
          : (parseInt(employee.level) === 12 ? 'green-5'
            : (parseInt(employee.level) === 11 && parseInt(employee.org_level) === 3 ? 'green-5'
              : (parseInt(employee.org_level) === 4 ? 'teal-5' : 'blue-5')))))
    }
  },
  // name: 'PageName',
  data () {
    return {
      searchText: '',
      canshow_mobilephone: false,
      isMobile: this.$q.platform.is.mobile,
      filter: {
        level: {
          min: 0,
          max: 14
        },
        onlyBoss: false,
        orderBySenior: false
      },
      employees: [],
      loadedPages: [],
      total: 0,
      current_page: 0,
      last_page: 0,
      next_page_url: null,
      filterOpened: false,
      showDetailModal: false,
      showConsentModal: false,
      showResult: false,
      pages: [],
      employee: {},
      message: '',
      min_length: 3,
      objectToPass: []
    }
  },
  computed: {
    isFiltered: function () {
      return this.filter.level.min !== 0 || this.filter.level.max !== 14 || this.filter.onlyBoss || this.filter.orderBySenior
    }
  },
  methods: {
    showconsent (item) {
            this.showConsentModal = true
            this.objectToPass = item
    },
    log (templocation) {
      if (typeof (templocation.wlfullname) === 'undefined' || templocation.wlfullname === null) {
        console.log(templocation)
      }
    },
    openModal (item) {
      this.employee = item
      this.showDetailModal = !this.showDetailModal
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
    callto (phonenumber) {
      if (this.$q.platform.is.cordova) {
        openURL('tel:' + phonenumber)
      } else {
        window.location = 'tel:' + phonenumber
      }
    },
    requestmobilenumber (data) {
      this.$axios.get('mobile-phone/' + data.employee_code)
          .then((res) => {
            if (res.data.mobile_phone) {
              if (data.from === 'person_location') {
                  this.employees[data.id].person_location.MobilePhoneNumber = res.data.mobile_phone
              } else {
                  this.employees[data.id].templocation.MobilePhoneNumber = res.data.mobile_phone
              }
                this.employees[data.id].canshow_mobilephone = true
              this.showConsentModal = false
            }
          }).catch((e) => {
            this.$q.dialog({
              color: 'negative',
              message: 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            })
          })
    },
    coppynumber (phonenumber) {
      var textField = document.createElement('textarea')
      textField.innerText = phonenumber
      document.body.appendChild(textField)
      textField.select()
      document.execCommand('copy')
      textField.remove()
      this.$q.notify({
        message: 'คัดลอกเบอร์โทรแล้ว',
        size: 'md',
        position: 'center',
        color: 'green-2',
        textColor: 'black',
        timeout: 2000
        })
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
              this.loadedPages = []
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
              message: 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            }).then(() => {
              this.employees = []
              this.showResult = true
              this.total = 0
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
                message: 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้',
                icon: 'report_problem',
                ok: 'ok'
              }).then(() => {
                this.employees = []
                this.showResult = true
                this.total = 0
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
