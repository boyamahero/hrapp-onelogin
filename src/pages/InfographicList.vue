<template>
  <q-page>
<div class="row justify-center">
      <div class="col-md-9 col-xs-12 full-width">
        <q-card class="q-ma-md">
          <q-card-main class="bg-blue-1">
            <p class="header text-bold">{{this.$route.params.title}}</p>
          </q-card-main>
        </q-card>
        <q-list class="q-mx-md"
        link>
        <q-item v-for="value in infolist" :key="value.id"
        @click.native="show(value)"
        >
          <q-item-side>
            <div class="wrapperA" v-lazy:background-image="'statics/infographic/' + value.category_id + '/' + value.featured_image"></div>
          </q-item-side>
          <q-item-main>{{value.title}}</q-item-main>
        </q-item>
        </q-list>
    </div>
     </div>
  </q-page>
</template>
<style>
</style>
<script>
import zoom from 'vue-image-zoom'
import Vue from 'vue'
import 'vue-image-zoom/dist/vue-image-zoom.css'
Vue.use(zoom)
export default {
  name: 'InfoListPage',
  mounted () {
    this.getInfographic()
  },
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false,
      infolist: []
    }
  },
  methods: {
    show (value) {
      this.$zoom('statics/infographic/' + value.category_id + '/' + value.featured_image, {
        allowZoom: true,
        autoScale: true,
        closeOnClickModal: true
      })
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
