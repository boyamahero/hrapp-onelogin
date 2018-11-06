<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-card class="q-ma-md">
      <q-card-main>
         <p class="header">ข้อมูลที่เป็นประโยชน์ด้านบุคคล</p>
         <div class="row q-my-md">
          <div v-for="value in dataCategories" :key="value.id" class="col-lg-2 col-md-3 col-xs-6">
          <div class="q-px-xs"><img class="full-width" :src="'statics/modules/' + value.slug + '.png'" @click="$router.push({ name: 'infographic_list', params: { id: value.id ,title: value.name }})"></div>
         </div>
         </div>
      </q-card-main>
    </q-card>
    </div>
     </div>
  </q-page>
</template>

<style>
</style>

<script>
export default {
  name: 'PageIndex',
  mounted () {
    this.getCategoires()
  },
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false,
      dataCategories: []
    }
  },
  methods: {
    getCategoires () {
      this.$axios.get('info-categories')
        .then((res) => {
          this.dataCategories = res.data
        })
    }
  }
}
</script>
