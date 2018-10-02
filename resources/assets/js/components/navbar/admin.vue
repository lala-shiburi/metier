<template>
  <div>
    <nav style="z-index: 1010" class="navbar navbar-expand-md navbar-light bg-white text-right d-block">
      <button type="button" @click="clickToggle" class="btn btn-light pull-left">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </button>
      <a class="has-num-ico text-dark" v-on:click="showNotifications"
          href="#" role="button">
        <p class="number-icon" v-if="notifications_count > 0"><i class="number">{{notifications_count}}</i></p>
        <i class="fa fa-bell-o" aria-hidden="true"></i>
      </a>
      <a v-if="user" href="#" @click="showUserOption" class="d-inline-block nav-link text-dark">
        <img :src="user.photo" class="rounded-circle profile-photo mr-1">
        <span class="hidden-md">{{ user.first_name + " " + user.last_name}}</span>
      </a>
      <user-option ref="user-option"/>
    </nav>
    <notification-modal ref="notification-modal"/>
    <notifications group="foo" position="bottom right"/>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from '~/components/LocaleDropdown'
import NotificationModal from '~/components/NotificationModal'
import axios from 'axios'
import Vue from 'vue'
import Notifications from 'vue-notification'
import UserOption from './components/user-option'

Vue.use(Notifications)
export default {
  components: {
    LocaleDropdown,
    NotificationModal,
    UserOption
  },

  data: () => ({
    appName: window.config.appName,
    public_path: location.origin,
    notifications_count: 0,
    signedIn: false
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    showNotifications(){
      var $this = this;
      axios({
        method: 'patch',
        url: '/api/notification/update/mark_read_all'
      }).then((data)=>{
        if(data.data == 'success'){
          $this.notifications_count = 0;
        }
      });
      this.$refs['notification-modal'].show();
    },
    async fetchNotificationCount(){
      const {data} = await axios({
        method: 'get',
        url: '/api/notification/fetch/unread/count',
        params: {},
      });

      this.notifications_count = data;
    },
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    async loadNotification(id){
      const {data} = await axios({
        method: 'get',
        url: '/api/notification/fetch/one',
        params: {notification_id: id}
      });

      this.$refs['notification-modal'].notifications.unshift(data.notification);

      this.$notify({
        group: 'foo',
        title: data.notification.title,
        text: data.notification.message,
        animation: {enter: {'margin-right':['-100', 0], opacity: [1, 0]}, leave: {opacity: [0, 1]}}
      })
    },
    showSignPopup(){
      this.$refs['sign-in-modal'].show()
    },
    userLoggedIn(){
      this.signedIn = true;
    },
    clickToggle(){
      this.$emit('toggle');
    },
    showUserOption(){
      this.$refs['user-option'].show()
    },
    hideUserOption(){
      this.$refs['user-option'].hide()
    }
  },
  created: function(){
    this.fetchNotificationCount();
    var $this = this;
    Echo.private('App.User.' + jQuery('meta[name="auth_id"]').prop('content'))
    .notification((notification) => {
      $this.notifications_count++
      $this.loadNotification(notification.id)
    });
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
