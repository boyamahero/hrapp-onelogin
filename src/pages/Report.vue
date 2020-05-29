<template>
  <q-page padding>
    <div class="row bg-teal-1">
      <div class="col">

        <div class="row">
          <div class="col">
            <q-toolbar color="secondary">
              <q-btn
                flat
                round
                dense
                icon="filter_list"
                @click="showFilter = !showFilter"
              />
              <!--
                For Toolbar title, we use
                QToolbarTitle component
              -->
              <q-toolbar-title>
                ตัวกรอง
              </q-toolbar-title>

              <!--
                In a Toolbar, buttons are best
                configured as "flat, round, dense" and with an icon,
                but any button will do
              -->
              <q-btn
                flat
                round
                dense
                :icon="showFilter ? 'keyboard_arrow_up':'keyboard_arrow_down'"
                @click="showFilter = !showFilter"
              />
            </q-toolbar>
          </div>
        </div>
        <div
          class="row"
          v-if="showFilter"
        >
          <div class="col">
            <div class="row">
              <div class="col-12">
                <q-input
                  v-model="organizationName"
                  type="text"
                  placeholder="สังกัดย่อ"
                  color="green"
                  inverted
                  :before="[{icon: 'account_tree',color: 'secondary', handler () {}}]"
                  class="q-mx-md q-ma-sm"
                  clearable
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <q-select
                  multiple
                  chips
                  color="green"
                  inverted
                  float-label="ประเภทผู้ปฏิบัติงาน"
                  v-model="employeeTypeMultipleSelect"
                  :options="employeeTypeOptions"
                  class="q-mx-md q-ma-sm"
                />
              </div>
              <div class="col-12 col-md-6">
                <q-select
                  color="green"
                  inverted
                  float-label="ตำแหน่งตามคุณวุฒิ"
                  v-model="shortPositionKeyMultipleSelect"
                  :options="shortPositionKeyOptions"
                  clearable
                  class="q-mx-md q-ma-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <q-select
                  color="green"
                  inverted
                  float-label="เพศ"
                  v-model="genderSelect"
                  :options="genderOptions"
                  clearable
                  class="q-mx-md q-ma-sm"
                />
              </div>
              <div class="col-12 col-md-6">
                <q-select
                  color="green"
                  inverted
                  float-label="ศาสนา"
                  v-model="religionSelect"
                  :options="religionOptions"
                  clearable
                  class="q-mx-md q-ma-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6">
                <q-select
                  color="green"
                  inverted
                  float-label="ระดับคุณวุฒิ"
                  v-model="educationLevelSelect"
                  :options="educationLevelOptions"
                  clearable
                  class="q-mx-md q-ma-sm"
                />
              </div>
              <div
                class="col-12 col-md-6"
                v-if="!isActive"
              >
                <q-select
                  color="green"
                  inverted
                  float-label="เหตุผลสิ้นสภาพ"
                  v-model="withdrawTypeSelect"
                  :options="withdrawTypeOptions"
                  clearable
                  class="q-mx-md q-ma-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  ระดับ
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ level.min }} ถึง {{ level.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="level"
                  color="green"
                  :min="0"
                  :max="14"
                  inverted
                  class="q-mb-sm"
                />
              </div>
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  ปีเข้างาน
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ entryYear.min }} ถึง {{ entryYear.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="entryYear"
                  color="green"
                  :min="entryYearValid.min"
                  :max="entryYearValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  ปีเกิด
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ birthYear.min }} ถึง {{ birthYear.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="birthYear"
                  color="green"
                  :min="birthYearValid.min"
                  :max="birthYearValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  เดือนเกิด
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ birthMonth.min }} ถึง {{ birthMonth.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="birthMonth"
                  color="green"
                  :min="birthMonthValid.min"
                  :max="birthMonthValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  อายุ
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ age.min }} ถึง {{ age.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="age"
                  color="green"
                  :min="ageValid.min"
                  :max="ageValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  อายุงาน
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ workAge.min }} ถึง {{ workAge.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="workAge"
                  color="green"
                  :min="workAgeValid.min"
                  :max="workAgeValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 q-px-md">
                <p class="caption text-green">
                  ปีเกษียณ
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ retireYear.min }} ถึง {{ retireYear.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="retireYear"
                  color="green"
                  :min="retireYearValid.min"
                  :max="retireYearValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
              <div
                class="col-12 col-md-6 q-px-md"
                v-if="!isActive"
              >
                <p class="caption text-green">
                  ปีสิ้นสภาพ
                  <span class="chip-container">
                    <q-chip
                      square
                      color="green"
                    >
                      {{ withdrawYear.min }} ถึง {{ withdrawYear.max }}
                    </q-chip>
                  </span>
                </p>
                <q-range
                  v-model="withdrawYear"
                  color="green"
                  :min="withdrawYearValid.min"
                  :max="withdrawYearValid.max"
                  inverted
                  class="q-mb-sm"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  คงสภาพผู้ปฏิบัติงาน
                </p>
                <q-toggle
                  v-model="isActive"
                  color="green"
                  class="q-mx-md q-mb-sm"
                  @input="activeChange"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  โครงการ
                </p>
                <q-toggle
                  v-model="isProject"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  ผู้บังคับบัญชา
                </p>
                <q-toggle
                  v-model="isBossOnly"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  ผู้บังคับบัญชาโครงการ
                </p>
                <q-toggle
                  v-model="isBossProjectOnly"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <q-btn
          :loading="loading"
          color="primary"
          @click="handler"
          label="Export"
          class="q-mt-sm"
        />
      </div>
    </div>
  </q-page>
</template>

<script>
import XLSX from 'xlsx' // import xlsx
import { date } from 'quasar'

const today = new Date()
const { startOfDate, addToDate, subtractFromDate } = date

var qs = require('qs')

export default {
  name: 'Report',
  data () {
    return {
      loading: false,
      showFilter: true,
      employeeTypeMultipleSelect: [],
      employeeTypeOptions: [
        { label: 'พนักงาน', value: 100 },
        { label: 'ลูกจ้างทดลองงาน', value: 200 },
        { label: 'พนักงานสัญญาจ้างพิเศษ', value: 400 },
        { label: 'ลูกจ้างชั่วคราวตามฤดูกาล', value: 500 },
        { label: 'ลูกจ้างพิเศษ', value: 800 }
      ],
      shortPositionKeyMultipleSelect: null,
      shortPositionKeyOptions: [
        { label: 'วิศวกร', value: 'วศ.' },
        { label: 'สถาปนิก', value: 'สถ.' },
        { label: 'นักธรณีวิทยา', value: 'นธ.' },
        { label: 'นักวิทยาศาสตร์', value: 'วท.' },
        { label: 'นักเดินเรือ', value: 'นร.' },
        { label: 'นักบิน', value: 'นบ.' },
        { label: 'นายแพทย์', value: 'นพ.' },
        { label: 'ทันตแพทย์', value: 'ทพ.' },
        { label: 'เภสัชกร', value: 'ภส.' },
        { label: 'พยาบาลปริญญา', value: 'พบ.' },
        { label: 'นักวิทยาศาสตร์การแพทย์', value: 'วพ.' },
        { label: 'นิติกร', value: 'นต.' },
        { label: 'นักบัญชี', value: 'บช.' },
        { label: 'เศรษฐกร', value: 'ศก.' },
        { label: 'ผู้ตรวจสอบภายใน', value: 'ตส.' },
        { label: 'วิทยากร', value: 'วก.' },
        { label: 'นักคอมพิวเตอร์', value: 'นค.' },
        { label: 'ช่าง', value: 'ช.' },
        { label: 'พนักงานวิชาชีพ', value: 'พช.' },
        { label: 'พยาบาล', value: 'พ.' },
        { label: 'ช่างชำนาญการ', value: 'ชก.' },
        { label: 'พนักงานขับเครื่องจักรกล', value: 'พขก.' },
        { label: 'พนักงานขับรถ', value: 'พขร.' },
        { label: 'พนักงานขับเรือ', value: 'พร.' },
        { label: 'หัวหน้าพนักงานรักษาความปลอดภัย', value: 'พรป.' },
        { label: 'พนักงานรักษาความปลอดภัย', value: 'รป.' }
      ],
      genderSelect: null,
      genderOptions: [
        { label: 'ชาย', value: 1 },
        { label: 'หญิง', value: 2 }
      ],
      religionSelect: null,
      religionOptions: [
        { label: 'พุทธ', value: 'พุทธ' },
        { label: 'คริสต์', value: 'คริสต์' },
        { label: 'ฮินดู', value: 'ฮินดู' },
        { label: 'อิสลาม', value: 'อิสลาม' },
        { label: 'ซิกซ์', value: 'ซิกซ์' },
        { label: 'อื่นๆ', value: 'อื่นๆ' }
      ],
      educationLevelSelect: null,
      educationLevelOptions: [
        { label: 'ปริญญาเอก', value: 'ปริญญาเอก' },
        { label: 'ปริญญาโท', value: 'ปริญญาโท' },
        { label: 'ปริญญาตรี', value: 'ปริญญาตรี' },
        { label: 'ปวส.', value: 'ปวส.' },
        { label: 'ปวช.', value: 'ปวช.' },
        { label: 'ต่ำกว่า ปวช.', value: 'ต่ำกว่า ปวช.' }
      ],
      withdrawTypeSelect: null,
      withdrawTypeOptions: [
        { label: 'ถึงแก่กรรม', value: '10' },
        { label: 'ลาออก', value: '20' },
        { label: 'ให้ออก', value: '30' },
        { label: 'ปลดออก', value: '40' },
        { label: 'เกษียณอายุ', value: '50' },
        { label: 'สิ้นกำหนดการจ้าง', value: '60' },
        { label: 'ออกจากงานด้วยความยินดีฯ', value: '70' },
        { label: 'เลิกจ้าง', value: '80' }
      ],
      level: {
        min: 0,
        max: 14
      },
      entryYear: {
        min: 2512,
        max: (new Date()).getFullYear() + 543
      },
      birthYear: {
        min: 2475,
        max: (new Date()).getFullYear() + 543
      },
      birthMonth: {
        min: 1,
        max: 12
      },
      age: {
        min: 15,
        max: 65
      },
      workAge: {
        min: 0,
        max: 45
      },
      retireYear: {
        min: (new Date()).getMonth() > 9 ? (new Date()).getFullYear() + 1 + 543 : (new Date()).getFullYear() + 543,
        max: (new Date()).getMonth() > 9 ? (new Date()).getFullYear() + 61 + 543 : (new Date()).getFullYear() + 60 + 543
      },
      withdrawYear: {
        min: 2512,
        max: (new Date()).getFullYear() + 543
      },
      entryBeginDate: null,
      entryEndDate: null,
      today,
      tomorrow: addToDate(today, { days: 1 }),
      yesterday: subtractFromDate(today, { days: 1 }),
      state: new Date(),
      defaultValue: startOfDate(today, 'year'),
      isActive: true,
      isProject: false,
      isBossOnly: false,
      isBossProjectOnly: false,
      organizationName: 'หบค-ห.',
      persons: [],
      filter: [],
      include: [],
      sort: [],
      query: [],
      meta: []
    }
  },
  computed: {
    entryYearValid () {
      var d = new Date()
      return { min: 2512, max: d.getFullYear() + 543 }
    },
    birthYearValid () {
      var d = new Date()
      return { min: 2475, max: d.getFullYear() + 543 }
    },
    birthMonthValid () {
      return { min: 1, max: 12 }
    },
    ageValid () {
      return { min: 15, max: 65 }
    },
    workAgeValid () {
      return { min: 0, max: 45 }
    },
    retireYearValid () {
      return { min: (new Date()).getMonth() > 9 ? (new Date()).getFullYear() + 543 + 1 : (new Date()).getFullYear() + 543, max: (new Date()).getMonth() > 9 ? (new Date()).getFullYear() + 1 + 60 + 543 : (new Date()).getFullYear() + 60 + 543 }
    },
    withdrawYearValid () {
      return { min: 2512, max: (new Date()).getFullYear() + 543 }
    }
  },
  methods: {
    activeChange () {
      if (this.isActive) {
        this.withdrawTypeSelect = null
        this.withdrawYear.min = 2512
        this.withdrawYear.max = (new Date()).getFullYear() + 543
      }
    },
    handler () {
      this.query['sort'] = 'senior'
      this.query['include'] = 'organizations'
      if (!this.isActive) {
        this.query['filter[IsActive]'] = this.isActive
      } else {
        delete this.query['filter[IsActive]']
      }
      if (this.organizationName !== '') {
        this.query['filter[OrganizationName]'] = this.organizationName
      } else {
        delete this.query['filter[OrganizationName]']
      }
      if (this.employeeTypeMultipleSelect.length) {
        this.query['filter[PersonType]'] = this.employeeTypeMultipleSelect.join(',')
      } else {
        delete this.query['filter[PersonType]']
      }
      if (this.shortPositionKeyMultipleSelect) {
        this.query['filter[ShortPositionKey]'] = this.shortPositionKeyMultipleSelect
      } else {
        delete this.query['filter[ShortPositionKey]']
      }
      if (this.genderSelect) {
        this.query['filter[Gender]'] = this.genderSelect
      } else {
        delete this.query['filter[Gender]']
      }
      if (this.religionSelect) {
        this.query['filter[Religion]'] = this.religionSelect
      } else {
        delete this.query['filter[Religion]']
      }
      if (this.educationLevelSelect) {
        this.query['filter[EducationLevel]'] = this.educationLevelSelect
      } else {
        delete this.query['filter[EducationLevel]']
      }
      if (this.withdrawTypeSelect) {
        this.query['filter[WithdrawType]'] = this.withdrawTypeSelect
      } else {
        delete this.query['filter[WithdrawType]']
      }
      if (this.level.min === 0 && this.level.max === 14) {
        delete this.query['filter[Level]']
      } else {
        this.query['filter[Level]'] = this.level.min + ',' + this.level.max
      }
      if (this.entryYear.min === this.entryYearValid.min && this.entryYear.max === this.entryYearValid.max) {
        delete this.query['filter[EntryYear]']
      } else {
        this.query['filter[EntryYear]'] = this.entryYear.min + ',' + this.entryYear.max
      }
      if (this.isProject) {
        this.query['filter[IsProject]'] = this.isProject
      } else {
        delete this.query['filter[IsProject]']
      }
      if (this.isBossOnly) {
        this.query['filter[IsBoss]'] = this.isBossOnly
      } else {
        delete this.query['filter[IsBoss]']
      }
      if (this.isBossProjectOnly) {
        this.query['filter[IsBossProject]'] = this.isBossProjectOnly
      } else {
        delete this.query['filter[IsBossProject]']
      }
      if (this.birthYear.min === this.birthYearValid.min && this.birthYear.max === this.birthYearValid.max) {
        delete this.query['filter[BirthYear]']
      } else {
        this.query['filter[BirthYear]'] = this.birthYear.min + ',' + this.birthYear.max
      }
      if (this.birthMonth.min === this.birthMonthValid.min && this.birthMonth.max === this.birthMonthValid.max) {
        delete this.query['filter[BirthMonth]']
      } else {
        this.query['filter[BirthMonth]'] = this.birthMonth.min + ',' + this.birthMonth.max
      }
      if (this.age.min === this.ageValid.min && this.age.max === this.ageValid.max) {
        delete this.query['filter[Age]']
      } else {
        this.query['filter[Age]'] = this.age.min + ',' + this.age.max
      }
      if (this.workAge.min === this.workAgeValid.min && this.workAge.max === this.workAgeValid.max) {
        delete this.query['filter[WorkAge]']
      } else {
        this.query['filter[WorkAge]'] = this.workAge.min + ',' + this.workAge.max
      }
      if (this.retireYear.min === this.retireYearValid.min && this.retireYear.max === this.retireYearValid.max) {
        delete this.query['filter[RetireYear]']
      } else {
        this.query['filter[RetireYear]'] = this.retireYear.min + ',' + this.retireYear.max
      }
      if (this.withdrawYear.min === this.withdrawYearValid.min && this.withdrawYear.max === this.withdrawYearValid.max) {
        delete this.query['filter[WithdrawYear]']
      } else {
        this.query['filter[WithdrawYear]'] = this.withdrawYear.min + ',' + this.withdrawYear.max
      }
      // console.log(this.query)
      this.loading = true
      // we simulate a delay here:
      this.$axios.get('persons', {
        params: this.query,
        paramsSerializer: function (params) {
          return qs.stringify(params, { arrayFormat: 'repeat' })
        }
      })
        .then((res) => {
          this.meta = res.data.meta
          this.persons = []
          res.data.data.forEach(person => {
            let rowPerson = person
            if (rowPerson.organizations) {
              rowPerson.organizations.forEach(organization => {
                delete person.organizations
                Object.assign(person, organization)
                this.persons.push(person)
                person = rowPerson
              })
            }
          })
          this.onExport()
          this.loading = false
        }).catch((error) => {
          this.loading = false
          this.$q.dialog({
            color: 'negative',
            message: error.response.data.message || 'ไม่สามารถเชื่อมต่อกับแม่ข่ายได้',
            icon: 'report_problem',
            ok: 'ok'
          })
        })
    },
    onExport () {
      const dataWS = XLSX.utils.json_to_sheet(this.persons)
      const wb = XLSX.utils.book_new()
      if (!wb.Custprops) wb.Custprops = {}
      wb.Custprops['Create By'] = this.meta.request_by
      wb.Custprops['Data Date'] = this.meta.updated_at
      XLSX.utils.book_append_sheet(wb, dataWS)
      XLSX.writeFile(wb, 'export.xlsx')
    }
  }
}
</script>

<style>
</style>
