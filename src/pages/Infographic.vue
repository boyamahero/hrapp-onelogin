<template>
  <q-page>
    <div class="row justify-center">
      <div class="col-md-9 col-xs-12">
      <q-card class="q-ma-md">
      <q-card-main>
         <p class="header">ข้อมูลที่เป็นประโยชน์ด้านบุคคล</p>
         <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/info-module-intro.png" @click.native="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/info-module-Services.png" @click="$router.push({ name: 'infographic_list', params: { id: '2' ,title: 'งานบริการงานบุคคล' }})"></div>
          </div>
          <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/info-module-PM.png" @click.native="$router.push('/')"></div>
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/info-module-HRM.png" @click.native="$router.push('/')"></div>
         </div>
              <div class="row text-center">
          <div class="col-6 q-px-xs"><img class="full-width" src="statics/modules/info-module-Welfare.png" @click.native="$router.push('/')"></div>
         </div>
        <!-- <div class="row text-center menupic">
          <div class="col-6"><img src="statics/menu/menu1.png"></div>
          <div class="col-6"><img src="statics/menu/menu2.png"></div>
        </div>
        <div class="row text-center menupic">
          <div class="col-6"><img src="statics/menu/menu3.png"></div>
          <div class="col-6"><img src="statics/menu/menu4.png"></div>
        </div> -->
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
  data () {
    return {
      color: 'primary',
      response: '',
      loading: false,
      logoutloading: false
    }
  },
  methods: {
  }
}
</script>
