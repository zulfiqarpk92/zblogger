const snackbarStore = {
  namespaced: true,
  state: {
    snackbarText: ''
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
    }
  },
  getters: {
    snackbarText: state => state.snackbarText
  },
  actions: {
    showMessage ({ commit }, snackbarText) {
      commit('SHOW_MESSAGE', snackbarText)
    },
    hideMessage ({ commit }) {
      commit('HIDE_MESSAGE')
    }
  }
}
export default snackbarStore
