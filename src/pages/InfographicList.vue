<template>
  <q-page>
<div class="row justify-center">
      <div class="col-md-9 col-xs-12 full-width">
        <q-list
        link>
        <q-list-header>{{this.$route.params.title}}</q-list-header>
        <q-item v-for="value in infolist" :key="value.id"
        @click.native="show(value)"
        >
          <q-item-side>
            <div class="wrapperA" v-bind:style="{ 'background-image': 'url(statics/infographic/' + value.category_id + '/' + value.featured_image + ')' }"></div>
          </q-item-side>
          <q-item-main>{{value.title}}</q-item-main>
        </q-item>
        </q-list>
        <q-modal v-model="maximizedModal" maximized>
          <div class="row closemodal"><q-icon name="fas fa-window-close" @click.native="maximizedModal = false"/></div>
          <img :src="'statics/infographic/' + dataInModal.category_id + '/' + dataInModal.featured_image" class="full-width">
        </q-modal>
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
    this.getInfographic()
  },
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false,
      maximizedModal: false,
      dataInModal: '',
      infolist: []
    }
  },
  methods: {
    show (value) {
      this.maximizedModal = true
      this.dataInModal = value
    },
    getInfographic () {
      this.$axios.get('info-categories/' + this.$route.params.id)
        .then((res) => {
          this.infolist = res.data
        })
    }
  }
}
</script>
