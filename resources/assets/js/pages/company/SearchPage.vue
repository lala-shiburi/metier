<template>
  <div class="row">
    <div class="col-md-12">
      <card title="Company Search">
        <form @submit.prevent="initSearch" @keydown="searchForm.onKeydown($event)">
          <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="searchForm.keyword" placeholder="Company Seach">
            <div class="input-group-prepend">
              <label class="input-group-text">
                <input type="checkbox" v-model="searchForm.search_province" aria-label="Checkbox for following text input">
                Filter Province
              </label>
            </div>
            <select @change="searchForm.search_province = true" class="custom-select" v-model="searchForm.province">
              <option value="" selected>-select</option>
              <option v-for="(province, index) in provinces" v-bind:key="index" :value="province.name">
                {{ province.name }}
              </option>
              </select>
              <div class="input-group-append">
                  <v-button :loading="searchForm.busy" class="btn btn-outline-secondary" type="success">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </v-button>
              </div>
          </div>
        </form>
      </card>
    </div>
    <div class="col-md-12">
      <br>
      <div class="row">
        <div class="col-md-4 col-sm-6" v-for="(company, index) in companies" v-bind:key="index">
          <company-card :company="company"></company-card>
        </div>
      </div>
      <div class="text-muted text-center" v-if="companies.length == 0">
        Nothing to show.
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import Vue from 'vue'
import CompanyCard from './CompanyCard'

[
  CompanyCard,
].forEach(Component => {
  Vue.component(Component.name, Component)
})

export default {
  middleware: 'auth',
  data : () =>({
    public_path: location.origin,
    companies: [],
    provinces: window.config.provinces,
    searchForm: new Form({
      keyword: '',
      province: '',
      search_province: false
    }),
  }),
  methods: {
    initSearch: async function(){
      const { data } = await this.searchForm.post('/api/company/fetch/search');

      this.companies = data.companies;
      this.$forceUpdate();
    }
  },
  created: function(){
    this.company_id = this.$route.params.id;
  },
  mounted(){
    this.initSearch();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
