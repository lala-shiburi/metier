<template>
  <div class="simple-card">
    <div class="simple-card-header">
      <div class="row">
        <div class="col-md-8">
          Companies You Manage
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
    </div>
    <div class="p-10">
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
          <th>Owner</th>
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
                <router-link class="text-muted text-ellipsis" :to="{ name: 'company.applicants.submitted', params: { id: company.id} }">
                  {{applicationCount(company)}}
                </router-link>
              </template>
            </entity-header>
          </td>
          <td>
            <button type="button" @click="showCollaborators(company)" class="btn btn-light">
              <span>
                {{company.collaborator_count}}
                <i class="fa fa-users" aria-hidden="true"></i>
              </span>
            </button>
          </td>
          <td>
            <template v-if="company.owner.id == user.id">
              You
            </template>
            <template v-else>
              <router-link class="text-dark font-weight-bold" :to="{ name: 'user.profile', params:{id:company.owner.id} }">
                {{company.owner.name}}
              </router-link>
            </template>
          </td>
        </tr>
        <tr v-if="companies.length == 0">
          <td colspan="3" style="padding: 10px;"> No result </td>
        </tr>
      </tbody>
    </table>
    <collaborator-modal ref="collaborator-modal"/>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
import Form from 'vform'
import { mapGetters } from 'vuex'
import CollaboratorModal from './collaborator-modal'
export default {
  components: {
    CollaboratorModal
  },
  middleware: 'auth',
  metaInfo () {
    return { title: 'Company List' }
  },
  data : () =>({
    public_path: location.origin,
    companies:[],
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    applicationCount: function(company){
      return company.hiring_application_count ? company.hiring_application_count+' active applications' : 'no active applications';
    },
    async fetchCompanies (){
      const { data } = await axios({
        method: 'get',
        url: '/api/company/fetch/managed/companies',
      })
      this.companies = data.data;
    },
    showCompanyDetails(data){
      this.$refs['company-details-component'].showCompanyDetails(data);
    },
    showCollaborators(data){
      this.$refs['collaborator-modal'].show(data)
    }
  },
  mounted(){
    this.fetchCompanies();
  }
}
</script>
