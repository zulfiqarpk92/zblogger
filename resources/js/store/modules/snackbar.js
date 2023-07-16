const snackbarStore = {
  namespaced: true,
  state: {
    snackbarText: '',
    errorText: ''
  },
  mutations: {
    'SHOW_MESSAGE' (state, snackbarText) {
      state.snackbarText = snackbarText
      setTimeout(function () {
        state.snackbarText = ''
      }, 3000)
    },
    'HIDE_MESSAGE' (state) {
      state.snackbarText = ''
    },
    'SHOW_ERROR' (state, errorText) {
      state.errorText = errorText
      setTimeout(function () {
        state.errorText = ''
      }, 3000)
    },
    'HIDE_ERROR' (state) {
      state.errorText = ''
    }
  },
  getters: {
    snackbarText: state => state.snackbarText,
    errorText: state => state.errorText,
  },
  actions: {
    showMessage ({ commit }, snackbarText) {
      commit('SHOW_MESSAGE', snackbarText)
    },
    hideMessage ({ commit }) {
      commit('HIDE_MESSAGE')
    },
    showError ({ commit }, errorText) {
      commit('SHOW_ERROR', errorText)
    },
    hideError ({ commit }) {
      commit('HIDE_ERROR')
    }
  }
}
export default snackbarStore
