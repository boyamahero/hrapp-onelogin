<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header>
      <q-toolbar
        color="primary"
        :inverted="$q.theme === 'ios'"
      >
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="menu" />
        </q-btn>

        <q-toolbar-title class="q-ml-md">
          HR Search
          <div slot="subtitle" class="q-subheading">สอบถามข้อมูลบุคคลและหมายเลขโทรศัพท์</div>
        </q-toolbar-title>
      </q-toolbar>
    </q-layout-header>

    <q-layout-drawer
      v-model="leftDrawerOpen"
    >
      <q-list
        separator
        border
        link
        inset-delimiter
      >
        <q-list-header class="text-weight-bolder text-center uppercase">
          <div class="row justify-center">
            <div class="text-right self-center">
              <div class="title">{{user.name}}</div>
              <div class="subtitle">{{ user.name_english }}</div>
              <div class="subtitle">{{ user.position_abb }}</div>
              <div class="subtitle">{{ user.org_path }}</div>
            </div>
            <div class="text-right self-center">
              <q-item-side :avatar="user.image_path" />
            </div>
          </div>
        </q-list-header>
        <q-item-separator />
        <q-item @click.native="smartlife" dark>
          <q-item-side icon="smartphone" color="yellow" inverted />
          <q-item-main label="SMART LIFE" class="text-left text-bold"/>
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
  </q-layout>
</template>

<script>
import { mapActions, mapState } from 'vuex'
export default {
  name: 'SearchLaout',
  data () {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop
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
          // this.$router.push({name: 'search'})
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
    index () {
      this.$router.push({name: 'index'})
    },
    logout () {
      this.logoutloading = true
      var keycloakAuth = this.$store.getters.SECURITY_AUTH
      this.$store.dispatch('authLogout')
      keycloakAuth.logout()
    }
  }
}
</script>

<style>
</style>
