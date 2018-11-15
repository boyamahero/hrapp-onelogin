<template>
  <q-page padding>
    <div class="container">
      <q-search
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
      <div class="row justify-between">
        <div v-if="total > 0" class="q-py-xs self-center text-small">พบผลการค้นหาจำนวน {{ total }} ท่าน</div>
        <div v-if="total > 0" class="q-pa-xs"> <q-icon name="filter_list" size="1.5rem" @click.native="handle"/> </div>
      </div>
      <q-item-separator />
      <q-infinite-scroll :handler="loadMore" ref="infiniteScroll">
        <q-card v-for="(employee, index) in employees" :key="index">
          <q-item>
            <q-item-side>
            <img :src="employee.image_path" class="avatarList">
          </q-item-side>
            <q-item-main>
              <q-item-tile class="q-body-1 text-small text-weight-bold">{{ employee.name }} ({{ employee.id }})</q-item-tile>
              <q-item-tile class="q-body-1 text-small"><q-icon name="work" /> {{ employee.position_abb }}</q-item-tile>
              <q-item-tile class="q-body-1 text-small"><q-icon name="business" /> {{ employee.org_path }}</q-item-tile>
              <q-item-tile class="q-body-1 text-small" v-if="employee.building.trim() !== '-' || employee.room !== '-'"><q-icon name="room" /> {{ employee.building }} <span v-if="employee.room &&  employee.room!='-'">ห้อง {{employee.room.replace('ห้อง','')}} </span></q-item-tile>
              <q-item-tile class="q-body-1 text-small" v-if="employee.phone &&  employee.phone!='-'"><q-icon name="call" /> {{ employee.phone }}</q-item-tile>
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
    handle () {
      console.log('toggle')
    },
    setNewToken (value) {
      if (value) {
        this.$axios.defaults.headers.common['Authorization'] = value
        localStorage.setItem('access_token', (value).replace('Bearer ', ''))
        this.$store.commit('retrieveToken', (value).replace('Bearer ', ''), { root: true })
      }
    },
    search () {
      if ((this.searchText && this.searchText.length > 2) || (this.searchText.length === 0)) {
        this.$axios.get('search/' + this.searchText,
          {headers: {
              'Authorization': `Bearer ${this.$store.state.token.token}`
            }
          })
          .then((res) => {
            this.employees = res.data.data
            this.total = res.data.total
            this.current_page = res.data.current_page
            this.last_page = res.data.last_page
            this.next_page_url = res.data.next_page_url
            this.setNewToken(res.headers.authorization)
          }).catch(() => {
            this.$q.dialog({
              color: 'negative',
              message: 'ไม่สามารถติดต่อฐานข้อมูลได้',
              icon: 'report_problem',
              ok: 'ok'
            }).then(() => {
              this.$router.push({name: 'login'})
            })
          })
      }
    },
    loadMore (index, done) {
      setTimeout(() => {
        if ((this.next_page_url)) {
          this.$axios.get(this.next_page_url,
            {headers: {
                'Authorization': `Bearer ${this.$store.state.token.token}`
              }
            })
            .then((res) => {
              console.log('loadmore')
              this.employees = this.employees.concat(res.data.data)
              this.current_page = res.data.current_page
              this.next_page_url = res.data.next_page_url
              this.setNewToken(res.headers.authorization)
            }).catch(() => {
              this.$q.dialog({
                color: 'negative',
                message: 'ไม่สามารถติดต่อฐานข้อมูลได้',
                icon: 'report_problem',
                ok: 'ok'
              }).then(() => {
                this.$router.push({name: 'login'})
              })
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
