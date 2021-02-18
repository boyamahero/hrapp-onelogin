<template>
  <q-modal
      v-model="value"
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
            @click="onClickCloseButton"
            icon="close"
          />
        </q-toolbar>
        <div class="row justify-center gutter-sm q-pa-sm">
          <div class="col-xs-10 col-md-4 col-lg-2 text-center">
            <q-card>
              <q-card-media class="q-py-md q-px-md">
                <img v-auth-image="employee.image_path + '/220' || ''" v-if="value">
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
                <p class="no-margin q-pl-xs">{{ employee.level_date | dateFormatEnToTh}} ({{ employee.level_work_age | age}})</p>
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
</template>

<script>
// This is where your Javascript goes
// to define your Vue component, which
// can be a Layout, a Page or your own
// component used throughout the app.
import { QModalLayout } from 'quasar'

export default {
  components: {
    QModalLayout
  },
  props: ['employee', 'value'],
  filters: {
    convertToThaiYear (year) {
      return parseInt(year) + 543
    },
    age (age) {
      return age === '' ? '0 ป. 0 ด.' : age
    },
    dateFormatEnToTh (date) {
      let dd = (date || '').split('.')
      let ThaiMonth = ''
      switch (dd[1]) {
        case '00':
          ThaiMonth = ''
          break
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
      return ThaiMonth === '' ? '-' : (parseInt(dd[0]) + ' ' + ThaiMonth + ' ' + (parseInt(dd[2]) + 543))
    },
    dateFormatTh (date) {
      let dd = (date || '').split('.')
      let ThaiMonth = ''
      switch (dd[1]) {
        case '00':
          ThaiMonth = ''
          break
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
      return ThaiMonth === '' ? '-' : (parseInt(dd[0]) + ' ' + ThaiMonth + ' ' + parseInt(dd[2]))
    }
  },
  methods: {
    onClickCloseButton () {
      this.$emit('input', !this.value)
    }
  }
}
</script>

<style>
/* This is where your CSS goes */
</style>
