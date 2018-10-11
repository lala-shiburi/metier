<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        Hiring Application List
      </div>
      <div class="col-md-3">
        <div class="input-group input-group-sm mb-3">
          <input type="text" placeholder="Search Company" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
          <div class="input-group-prepend">
            <button v-on:click="fetchApplications" class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th>
            Job
          </th>
          <th>
            Company
          </th>
          <th>
            Date Submitted
          </th>
          <th>
            Options
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in applications" v-bind:key="index">
          <td>
            <router-link class="n" :to="{ name: 'opening.profile', params: { id: row.opening.id }}">
              <iconized-photo size="medium-icon" :photo="row.opening.picture"></iconized-photo>{{row.opening.title}}
            </router-link>
          </td>
          <td>
            <router-link class="n" :to="{ name: 'company.profile', params: { id: row.opening.company.id}}">
              <iconized-photo size="medium-icon" :photo="row.opening.company.photo"></iconized-photo>{{row.opening.company.name}}
            </router-link>
          </td>
          <td>
            {{formatedDate(row.created_at)}}
          </td>
          <td>
            <button type="button" v-on:click="showApplicationInfo(row)" class="btn btn-primary btn-sm">
              <i class="fa fa-eye" aria-hidden="true"></i>
            </button>
          </td>
        </tr>
        <tr v-if="applications.length == 0">
          <td colspan="4" style="padding: 10px;"> No result </td>
        </tr>
      </tbody>
    </table>
    <application-modal ref="modal"/>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import ApplicationModal from './components/application-modal'
import axios from 'axios'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Hiring Applications' }
  },
  components:{
    ApplicationModal
  },
  data : () =>({
    applications: [],
    public_path: location.origin,
    user : {},
  }),
  methods: {
    async fetchApplications(){
      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/hiringApplications',
        params: { user_id: this.user.id }
      })
      this.applications = data.hiringApplications;
    },
    showApplicationInfo(data){
      this.$refs.modal.show(data)
    },
  },
  mounted(){
    this.user = this.$store.getters['auth/user'];
    this.fetchApplications();
  },
}
</script>
