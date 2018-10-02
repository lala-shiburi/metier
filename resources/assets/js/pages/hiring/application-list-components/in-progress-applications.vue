<template>
  <div>
    <div class="simple-card-header row">
      <div class="col-md-9">
        Applications In Progress
      </div>
      <div class="col-md-3">
        <div class="input-group input-group-sm mb-3">
          <input type="text" placeholder="Search Company" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="unick-table">
      <div class="header">
        <div class="row item-row">
          <div class="col-md-4 part">
            Applicant
          </div>
          <div class="col-md-8 part">
            Progress
          </div>
        </div>
      </div>
      <div class="body">
        <application-item @remove="removeApplication" @show="showApplicationResults" @prepUpdate="prepApplicationUpdate" :application="application" :ref="'application-item-'+application.id" v-for="(application, index) in applications" v-bind:key="index"/>
        <div class="row item-row" v-if="applications.length == 0">
          <div class="col-md-12 p-10 p-r-50 h-d-f-r">
            <center> Nothing to show </center>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <form @submit.prevent="fetchMoreApplications" class="text-center" v-if="!loaded_all">
        <br>
        <v-button :loading="loading" type="success">Load More</v-button>
      </form>
    </div>
    <application-update @update="updateApplicationResult" ref="application-update-component"/>
    <application-results ref="application-application-results-component"/>
  </div>
</template>

<script>
import axios from 'axios'
import ApplicationUpdate from './application-update'
import ApplicationResults from './application-results'
import ApplicationItem from './application-item'
export default {
  name: "InProgressApplications",
  components: {
    ApplicationUpdate,
    ApplicationResults,
    ApplicationItem
  },
  data : () =>({
    public_path: location.origin,
    applications: [],
    loaded_all: false,
    loading: false,
  }),
  methods: {
    fetch_applications: function(){
      this.fetchMoreApplications();
    },
    async fetchMoreApplications(){
      this.loading = true;
      var query = [
        {
          column: 'status',
          value: 1
        }
      ];
      var updated_at = this.applications.length ? this.applications[this.applications.length-1].updated_at.date : null;
      const {data} = await axios({
        url: '/api/company/fetch/applicants/lazy_load',
        method: 'get',
        params: {
          limit:5, 
          updated_at: updated_at, 
          company_id: this.$route.params.id,
          _query: query
          }
      });

      this.applications = this.applications.concat(data.applications);
      this.loaded_all = data.loaded_all;
      this.loading = false;
    },
    removeApplication(application){
      this.applications.splice(this.returnApplicationIndex(application), 1);
    },
    updateCurrent(data){
      // 
    },
    prepApplicationUpdate(data){
      this.$refs['application-update-component'].showApplication({
        application: data
      })
    },
    updateApplicationResult(data){
      this.applications[this.returnApplicationIndex(data.hiring_application)] = data.hiring_application;
      this.$forceUpdate();
    },
    showApplicationResults(data){
      this.$refs['application-application-results-component'].showApplicationResults(data);
    },
    returnApplicationIndex(application){
      for(var i = 0; i < this.applications.length; i++){
        if(this.applications[i].id == application.id){
          return i;
        }
      }
    }
  },
  mounted(){
    this.fetch_applications();
  }
}
</script>
