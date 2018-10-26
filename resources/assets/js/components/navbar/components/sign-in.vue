<template>
  <sidebar-popup ref="modal">
    <div class="p-0 m-auto" style="height:100vh; background:white;">
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
  </sidebar-popup>
</template>

<script>
import SidebarPopup from '~/components/SidebarPopup'
import axios from 'axios'
import Form from 'vform'
export default {
  name: "SignIn",
  components: {
    SidebarPopup,
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
      }).then(async function(data){
        if(data){
          $this.$emit('logged')
          $this.close()
          // Save the token.
          $this.$store.dispatch('auth/saveToken', {
            token: data.data.token,
            remember: $this.remember
          })

          // Fetch the user.
          await $this.$store.dispatch('auth/fetchUser')

          var user = $this.$store.getters['auth/user'];

          if(user.role == 1){
            $this.$router.app.setLayout('company_owner')
          }
        }
      });
    },
    show(){
      this.$refs['modal'].show();
    },
    close(){
      this.$refs.modal.hide();
    }
  },
}
</script>