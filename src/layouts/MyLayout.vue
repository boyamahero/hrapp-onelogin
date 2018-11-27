<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header>
    </q-layout-header>
    <q-toolbar
        inverted
        color="white"
      >
        <q-btn v-if="this.$route.name==='index'"
          flat
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="menu" class="menu"/>
        </q-btn>
        <q-btn v-else
          flat
          @click="$router.go(-1)"
        >
          <q-icon name="fas fa-arrow-alt-circle-left" class="menu"/>
        </q-btn>

        <q-toolbar-title>
          <div class="row justify-center">
          <div class="col-xs-7 col-lg-8 text-right self-center">
            <div class="subtitle">EGAT HR APP</div>
            <div class="title">{{user.name}}</div>
            <div class="subtitle">{{ user.name_english }}</div>
          </div>
          <div class="col-xs-2 col-lg-1 text-right">
              <img :src="user.image_path" class="q-item-avatar self-center">
          </div>
          </div>
        </q-toolbar-title>
      </q-toolbar>
    <q-layout-drawer
      v-model="leftDrawerOpen"
      :content-class="$q.theme === 'mat' ? 'bg-grey-2' : null"
      :width="70"
    >
      <q-list
        class="q-mt-md"
        no-border
        link
        inset-delimiter
      >
        <q-item>
           <q-icon name="menu" class="menu" @click.native="leftDrawerOpen = false"/>
        </q-item>
      </q-list>
      <q-list
        id="q-list-itemb"
        no-border
        link
        inset-delimiter
      >
        <q-item>
          <q-item-side icon="contact_support"/>
                <q-popover>
                <q-list style="min-width: 200px">
                  <div class="subheader">เกี่ยวกับแอพ</div>
                  <q-item>
                    <q-item-main label="จัดทำโดย" />
                  </q-item>
                  <q-item>
                    <q-item-main label="กองเทคโนโลยีสารสนเทศสายงานบริหาร" />
                  </q-item>
                  <q-item>
                    <q-item-main label="โทร 65323" />
                  </q-item>
                </q-list>
              </q-popover>
        </q-item>
        <q-item @click.native="logout">
          <q-item-side icon="power_settings_new" color="red" />
        </q-item>
      </q-list>
    </q-layout-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
 <q-layout-footer  reveal>
        <q-item class="justify-between" style="padding:0">
          <q-btn flat>
          <q-item-side icon="home"  @click.native="$router.push('/')" style="color:#14548a;font-size: 20px;"/>
          </q-btn>
          <q-btn flat>
          <img src="statics/speedlogo.png" class="col-xs-9 col-lg-1 col-md-3" @click.native="show(value)">
          </q-btn>
          <q-btn flat>
            <q-item-side icon="horizontal_split" style="color:#14548a;font-size: 20px;"/>
            <q-popover>
                <q-list link style="min-width: 200px;">
                  <div class="subheader">ช่องทางติดต่อ</div>
                  <q-item>
                    <q-item-main label="แจ้งเปลี่ยนแปลงข้อมูล" />
                  </q-item>
                  <!-- <q-item>
                    <q-item-main label="SPEED ค่านิยมองค์กร" />
                  </q-item>
                  <q-item>
                    <q-item-main label="โครงสายบังคับบัญชา" />
                  </q-item> -->
                </q-list>
              </q-popover>
          </q-btn>
        </q-item>
  </q-layout-footer>
  </q-layout>
</template>

<script>
import { mapActions, mapState } from 'vuex'
// import 'vue-image-zoom/dist/vue-image-zoom.css'
// import Vue from 'vue'
// Vue.use(zoom)
export default {
  name: 'MyLayout',
  data () {
    return {
      // leftDrawerOpen: this.$q.platform.is.desktop
      leftDrawerOpen: false
    }
  },
  mounted () {
    this.setUser()
      .then()
      .catch((err) => {
        let message = 'ไม่สามารถติดต่อฐานข้อมูลได้'
        if (err.message === 'Request failed with status code 401') {
          message = 'กรุณาเข้าระบบใหม่'
        }
        this.$q.dialog({
          color: 'negative',
          message: message,
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          this.$router.push({name: 'login'})
        })
      })
  },
  computed: {
    ...mapState('user', ['user'])
  },
  methods: {
    ...mapActions('user', ['setUser']),
    logout () {
      this.logoutloading = true
      this.$store.dispatch('destroyToken')
        .then(response => {
          this.logoutloading = false
          this.$router.push({name: 'login'})
        })
        .catch(e => {
          this.logoutloading = false
          if (e.message === 'Request failed with status code 500') {
            this.showAlert = true
            this.error = 'เครื่องแม่ข่ายเว็ปไซต์มีปัญหา'
          }
          if (e.message === 'Network Error') {
            this.showAlert = true
            this.error = 'เครื่องแม่ข่ายมีปัญหา'
          }
        })
    }
  }
}
</script>

<style>
</style>
