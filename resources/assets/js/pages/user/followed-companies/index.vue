<template>
  <div class="simple-card">
    <div class="simple-card-header">
      <div class="row">
        <div class="col-md-8">
          Followed Companies
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
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th>Company</th>
          <th>Option</th>
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
                <div class="text-muted text-ellipsis">
                  {{company.address}}
                </div>
              </template>
            </entity-header>
          </td>
          <td>
            <button type="button" @click="unFollowCompany(company)" class="btn btn-outline-warning btn-sm">Unfollow</button>
          </td>
        </tr>
        <tr v-if="companies.length == 0">
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
    return { title: 'Company List' }
  },
  data : () =>({
    public_path: location.origin,
    companies:[],
    followed_companies:[],
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    async fetchCompanies(){
      const { data } = await axios({
        method: 'get',
        url: '/api/userInfo/fetch/followed/companies',
      });
      this.companies = data;
    },
    async unFollowCompany(company){
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
            method: 'post',
            url: '/api/userInfo/add/follow/company',
            params: { follow: 0, company_id: company.id }
          }).then(data => {
            this.$emit('delete', this.opening);
            this.removeCompany(company)
            swal(
              'Unfollowed!',
              'Company has been un-followed.',
              'success'
            )
          })
        }
      })
    },
    removeCompany(company){
      for(var i = 0; i < this.companies.length; i++){
        if(this.companies[i].id == company.id){
          this.companies.splice(i,1)
          return true
        }
      }
    },
  },
  mounted(){
    this.fetchCompanies();
  }
}
</script>
