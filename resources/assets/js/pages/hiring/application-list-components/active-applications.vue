<template>
  <div>
    <div class="simple-card-header row">
      <div class="col-md-9">
        Hiring Application List
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
        <div class="row item-row" v-for="(application, index) in applications" v-bind:key="index">
          <div class="col-md-4 part">
            <div class="info-layout">
              <router-link class="n" :to="{ name: 'user.profile', params: { id: application.user.id }}">
                <iconized-photo size="medium-icon logo" :photo="application.user.photo"/>
              </router-link>
              <div>
                <div class="text-truncate n"> 
                  <router-link class="n" :to="{ name: 'user.profile', params: { id: application.user.id }}">
                    {{application.user.name}}
                  </router-link>
                </div>
                <div class="text-truncate sub-text">
                  <router-link :to="{ name: 'opening.profile', params: { id: application.opening.id }}">
                    <img :src="application.opening.picture">
                    {{application.opening.title}}
                  </router-link>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 part progress-line-container">
            <application-progress-line :application="application" :ref="'progress-line'+application.id" @update="updateCurrent" />
          </div>
          <div class="col-md-12 part">
            <div style="margin-bottom: 5px; display:inline-block;">
              <button type="button" class="btn btn-primary btn-sm" v-on:click="prepApplicationUpdate(application)">Proceed To Next Step</button>
            </div>
            <div class="pull-right">
              <button type="button" @click="showApplicationResults(application)" target="_blank" data-toggle="tooltip" data-html="true" title="View Results" class="btn btn-light btn-sm"><i class="fa fa-expand" aria-hidden="true"></i></button>
              <button type="button" target="_blank" data-toggle="tooltip" data-html="true" title="Dismiss Application" class="btn btn-light btn-sm"><i class="fa fa-window-close" aria-hidden="true"></i></button>
              <a :href="application.user.resume_file" target="_blank" data-toggle="tooltip" data-html="true" title="Download Resume" class="btn btn-light btn-sm"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
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
import ApplicationProgressLine from './../../../components/hiring/application-progress-line'
export default {
  name: "ActiveApplications",
  components: {
    ApplicationProgressLine,
    ApplicationUpdate,
    ApplicationResults
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
      var updated_at = this.applications.length ? this.applications[this.applications.length-1].updated_at.date : null;
      const {data} = await axios({
        url: '/api/company/fetch/applicants/lazy_load',
        method: 'get',
        params: {limit:5, updated_at: updated_at, company_id: this.$route.params.id}
      });

      this.applications = this.applications.concat(data.applications);
      this.loaded_all = data.loaded_all;
      this.loading = false;
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
      console.log(this.$refs['progress-line'+data.hiring_application_id]);
      this.$refs['progress-line'+data.hiring_application_id][0].fetchApplication();
    },
    showApplicationResults(data){
      this.$refs['application-application-results-component'].showApplicationResults(data);
    }
  },
  mounted(){
    this.fetch_applications();
  }
}
</script>
