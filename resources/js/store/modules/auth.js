import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

const authStore = {
  namespaced: true,
  state: {
    user: null,
    token: Cookies.get('token')
  },
  mutations: {
    [types.SAVE_TOKEN] (state, { token, remember }) {
      state.token = token
      Cookies.set('token', token, { expires: remember ? 365 : null })
    },

    [types.FETCH_USER_SUCCESS] (state, { user }) {
      state.user = user
    },

    [types.FETCH_USER_FAILURE] (state) {
      state.token = null
      Cookies.remove('token')
    },

    [types.LOGOUT] (state) {
      state.user = null
      state.token = null

      Cookies.remove('token')
    },

    [types.UPDATE_USER] (state, { user }) {
      state.user = user
    }
  },
  getters: {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
  },
  actions: {
    saveToken ({ commit, dispatch }, payload) {
      commit(types.SAVE_TOKEN, payload)
    },

    async fetchUser ({ commit }) {
      try {
        const { data } = await axios.get('/api/user')

        commit(types.FETCH_USER_SUCCESS, { user: data })
      } catch (e) {
        commit(types.FETCH_USER_FAILURE)
      }
    },

    updateUser ({ commit }, payload) {
      commit(types.UPDATE_USER, payload)
    },

    async logout ({ commit }) {
      try {
        await axios.post('/api/logout')
      } catch (e) { }

      commit(types.LOGOUT)
    }
  }
}

export default authStore
