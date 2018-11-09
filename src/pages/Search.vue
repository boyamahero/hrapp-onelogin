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
      <q-infinite-scroll :handler="loadMore">
        <q-card v-for="employee in employees" :key="employee.id">
          <q-item>
            <q-item-side :avatar="employee.image_path" />
            <q-item-main>
              <q-item-tile label>{{ employee.name }}</q-item-tile>
              <q-item-tile sublabel>{{ employee.position_abb }}</q-item-tile>
              <q-item-tile sublabel>{{ employee.org_path }}</q-item-tile>
              <q-item-tile sublabel>โทร. {{ employee.phone }}</q-item-tile>
            </q-item-main>
          </q-item>
        </q-card>
        <q-spinner-dots slot="loading more" :size="5"></q-spinner-dots>
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
      employees: []
    }
  },
  methods: {
    search () {
      this.$axios.get('search/' + this.searchText)
        .then((res) => {
          this.employees = res.data.data
        })
    },
    loadMore () {
      this.$axios.get('search/' + this.searchText)
        .then((res) => {
          console.log('load more')
          // this.employees.push(res.data.data)
        })
    }
  }
}
</script>

<style>
</style>
