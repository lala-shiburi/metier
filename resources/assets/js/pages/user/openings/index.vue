<template>
  <div class="simple-card">
    <div class="simple-card-header">
      <div class="row">
        <div class="col-md-8">
          User Openings
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
            <router-link class="btn btn-outline-primary btn-sm" :to="{ name: 'opening.edit', params:{id:opening.id} }">
              <i class="fa fa-pencil" aria-hidden="true"></i>
            </router-link>
            <button type="button" @click="prepDelete(opening)" class="btn btn-outline-danger btn-sm">
              <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
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
        url: '/api/user/fetch/openings/',
      });
      this.openings = data.openings;
    },
    prepDelete(opening){
      swal({
          title: 'Are you sure?',
          text: "There could be applicants to this opening.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          axios({
            method: 'delete',
            url: '/api/opening/delete/soft',
            params: {opening_id: opening.id},
          }).then(data => {
            this.removeOpening(opening)
            swal(
              'Deleted!',
              'Step has been deleted.',
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
