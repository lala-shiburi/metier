<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        Company List
      </div>
      <div class="col-md-3">
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
            Add Company
          </router-link>
        </li>
      </ul>
    </div>
    <table class="table table-hover simple-table">
      <thead>
        <tr>
          <th>Company</th>
          <th>Population</th>
          <th>Active Applications</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(company, index) in company_result" v-bind:key="index">
          <td>
            <router-link class="n" :to="{ name: 'company.profile', params: { id: company.id}}">
              <iconized-photo size="medium-icon" :photo="company.photo"></iconized-photo>{{company.name}}
            </router-link>
          </td>
          <td v-html="population(company)"></td>
          <td>
            <button type="button" class="btn btn-primary btn-sm" :disabled="company.hiring_application_count == 0 ? true : null">
              {{company.hiring_application_count}}
            </button>
          </td>
        </tr>
        <tr v-if="company_result.length == 0">
          <td colspan="3" style="padding: 10px;"> No result </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'CompanySearchTable',

  props: {
    size: { type: String, default: null },
  },

  data: () => ({
    public_path: location.origin,
    company_result: []
  }),
  methods: {
    population: function(company){
      return company.employee_count ? company.employee_count : '<p class="text-muted">unknown</p>';
    },
    async fetchCompanies (){
      const { data } = await axios({
        method: 'get',
        url: '/api/company/datatable',
        params: { item_id: 1 }
      })
      this.company_result = data.data;
    }
  },
  mounted(){
    this.fetchCompanies();
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
