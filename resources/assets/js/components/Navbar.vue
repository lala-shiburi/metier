<template>
  <nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        <!-- {{ appName }} -->
        <img :src="public_path+'/images/logo_brand.png'">
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
      <router-link class="nav-link text-dark" :to="{ name: 'user.profile' }">
        <img :src="user.photo" class="rounded-circle profile-photo mr-1">
        <span class="hidden-md">{{ user.first_name + " " + user.last_name}}</span>
      </router-link>
      <span v-if="user" class=" dropdown">
        <a class="has-num-ico nav-link text-dark"
            href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <p class="number-icon"><i class="number">1</i></p>
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
            <fa icon="user" fixed-width/>
            Your Job Applications
          </router-link>
          <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
            <fa icon="cog" fixed-width/>
            {{ $t('settings') }}
          </router-link>
          <router-link :to="{ name: 'user.companies' }" class="dropdown-item pl-3">
            <i class="fa fa-building" style="padding: 0 3px;"></i> Companies
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
            <router-link :to="{ name: 'home' }" class="nav-link" active-class="active">
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
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
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
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName,
    public_path: location.origin
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
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
