<template>
  <div class="row m-0 w-100">
      <div class="col-md-6 p-0 overflow-hidden">
        <img :src="public_path+'/images/Group 244.png'" style="width:100%;" class="absolute-center">
      </div>
      <div class="col-md-6 p-0 m-auto" style="min-height:100vh; background:white; transform: translateY(-1px);">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <div class="absolute-center w-100 p-3" style="max-width:400px;">
            <div class="text-center">
              <router-link :to="{ name: 'welcome' }">
                <img :src="public_path+'/images/logo_brand.png'" style="max-width: 150px;">
              </router-link>
              <blockquote style="font-size:12px; margin-top:10px;">Welcome back! Please login to your account.</blockquote>
            </div>
            <v-line-input :form="form" field="email">
              Email
            </v-line-input>
            <v-line-input :form="form" field="password" type="password">
              Password
            </v-line-input>
            <div style="margin:20px 0;">
              <checkbox v-model="remember" name="remember">
                {{ $t('remember_me') }}
              </checkbox>

              <router-link :to="{ name: 'password.request' }" style="display:block; float:right;" class="small ml-auto my-auto">
                {{ $t('forgot_password') }}
              </router-link>
            </div>
            <v-button :loading="form.busy">
              {{ $t('login') }}
            </v-button>
          </div>
        </form>
      </div>
  </div>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import swal from 'sweetalert2'

export default {
  middleware: 'guest',
  layout: 'basic',

  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false,
    public_path: location.origin,
  }),

  methods: {
    async login () {
      var $this=this;
      // Submit the form.
      this.form.post('/api/login')
      .catch(error=>{
        if(error.response.data.error == "Already authenticated."){
          window.location.href = '/home';
        }
        else if(error.response.data.error == "Unauthorised"){
          swal({
            type: 'error',
            title: 'Opps!',
            html: "Your account was deactivated by our systems administrator due to a report"
                +" of misconduct. If you wish to restore your account, please <a href='/contact-us'>contact us</a>.",
          })
        }
      }).then(async function(data){
        if(data){
          // Save the token.
          $this.$store.dispatch('auth/saveToken', {
            token: data.data.token,
            remember: $this.remember
          })

          // Fetch the user.
          await $this.$store.dispatch('auth/fetchUser')

          // Redirect home.
          $this.$router.push({ path: $this.$store.getters['auth/expired_url']?$this.$store.getters['auth/expired_url']:'home' })
        }
      });
    },
  }
}
</script>
