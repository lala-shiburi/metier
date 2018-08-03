<template>
  <div class="row">
    <div class="col-md-12">
      <card title="Opening Search">
        <form @submit.prevent="initSearch" @keydown="searchForm.onKeydown($event)">
          <div class="input-group mb-3">
            <input type="text" class="form-control" v-model="searchForm.keyword" placeholder="Opening Seach">
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
        <div class="col-md-6" v-for="(opening,index) in openings" v-bind:key="index">
          <opening-card :opening="opening"></opening-card>
        </div>
      </div>
      <div class="text-muted text-center" v-if="openings.length == 0">
        Nothing to show.
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import Vue from 'vue'

[
  // 
].forEach(Component => {
  Vue.component(Component.name, Component)
})

export default {
  middleware: 'auth',
  data : () =>({
    public_path: location.origin,
    openings: [],
    provinces: window.config.provinces,
    searchForm: new Form({
      keyword: '',
      province: '',
      search_province: false
    }),
  }),
  methods: {
    initSearch: async function(){
      const { data } = await this.searchForm.post('/api/opening/fetch/search');

      this.openings = data.openings;
    }
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
