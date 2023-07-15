import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import App from '~/components/App'
import confirm from '~/plugins/swal'
import vuetify from '~/plugins/vuetify'
import axios from 'axios'

import '~/plugins'

Vue.config.productionTip = false

Vue.prototype.$confirm = confirm
Vue.prototype.$http = axios

/* eslint-disable no-new */
new Vue({
  vuetify,
  store,
  router,
  ...App
})
