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
                  multiple
                  chips
                  color="green"
                  inverted
                  float-label="ตำแหน่งตามคุณวุฒิ"
                  v-model="ShortPositionKeyMultipleSelect"
                  :options="ShortPositionKeyOptions"
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
                  v-model="GenderSelect"
                  :options="GenderOptions"
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
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  เฉพาะผู้ปฏิบัติคงสภาพ
                </p>
                <q-toggle
                  v-model="isActive"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  เฉพาะโครงการ
                </p>
                <q-toggle
                  v-model="isProject"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  เฉพาะผู้บังคับบัญชา
                </p>
                <q-toggle
                  v-model="isBossOnly"
                  color="green"
                  class="q-mx-md q-mb-sm"
                />
              </div>
              <div class="col-6 col-md-3">
                <p class="caption text-green q-mx-md">
                  เฉพาะผู้บังคับบัญชาโครงการ
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
      ShortPositionKeyMultipleSelect: [],
      ShortPositionKeyOptions: [
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
      GenderSelect: null,
      GenderOptions: [
        { label: 'ชาย', value: 1 },
        { label: 'หญิง', value: 2 }
      ],
      level: {
        min: 0,
        max: 14
      },
      entryYear: {
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
    }
  },
  methods: {
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
      if (this.ShortPositionKeyMultipleSelect.length) {
        this.query['filter[ShortPositionKey]'] = this.ShortPositionKeyMultipleSelect.join(',')
      } else {
        delete this.query['filter[ShortPositionKey]']
      }
      if (this.GenderSelect) {
        this.query['filter[Gender]'] = this.GenderSelect
      } else {
        delete this.query['filter[Gender]']
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
            if (person.organizations) {
              person.organizations.forEach(organization => {
                Object.assign(person, organization)
                delete person.organizations
                this.persons.push(person)
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
