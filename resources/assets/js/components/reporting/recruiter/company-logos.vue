<template>
  <div class="simple-card">
    <div class="simple-card-header">
      Managed Companies
    </div>
    <div class="simple-card-body" v-if="finished">
      <div class="logo-list">
        <div class="text-muted p-15" v-if="!companies.length">Nothing to show.</div>
        <ul class="md-2 lg-3">
          <li v-for="company in companies" v-bind:key="company.id">
            <img :src="company.photo">
            <router-link :to="{ name: 'company.profile', params: {id:company.id}}" class="text-truncate title">{{company.name}}</router-link>
            <div class="text-truncate sub-title">{{formatedDate(company.created_at)}}</div>
          </li>
        </ul>
      </div>
    </div>
    <center v-else>
      <unick-loader class="loader" />
    </center>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: 'ProgressStep',
  data : () =>({
    public_path: location.origin,
    finished: false,
    companies: [],
  }),
  methods: {
    async fetch(){
      const {data} = await axios({
        url: '/api/reporting/recruiter/companies',
        method: 'get',
      })
      this.finished = true;
      this.companies = data.companies;
    }
  },
  created(){
    this.fetch();
  }
}
</script>

