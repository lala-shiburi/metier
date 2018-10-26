<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light bg-white">
      <div class="container">
        <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
          <!-- {{ appName }} -->
          <img :src="public_path+'/images/logo_brand.png'" style="height: 50px; margin-top: -10px; margin-bottom: -10px;">
        </router-link>
        <div class="hidden-md" style="flex-grow: 100">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link :to="{ name: 'opening.search' }" class="nav-link" active-class="active">
                Openings
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'company.search' }" class="nav-link" active-class="active">
                Companies
              </router-link>
            </li>
          </ul>
        </div>
        <router-link v-if="user" class="nav-link text-dark" :to="{ name: 'user.profile' }">
          <img :src="user.photo" class="rounded-circle profile-photo mr-1">
          <span class="hidden-md">{{ user.first_name + " " + user.last_name}}</span>
        </router-link>
        <span v-if="user" v-on:click="showNotifications">
          <a class="has-num-ico nav-link text-dark"
              href="#" role="button">
            <p class="number-icon" v-if="notifications_count > 0"><i class="number">{{notifications_count}}</i></p>
            <i class="fa fa-bell-o" aria-hidden="true"></i>
          </a>
        </span>
        <span v-if="user" class="dropdown">
          <a class="nav-link dropdown-toggle text-dark"
              href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <!--  -->
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <router-link :to="{ name: 'hiringApplication.applications' }" class="dropdown-item pl-3">
              Your Job Applications
            </router-link>
            <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
              {{ $t('settings') }}
            </router-link>
            <router-link :to="{ name: 'company.create' }" class="dropdown-item pl-3">
              Create Your Company
            </router-link>
            <router-link :to="{ name: 'user.followed.companies' }" class="dropdown-item pl-3">
              Companies You Followed
            </router-link>
            <router-link :to="{ name: 'user.saved.openings' }" class="dropdown-item pl-3">
              Openings You Saved
            </router-link>
            <div class="dropdown-divider"/>
            <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
              <fa icon="sign-out-alt" fixed-width/>
              {{ $t('logout') }}
            </a>
          </div>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
          <span class="navbar-toggler-icon"/>
        </button>
        <div id="navbarToggler" class="collapse navbar-collapse">
          <ul class="navbar-nav show-md">
            <li class="nav-item">
              <router-link :to="{ name: 'opening.search' }" class="nav-link" active-class="active">
                Openings
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'company.search' }" class="nav-link" active-class="active">
                Companies
              </router-link>
            </li>
          </ul>

          <ul class="navbar-nav ml-auto">
            <!-- Guest -->
            <template v-if="!user">
              <li class="nav-item" id="login-button" @click="showSignPopup">
                <a href="#" class="nav-link">
                  {{ $t('login') }}
                </a>
              </li>
              <li class="nav-item">
                <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                  {{ $t('register') }}
                </router-link>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </nav>
    <notification-modal ref="notification-modal"/>
    <notifications group="foo" position="bottom right"/>
    <sign-in @logged="userLoggedIn" ref="sign-in-modal" v-if="!user || signedIn"/>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from '~/components/LocaleDropdown'
import NotificationModal from '~/components/NotificationModal'
import axios from 'axios'
import Vue from 'vue'
import Notifications from 'vue-notification'
import SignIn from './components/sign-in'

Vue.use(Notifications)
export default {
  components: {
    LocaleDropdown,
    NotificationModal,
    SignIn,
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
