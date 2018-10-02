<template>
  <card title="Company Search">
    <form @submit.prevent="search" @keydown="searchForm.onKeydown($event)">
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
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import CompanyCard from './../CompanyCard'

export default {
  components: {
    CompanyCard
  },
  data : () =>({
    provinces: window.config.provinces,
    searchForm: new Form({
      keyword: '',
      province: '',
      search_province: false
    }),
  }),
  methods: {
    search: async function(){
      const { data } = await this.searchForm.post('/api/company/fetch/search')

      this.$emit('update', data.companies)
    }
  },
  mounted(){
    this.search();
  }
}
</script>
