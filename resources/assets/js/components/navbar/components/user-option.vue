<template>
  <div ref="user-option" class="p-15 user-option border-top shadow-sm">
    <center>
      <img :src="user.photo" class="rounded-circle" height="70px">
      <div>
        {{user.name}}
      </div>
      <div class="font-weight-normal">
        <small>Web Developer</small>
      </div>
    </center>
    <div class="border-top mt-3 pt-3">
      <router-link :to="{ name: 'user.profile' }" v-on:click.native="hide" class="btn btn-outline-secondary btn-sm pull-left">Profile</router-link>
      <button class="btn btn-outline-secondary btn-sm" @click="logout">Logout</button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: "UserOption",
  computed: mapGetters({
    user: 'auth/user',
  }),
  data: () => ({
    // 
  }),
  methods: {
    show(){
      jQuery(this.$refs['user-option']).addClass('show')
    },
    hide(){
      jQuery(this.$refs['user-option']).removeClass('show')
    },
    async logout () {
      this.hide()
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
  },
}
</script>
<style lang="scss" scoped>
.user-option{
  position: absolute;
  right: 0px;
  top: 100%;
  width: 300px;
  background: white;
  display: none;
}
.user-option.show{
  display: block;
}
@media (max-width: 768px) {
  .user-option{
    width: 100%;
  }
}
</style>
