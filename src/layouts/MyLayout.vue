<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header reveal>
      <q-toolbar
          inverted
          color="white"
        >
          <q-btn
            round
            flat
            @click="leftDrawerOpen = !leftDrawerOpen"
            aria-label="Menu"
          >
            <q-icon name="menu" class="menu"/>
          </q-btn>

          <q-toolbar-title>
            <div class="row justify-center">
            <div class="col-xs-8 col-lg-10 text-right self-center">
              <div class="title">{{user.name}}</div>
              <div class="subtitle">{{ user.name_english }}</div>
              <div class="subtitle">{{ user.position_combine_abb }}</div>
              <div class="subtitle">{{ user.org_path }}</div>
            </div>
            <div class="col-xs-4 col-lg-1 text-center self-center">
                <img :src="user.image_path" class="q-item-avatar">
            </div>
            </div>
          </q-toolbar-title>
        </q-toolbar>
    </q-layout-header>
    <q-layout-drawer
      v-model="leftDrawerOpen"
      :content-class="$q.theme === 'mat' ? 'bg-grey-2' : null"
    >
      <q-list
        class="q-mt-md"
        no-border
        link
        inset-delimiter
      >
        <q-item class="justify-center">
           เมนู
        </q-item>
      </q-list>
      <q-list
        class="q-mt-md"
        border
        separator
        link
        inset-delimiter
        >
        <q-item @click.native="smartlife" dark>
          <q-item-side icon="smartphone" color="yellow" inverted />
          <q-item-main label="SMART LIFE" class="text-left text-bold"/>
        </q-item>
        <q-item @click.native="index" dark>
          <q-item-side icon="home" color="blue-3" inverted />
          <q-item-main label="HRIS" class="text-left text-bold"/>
        </q-item>
        <q-item @click.native="logout" dark>
          <q-item-side icon="power_settings_new" color="red" inverted-light/>
          <q-item-main label="ออกจากระบบ" class="text-left text-bold"/>
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
          <img src="statics/speedlogo.png" class="col-xs-9 col-lg-1 col-md-3" style="max-width: 30%;" @click.native="show(value)">
          </q-btn>
          <q-btn
          flat
          @click="$router.go(-1)"
        >
          <q-icon name="reply" color="primary" class="menu"/>
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
        let message = 'ไม่พบข้อมูลผู้ปฏิบัติงาน'
        if (err.message === 'Request failed with status code 401') {
          message = 'กรุณาเข้าระบบใหม่'
        }
        this.$q.dialog({
          color: 'negative',
          message: message,
          icon: 'report_problem',
          ok: 'ok'
        }).then(() => {
          this.$router.push({name: 'smartlife'})
        })
      })
  },
  computed: {
    ...mapState('user', ['user'])
  },
  methods: {
    ...mapActions('user', ['setUser']),
    smartlife () {
      this.$router.push({name: 'smartlife'})
    },
    logout () {
      this.logoutloading = true

      var keycloakAuth = this.$store.getters.SECURITY_AUTH
      keycloakAuth.logout()
      this.$store.dispatch('authLogout')
    }
  }
}
</script>

<style>
.q-layout-header {
-webkit-box-shadow: none;
-moz-box-shadow: none;
box-shadow: none;
}
</style>
