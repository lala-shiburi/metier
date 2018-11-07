<template>
  <div class="list-group-item">
    <button @click="save(user, companies[0])" :class="user.companies_who_saved.length?'btn-outline-primary': 'btn-light'" v-if="companies.length == 1" class="btn pull-right">
      <i class="fa fa-bookmark-o" aria-hidden="true"></i> Save
    </button>
    <div class="dropdown pull-right" v-if="companies.length > 1">
      <div @click="activate" class="my-1 mr-sm-2 cursor-pointer">
        <i v-if="loading" class="fa fa-spinner spin" aria-hidden="true"></i>
        <span v-else>
          <i class="fa fa-check-square text-primary" v-if="user.is_active == 1" aria-hidden="true"></i>
          <i class="fa fa-window-close text-danger" v-else aria-hidden="true"></i>
        </span>
        <label>{{user.is_active == 1 ? 'Active' : 'Inactive'}}</label>
        <div class="max-w-200">
          <small class="text-muted">Disable or Enable account. By disabling, user will be restricted from logging in.</small>
        </div>
      </div>
    </div>
    <router-link class="text-dark no-deco" :to="{ name: 'user.profile', params:{id:user.id} }">
      <img :src="user.photo" width="50px" class="rounded">
      <span class="d-inline-block align-top">
        <div><strong>{{user.name}}</strong></div>
        <div>
          <small>
            <template v-if="user.current_work_experience[0]">
              {{(user.current_work_experience[0].position)}} | {{user.current_work_experience[0].length}} |
            </template>
            <template v-else>
              No work experience |
            </template>
            <span>
              <skill-icon v-for="(lang,index) in user.programming_languages" v-bind:key="'skill'+index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
            </span>
            <span>
              <skill-icon v-for="(lang,index) in user.user_technologies" v-bind:key="'skill'+index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
            </span>
          </small>
        </div>
      </span>
    </router-link>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import swal from 'sweetalert2'

export default {
  props:{
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    }
  },
  data : () => ({
    loading: false
  }),
  methods: {
    async activate(){
      swal({
        title: 'Are you sure?',
        text: this.user.is_active == 1 ? `${this.user.name} will not be able to login.` : `${this.user.name}'s login privileges will be restored.`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(async (result) => {
        if (result.value) {
          this.loading = true
          const { data } = await axios({
            method: "patch",
            url: "/api/admin/user/activate",
            params: { 'user_id' : this.user.id, 'is_active' : this.user.is_active == 1 ? 0 : 1 },
          })

          this.loading = false

          this.user.is_active = data.user.is_active

          swal(
            this.user.is_active == 0 ? 'Deactivated!' : 'Reactivated',
            this.user.is_active == 0 ? `${this.user.name}'s login privileges is disabled. But you can reactive it again, anytime.`
            : `${this.user.name}'s login privileges is restored.`
            ,
            'success'
          )
        }
      });
    }
  },
}
</script>
<style scoped scss>
.no-deco{
  text-decoration:none;
}
.max-w-200{
  max-width: 200px;
}
.spin {
    -webkit-animation-name: spin;
    -webkit-animation-duration: 4000ms;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    -moz-animation-name: spin;
    -moz-animation-duration: 4000ms;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: linear;
    -ms-animation-name: spin;
    -ms-animation-duration: 4000ms;
    -ms-animation-iteration-count: infinite;
    -ms-animation-timing-function: linear;
    
    animation-name: spin;
    animation-duration: 4000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
@-ms-keyframes spin {
    from { -ms-transform: rotate(0deg); }
    to { -ms-transform: rotate(360deg); }
}
@-moz-keyframes spin {
    from { -moz-transform: rotate(0deg); }
    to { -moz-transform: rotate(360deg); }
}
@-webkit-keyframes spin {
    from { -webkit-transform: rotate(0deg); }
    to { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
    from {
        transform:rotate(0deg);
    }
    to {
        transform:rotate(360deg);
    }
}
</style>