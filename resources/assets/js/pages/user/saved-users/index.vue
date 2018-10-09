<template>
  <div class="simple-card">
    <div class="simple-card-header">
      <div class="row">
        <div class="col-md-8">
          Saved Users
        </div>
        <div class="col-md-4">
          <div class="input-group input-group-sm mb-3">
            <input type="text" placeholder="Search Opening" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            <div class="input-group-prepend">
              <button v-on:click="fetchUsers" class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Company</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(user, index) in users" v-bind:key="index">
          <td class="text-left">
            <entity-header>
              <template slot="icon">
                <iconized-photo size="medium-icon" :photo="user.photo"></iconized-photo>
              </template>
              <template slot="text">
                <div class="text-ellipsis">
                  <router-link style="color: inherit; font-weight: bold;" :to="{ name: 'user.profile', params: { id: user.id} }">
                    {{user.name}}
                  </router-link>
                </div>
                <div class="text-ellipsis">
                  <template>
                    <skill-icon v-for="(lang) in user.programming_languages" v-bind:key="lang.id+'lang'" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
                  </template>
                  <template>
                    <skill-icon v-for="(lang) in user.user_technologies" v-bind:key="lang.id+'tech'" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
                  </template>
                  <small class="text-muted" v-if="!user.user_technologies.length && !user.programming_languages.length">skills info not available</small>
                </div>
              </template>
            </entity-header>
          </td>
          <td>
            {{user.company.name}}
          </td>
          <td>
            <button type="button" @click="unSaveUser(user, user.company)" class="btn btn-outline-warning btn-sm">Un-save</button>
          </td>
        </tr>
        <tr v-if="users.length == 0">
          <td colspan="2" style="padding: 10px;"> No result </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
import Form from 'vform'
import { mapGetters } from 'vuex'
import swal from 'sweetalert2'

export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Saved Openings' }
  },
  data : () =>({
    public_path: location.origin,
    users:[],
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async fetchUsers(){
      const { data } = await axios({
        method: 'get',
        url: '/api/user/fetch/companies/saved/users',
      });
      this.users = data.users;
    },
    async unSaveUser(user, company){
      swal({
          title: 'Are you sure?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          axios({
            method: 'patch',
            url: "/api/company/save/user",
            params: {user_id : user.id, company_id: company.id, save: 0}
          }).then(data => {
            this.removeUser(opening)
            swal(
              'Un-saved!',
              'Opening has been un-saved.',
              'success'
            )
          })
        }
      })
    },
    removeUser(user){
      for(var i = 0; i < this.users.length; i++){
        if(this.users[i].id == user.id){
          this.users.splice(i,1)
          return true
        }
      }
    },
  },
  mounted(){
    this.fetchUsers();
  }
}
</script>
