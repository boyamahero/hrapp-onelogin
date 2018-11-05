<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header>
    </q-layout-header>
    <q-toolbar
        inverted
        color="white"
      >
        <q-btn
          flat
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="menu" class="menu"/>
        </q-btn>

        <q-toolbar-title>
          <div class="row justify-end">
          <div class="col-xs-9 col-lg-9 text-right self-center">
          <div class="subtitle">EGAT HR APP</div>
          <div class="title">นายบุญฤทธิ์ บุญลือ</div>
          </div>
          <div class="col-xs-3 col-lg-1 text-right">
              <img src="statics/594073.jpg" class="q-item-avatar self-center">
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
        <q-item @click.native="logout" :loading="logoutloading">
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
            <q-item-side icon="horizontal_split" style="color:#14548a;font-size: 20px;"/>
            <q-popover>
                <q-list link style="min-width: 200px">
                  <div class="subheader">เมนูอื่นๆ</div>
                  <q-item>
                    <q-item-main label="เกี่ยวกับองค์กร" />
                  </q-item>
                  <q-item>
                    <q-item-main label="SPEED ค่านิยมองค์กร" />
                  </q-item>
                  <q-item>
                    <q-item-main label="โครงสายบังคับบัญชา" />
                  </q-item>
                </q-list>
              </q-popover>
          </q-btn>
        </q-item>
  </q-layout-footer>
  </q-layout>
</template>

<script>

export default {
  name: 'MyLayout',
  data () {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop,
      response: '',
      loading: false,
      logoutloading: false
    }
  },
  methods: {
    async makeRequest () {
      let response
      let color = 'negative'
      this.loading = true

      try {
        response = ''
        let req = await fetch(process.env.api + '/test')

        if (!req.ok) throw new Error('error request')

        let {data} = await req.json()
        response = data
        color = 'positive'
      } catch (err) {
        console.log(err)
        response = err.message
      }

      setTimeout(() => {
        this.response = response
        this.color = color
        this.loading = false
      }, 700)
    },
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
