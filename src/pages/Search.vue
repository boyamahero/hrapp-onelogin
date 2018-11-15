<template>
  <q-page>
      <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-card class="q-mx-md q-mb-xs q-mt-md">
      <q-card-main>
         <p class="header">ค้นหาข้อมูลผู้ปฎิบัติงาน</p>
         <div class="row q-ma-md">
        <q-search
        class="full-width"
        v-model="searchText"
        :debounce="1000"
        placeholder="ชื่อ/นามสกุล/สังกัดย่อ/เลขประจำตัว"
        icon="person"
        float-label="คำค้น"
        color="blue-5"
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
      <div class="row justify-center">
        <div class="col-md-9 col-xs-12 justify-between">
          <div class="row justify-between">
        <div v-if="total > 0" class="q-ma-md self-center">พบผลการค้นหาจำนวน {{ total }} ท่าน</div>
        <div v-if="total > 0" class="q-ma-md"> <q-icon name="filter_list" size="1.5rem" @click.native="handle"/> </div>
      </div>
      </div>
      </div>
      <!-- <q-item-separator /> -->
      <div class="row justify-center">
        <div class="col-md-9 col-xs-12 justify-between">
      <q-infinite-scroll :handler="loadMore" ref="infiniteScroll">
        <q-card v-for="(employee, index) in employees" :key="index">
          <q-item>
            <q-item-side>
            <img :src="employee.image_path" class="avatarList">
          </q-item-side>
            <q-item-main>
              <q-item-tile class="q-body-1 text-weight-bold">{{ employee.name }} ({{ employee.id }})</q-item-tile>
              <q-item-tile class="q-body-1"><q-icon name="work" /> {{ employee.position_abb }}</q-item-tile>
              <q-item-tile class="q-body-1"><q-icon name="business" /> {{ employee.org_path }}</q-item-tile>
              <q-item-tile class="q-body-1" v-if="employee.building.trim() !== '-' || employee.room !== '-'"><q-icon name="room" /> {{ employee.building }} <span v-if="employee.room &&  employee.room!='-'">ห้อง {{employee.room.replace('ห้อง','')}} </span></q-item-tile>
              <q-item-tile class="q-body-1" v-if="employee.phone &&  employee.phone!='-'"><q-icon name="call" /> {{ employee.phone }}</q-item-tile>
            </q-item-main>
          </q-item>
        </q-card>
        <back-to-top bottom="100px" right="10px">
          <button type="button" class="btn btn-info btn-to-top"><i class="fa fa-chevron-up"></i></button>
        </back-to-top>
        <div class="row justify-center" style="margin-bottom: 20px;" v-if="next_page_url">
          <q-spinner-dots slot="message" :size="40" />
        </div>
      </q-infinite-scroll>
      </div>
      </div>
  </q-page>
</template>

<script>
import BackToTop from 'vue-backtotop'
export default {
  components: {
    BackToTop
  },
  // name: 'PageName',
  data () {
    return {
      searchText: '',
      employees: [],
      total: 0,
      current_page: 0,
      last_page: 0,
      next_page_url: null

    }
  },
  methods: {
    handle () {
      console.log('toggle')
    },
    search () {
      if ((this.searchText && this.searchText.length > 2) || (this.searchText.length === 0)) {
        this.$axios.get('search/' + this.searchText)
          .then((res) => {
            this.employees = res.data.data
            this.total = res.data.total
            this.current_page = res.data.current_page
            this.last_page = res.data.last_page
            this.next_page_url = res.data.next_page_url
          })
      }
    },
    loadMore (index, done) {
      setTimeout(() => {
        if ((this.next_page_url)) {
          this.$axios.get(this.next_page_url)
            .then((res) => {
              console.log('loadmore')
              this.employees = this.employees.concat(res.data.data)
              this.current_page = res.data.current_page
              this.next_page_url = res.data.next_page_url
            })
        }
        done()
      }, 3000)
    }
  }
}
</script>

<style>
</style>
