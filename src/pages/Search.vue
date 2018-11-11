<template>
  <q-page padding>
    <div class="container">
      <q-search
        v-model="searchText"
        :debounce="1000"
        placeholder="ชื่อ/นามสกุล/สังกัดย่อ/เลขประจำตัว"
        icon="person"
        float-label="คำค้น"
        color="secondary"
        clearable
        inverted
        @change="val => { searchText = val }"
        @input="search"
      />
      <div v-if="total > 0">ผลการค้นหา {{ total }} ท่าน</div>
      <q-infinite-scroll :handler="loadMore" ref="infiniteScroll">
        <q-card v-for="(employee, index) in employees" :key="index">
          <q-item>
            <q-item-side :avatar="employee.image_path" />
            <q-item-main>
              <q-item-tile label>{{ employee.name }} ({{ employee.id }})</q-item-tile>
              <q-item-tile sublabel>{{ employee.position_full }}</q-item-tile>
              <q-item-tile sublabel>อาคาร {{ employee.building }} ห้อง {{employee.room}}</q-item-tile>
              <q-item-tile sublabel>โทร. {{ employee.phone }}</q-item-tile>
            </q-item-main>
          </q-item>
        </q-card>
        <div class="row justify-center" style="margin-bottom: 50px;" v-if="next_page_url">
          <q-spinner-dots slot="message" :size="40" />
        </div>
      </q-infinite-scroll>
    </div>
  </q-page>
</template>

<script>
export default {
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
