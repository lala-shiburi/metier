<template>
  <div class="simple-card">
    <div class="simple-card-header">
      <div class="row">
        <div class="col-md-8">
          Saved Openings
        </div>
        <div class="col-md-4">
          <div class="input-group input-group-sm mb-3">
            <input type="text" placeholder="Search Opening" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            <div class="input-group-prepend">
              <button v-on:click="fetchOpenings" class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th>Opening</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(opening, index) in openings" v-bind:key="index">
          <td class="text-left">
            <entity-header>
              <template slot="icon">
                <iconized-photo size="medium-icon" :photo="opening.picture"></iconized-photo>
              </template>
              <template slot="text">
                <div class="text-ellipsis">
                  <router-link style="color: inherit; font-weight: bold;" :to="{ name: 'opening.profile', params: { id: opening.id} }">
                    {{opening.title}}
                  </router-link>
                </div>
                <div class="text-ellipsis">
                  <router-link class="text-muted" :to="{ name: 'company.profile', params: { id: opening.company.id} }">
                    {{opening.company.name}}
                  </router-link>
                </div>
              </template>
            </entity-header>
          </td>
          <td>
            <button type="button" @click="unSaveOpening(opening)" class="btn btn-outline-warning btn-sm">Un-save</button>
          </td>
        </tr>
        <tr v-if="openings.length == 0">
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
    openings:[],
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async fetchOpenings(){
      const { data } = await axios({
        method: 'get',
        url: '/api/user/fetch/openings/saved',
      });
      this.openings = data.openings;
    },
    async unSaveOpening(opening){
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
            url: '/api/user/update/opening/save',
            params:{opening_id:opening.id, save: 0}
          }).then(data => {
            this.removeOpening(opening)
            swal(
              'Unfollowed!',
              'Opening has been un-saved.',
              'success'
            )
          })
        }
      })
    },
    removeOpening(opening){
      for(var i = 0; i < this.openings.length; i++){
        if(this.openings[i].id == opening.id){
          this.openings.splice(i,1)
          return true
        }
      }
    },
  },
  mounted(){
    this.fetchOpenings();
  }
}
</script>
