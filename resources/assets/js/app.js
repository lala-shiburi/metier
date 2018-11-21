import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import jQuery from 'jquery'
import windowResizeDetector from '~/plugins/windowResizeDetector'
let moment = require("moment")
import Echo from "laravel-echo"
window.layout_events=[]

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '64025db9c2035154c318',
    cluster: 'ap1',
    encrypted: true,
    auth: {
      headers: {
        Authorization: 'Bearer ' + store.getters['auth/token'],
      },
    },
});

global.jQuery = jQuery
global.windowResizeDetector = windowResizeDetector
global.moment = moment
global.Vue = Vue

require('bootstrap');
require('overlayscrollbars');
require("bootstrap-datepicker")

import '~/plugins'
import '~/components'
import AsyncComputed from 'vue-async-computed'

// use vue-async-computed
// this is used to implement computed async properties
Vue.use(AsyncComputed)


Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
