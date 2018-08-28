import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import Echo from "laravel-echo"

// state
export const state = {
  user: null,
  expired_url: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => state.user,
  expired_url: state => state.expired_url,
  token: state => state.token,
  check: state => state.user !== null
}

// mutations
export const mutations = {
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
  },

  [types.SAVE_EXPIRED_URL] (state, { url }) {
    state.expired_url = url
  }
}

// actions
export const actions = {
  saveToken ({ commit, dispatch }, payload) {

    // set Echo with Auth token
    window.Pusher = require('pusher-js');
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '64025db9c2035154c318',
        cluster: 'ap1',
        encrypted: true,
        auth: {
          headers: {
            Authorization: 'Bearer ' + payload.token,
          },
        },
    });

    commit(types.SAVE_TOKEN, payload)
  },

  async fetchUser ({ commit }) {
    try {
      const { data } = await axios.get('/api/user')
      jQuery('meta[name="auth_id"]').prop('content', data.id)

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
  },

  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)

    return data.url
  }
}
