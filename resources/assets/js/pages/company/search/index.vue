<template>
  <div class="row">
    <div class="col-md-12">
      <search-bar @update="updateCompanies"/>
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
import CompanyCard from './../CompanyCard'
import SearchBar from './search-bar'

export default {
  components: {
    CompanyCard,
    SearchBar
  },
  data : () =>({
    public_path: location.origin,
    companies: [],
  }),
  methods: {
    updateCompanies(data){
      this.companies = data
    }
  },
}
</script>
