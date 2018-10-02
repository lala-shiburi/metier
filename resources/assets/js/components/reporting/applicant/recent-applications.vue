<template>
  <div class="simple-card">
    <div class="simple-card-header">
      Recent Applications
      <router-link :to="{ name: 'hiringApplication.applications' }" class="pull-right btn btn-primary btn-sm">
        See All
      </router-link>
    </div>
    <div class="simple-card-body" v-if="loaded">
      <div class="text-muted p-15" v-if="!applications.length">Nothing to show.</div>
      <application-list :applications="applications"/>
    </div>
    <center v-if="!loaded">
      <unick-loader class="loader" />
    </center>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
import {ApplicationList} from '~/components/hiring/application-list'
export default {
  name: 'RecentApplications',
  components: {
    ApplicationList
  },
  data : () =>({
    public_path: location.origin,
    loaded: false,
    applications: [],
  }),
  methods: {
    async fetch(){
      const {data} = await axios({
        url: '/api/reporting/applicant/recent/applications',
        method: 'get',
      })
      this.loaded = true;
      this.applications = data.applications;
    }
  },
  created(){
    this.fetch();
  }
}
</script>

