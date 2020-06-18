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
          <q-icon
            name="menu"
            class="menu"
          />
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
              <img
                :src="user.image_path"
                class="q-item-avatar"
              >
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
        class="q-ma-none bg-light-blue-2"
        no-border
        link
        inset-delimiter
      >
        <q-item class="q-ma-none q-pa-none justify-center text-bold">
          Main Menu
        </q-item>
      </q-list>
      <q-list
        class="q-ma-none q-pt-none"
        border
        separator
        link
        inset-delimiter
      >
        <q-item
          @click.native="$router.push('/')"
          dark
        >
          <q-item-side
            icon="home"
            color="blue-3"
            inverted-light
          />
          <q-item-main
            label="HRIS"
            class="text-left text-bold"
          />
        </q-item>
        <q-item
          @click.native="report"
          dark
          v-if="user.roles.some(el => el.name === 'hrreport')"
        >
          <q-item-side
            icon="description"
            color="orange-3"
            inverted-light
          />
          <q-item-main
            label="HR Report"
            class="text-left text-bold"
          />
        </q-item>
        <q-item
          @click.native="smartlife"
          dark
        >
          <q-item-side
            icon="smartphone"
            color="yellow"
            inverted-light
          />
          <q-item-main
            label="SMART LIFE"
            class="text-left text-bold"
          />
        </q-item>
        <q-item
          @click.native="logout"
          dark
        >
          <q-item-side
            icon="power_settings_new"
            color="red"
            inverted-light
          />
          <q-item-main
            label="Log Out"
            class="text-left text-bold"
          />
        </q-item>
      </q-list>
      <q-list class="fixed-bottom q-pa-xs q-ma-none bg-light-blue-2">
        <q-item class="q-ma-none q-pa-none">
          <q-item-main class="text-left q-body-1">
            <q-item-tile label>ผู้รับผิดชอบข้อมูล</q-item-tile>
            <q-item-tile
              sublabel
              class="q-ma-none q-pa-none"
            >นายอิทธิชัย ดิศวนนท์ (อทบ.) โทร 65300</q-item-tile>
          </q-item-main>
        </q-item>
        <q-item class="q-ma-none q-pa-none">
          <q-item-main class="text-left q-body-1">
            <q-item-tile label>ผู้ดูแลเว็บไซต์</q-item-tile>
            <q-item-tile
              sublabel
              class="q-ma-none q-pa-none"
            >นายสุรพล ปังอุทา (กทห-ห.) โทร 64450</q-item-tile>
          </q-item-main>
        </q-item>
        <q-item class="q-ma-none q-pa-none">
          <q-item-main class="text-left q-body-1">
            <q-item-tile label>ผู้พัฒนา</q-item-tile>
            <q-item-tile
              sublabel
              class="q-ma-none q-pa-none"
            >นายธนากร จะโต (หบค-ห.) โทร 64452</q-item-tile>
          </q-item-main>
        </q-item>
      </q-list>
    </q-layout-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
    <q-layout-footer reveal>
      <q-item
        class="justify-between"
        style="padding:0"
      >
        <q-btn flat>
          <q-item-side
            icon="home"
            @click.native="$router.push('/')"
            style="color:#14548a;font-size: 20px;"
          />
        </q-btn>
        <q-btn flat>
          <img
            src="statics/speedlogo.png"
            class="col-xs-9 col-lg-1 col-md-3"
            style="max-width: 30%;"
          >
        </q-btn>
        <q-btn
          flat
          @click="$router.go(-1)"
        >
          <q-icon
            name="reply"
            color="primary"
            class="menu"
          />
        </q-btn>
      </q-item>
    </q-layout-footer>
  </q-layout>
</template>

<script>
export default {
  name: 'MyLayout',
  preFetch ({ store }) {
    return store.dispatch('employee/setEmployee')
  },
  data () {
    return {
      leftDrawerOpen: false
    }
  },
  computed: {
    user () {
      return this.$store.state.employee.employee
    }
  },
  methods: {
    smartlife () {
      this.$router.push({ name: 'smartlife' })
    },
    report () {
      this.$router.push({ name: 'report' })
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
/* .q-layout-header {
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
} */
</style>
