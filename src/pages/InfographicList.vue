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
            <div class="wrapperA" v-bind:style="{ 'background-image': 'url(statics/infographic/2/' + value.path + ')' }"></div>
          </q-item-side>
          <q-item-main>{{value.title}}</q-item-main>
        <q-modal v-model="maximizedModal" maximized>
          <div class="row closemodal"><q-icon name="fas fa-window-close" @click.native="maximizedModal = false"/></div>
          <img :src="'statics/infographic/2/' + dataInModal.path" class="full-width">
        </q-modal>
        </q-item>
        </q-list>
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
      this.$axios.get('info-categories/2')
        .then((res) => {
          this.infolist = res.data
        })
    }
  }
}
</script>
