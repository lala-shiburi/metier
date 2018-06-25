<template>
  <div class="row m-0 w-100">
      <div class="col-md-6 p-0 overflow-hidden">
        <img :src="public_path+'/images/register-background.png'" style="width:100%;" class="absolute-center">
      </div>
      <div class="col-md-6 p-0 m-auto" style="height:100vh; background:white;">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <div class="absolute-center w-100 p-3" style="max-width:400px;">
            <div class="text-center">
              <router-link :to="{ name: 'welcome' }">
                <img :src="public_path+'/images/logo_brand.png'">
              </router-link>
              <blockquote style="font-size:12px; margin-top:10px;">Please complete to create your account.</blockquote>
            </div>
            <div class="row">
              <div class="col-md-6">
                <v-line-input :form="form" field="first_name">
                  First Name
                </v-line-input>
              </div>
              <div class="col-md-6">
                <v-line-input :form="form" field="last_name">
                  Last Name 
                </v-line-input>
              </div>
            </div>
            <v-line-input :form="form" field="email">
              Email
            </v-line-input>
            <div class="row">
              <div class="col-md-6">
                <v-line-input :form="form" field="gender" type="dropdown">
                  <template slot="input-content">
                    <option value> Gender </option>
                    <option value="male"> Male </option>
                    <option value="female"> Female </option>
                  </template>
                  Gender
                </v-line-input>
              </div>
              <div class="col-md-6">
                <v-line-input :form="form" field="birth_date" type="date">
                  Birth Date
                </v-line-input>
              </div>
            </div>
            <v-line-input :form="form" field="password" type="password">
              Password
            </v-line-input>
            <v-line-input :form="form" field="password_confirmation" type="password">
              Confirm Password
            </v-line-input>
            <v-button :loading="form.busy">
              {{ $t('register') }}
            </v-button>
            <!-- GitHub Register Button -->
              <login-with-github/>
          </div>
        </form>
      </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  middleware: 'guest',
  layout: 'basic',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
    form: new Form({
      first_name: '',
      last_name: '',
      email: '',
      gender: '',
      password: '',
      password_confirmation: ''
    }),
    public_path: location.origin
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'home' })
    }
  }
}
</script>
