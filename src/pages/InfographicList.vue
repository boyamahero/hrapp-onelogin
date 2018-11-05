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
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false,
      maximizedModal: false,
      dataInModal: '',
      infolist: [
        {
          id: 5,
          title: 'การจ้างผู้ปฏิบัติงาน',
          path: '205.jpg'
        },
        {
          id: 7,
          title: 'ใบ กว.',
          path: '207.jpg'
        },
        {
          id: 10,
          title: 'การลงเวลาทำงาน เหลื่อมเวลา',
          path: '210.jpg'
        },
        {
          id: 11,
          title: 'ขั้นตอนการเบิกค่าล่วงเวลา',
          path: '211.jpg'
        },
        {
          id: 12,
          title: 'สิทธิการลา',
          path: '212.jpg'
        }
      ]
    }
  },
  methods: {
    show (value) {
      this.maximizedModal = true
      this.dataInModal = value
    }
  }
}
</script>
