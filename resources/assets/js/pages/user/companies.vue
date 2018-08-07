<template>
  <div class="simple-card">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#owner-companies" role="tab" aria-controls="nav-home" aria-selected="true">Your Companies</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#followed-companies" role="tab" aria-controls="nav-profile" aria-selected="false">Followed Companies</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="owner-companies" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="simple-card-header row">
          <div class="col-md-8">
            Your Companies
          </div>
          <div class="col-md-4">
            <div class="input-group input-group-sm mb-3">
              <input type="text" placeholder="Search Company" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
              <div class="input-group-prepend">
                <button v-on:click="fetchCompanies" class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="p-10" style="padding: 0px 10px;">
          <ul class="list-inline">
            <li class="list-inline-item">
              <router-link :to="{ name: 'company.create' }" class="btn btn-primary btn-sm">
                CREATE COMPANY
              </router-link>
            </li>
          </ul>
        </div>
        <table class="table table-hover simple-table">
          <thead>
            <tr>
              <th>Company</th>
              <th>Collaborators</th>
              <th>Expand</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(company, index) in companies" v-bind:key="index">
              <td class="text-left">
                <entity-header>
                  <template slot="icon">
                    <iconized-photo size="medium-icon" :photo="company.photo"></iconized-photo>
                  </template>
                  <template slot="text">
                    <div class="text-ellipsis">
                      <router-link style="color: inherit; font-weight: bold;" :to="{ name: 'company.profile', params: { id: company.id} }">
                        {{company.name}}
                      </router-link>
                    </div>
                    <div class="text-muted text-ellipsis">{{applicationCount(company)}}</div>
                  </template>
                </entity-header>
              </td>
              <td>{{company.collaborator_count}}</td>
              <td>
                <button type="button" v-on:click="showCompanyDetails(company)" class="btn btn-primary btn-sm">
                  <i class="fa fa-window-maximize" aria-hidden="true"></i>
                </button>
              </td>
            </tr>
            <tr v-if="companies.length == 0">
              <td colspan="3" style="padding: 10px;"> No result </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="tab-pane fade" id="followed-companies" style="padding:15px;" role="tabpanel" aria-labelledby="nav-profile-tab">
        <br>
        <div class="row">
          <div class="col-md-4 col-sm-6" v-for="(company, index) in followed_companies" v-bind:key="index">
            <company-card :company="company"></company-card>
          </div>
        </div>
        <div class="text-muted text-center" v-if="followed_companies.length == 0">
          Nothing to show.
        </div>
      </div>
    </div>
    <company-details ref="company-details-component"></company-details>
  </div>
</template>

<script>
import axios from 'axios'
import CompanyCard from './../company/CompanyCard'
import Vue from 'vue'
import CompanyDetails from './CompanyDetails'
import Form from 'vform'
[
  CompanyDetails,
  CompanyCard,
].forEach(Component => {
  Vue.component(Component.name, Component)
})
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Company List' }
  },
  data : () =>({
    public_path: location.origin,
    companies:[],
    followed_companies:[],
  }),
  methods: {
    applicationCount: function(company){
      return company.hiring_application_count ? company.hiring_application_count+' active applications' : 'no active applications';
    },
    async fetchCompanies (){
      const { data } = await axios({
        method: 'get',
        url: '/api/userInfo/fetch/companies',
      })
      this.companies = data.data;
    },
    showCompanyDetails(data){
      this.$refs['company-details-component'].showCompanyDetails(data);
    },
    async fetchFollowedCompanies(){
      const { data } = await axios({
        method: 'get',
        url: '/api/userInfo/fetch/followed/companies',
      });
      this.followed_companies = data;
      console.log(this.followed_companies)
    }
  },
  mounted(){
    this.fetchCompanies();
    this.fetchFollowedCompanies();
  }
}
</script>
