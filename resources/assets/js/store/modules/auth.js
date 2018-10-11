import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'
import Echo from "laravel-echo"

// state
export const state = {
  user: null,
  companies: null,
  expired_url: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  user: state => state.user,
  companies: state => state.companies,
  companies_obj: state => {
    var result = {}
    if(state.companies)
    for(var i = 0; i < state.companies.length; i++){
      result['company_'+state.companies[i].id] = state.companies[i]
    }
    return result
  },
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

  [types.FETCH_USER_COMPANIES_SUCCESS] (state, { companies }){
    state.companies = companies
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

  async fetchManagedCompanies({ commit }){
    const { data } = await axios.get('/api/user/fetch/companies/managed')

    commit(types.FETCH_USER_COMPANIES_SUCCESS, { companies: data.companies })
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
