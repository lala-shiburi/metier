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
    <table class="table table-hover simple-table table-responsive-sm table-hover table-outline mb-0">
      <thead class="thead-light">
        <tr>
          <th class="text-center">
            <i class="fa fa-clipboard"></i>
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

    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Basic Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" v-if="modalData">
            <opening-card :noApply="true" :opening="modalData.opening"/>
            <div style=" background: #f2f2f2; padding: 15px;">
              <div style="margin-bottom: 15px;" v-if="modalData.expected_salary">
                <b> Expected Salary </b>
                <br>
                <span v-html="modalData.expected_salary"></span>
              </div>
              <div>
                <b> Application Letter </b>
                <br>
                <span v-html="modalData.application_letter"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Hiring Applications' }
  },
  data : () =>({
    applications: [],
    public_path: location.origin,
    modalData: null,
    user : {},
    tableColumns : [
      {text:'Job', function: function(){}}, 
      {text:'Company', function: function(){}},
      {text:'Date Submitted', function: function(){}}
    ]
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
      this.modalData = data;
      jQuery(this.$refs.modal).modal('show');
    }
  },
  mounted(){
    this.user = this.$store.getters['auth/user'];
    this.fetchApplications();
  },
  computed :{}
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
