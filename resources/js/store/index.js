import Vue from 'vue'
import Vuex from 'vuex'
import authStore from './modules/auth'
import snackbarStore from './modules/snackbar'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth: authStore,
    snackbar: snackbarStore
  }
})
