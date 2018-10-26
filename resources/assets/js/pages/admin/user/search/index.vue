<template>
  <div class="row">
    <div class="col-lg-12">
      <search-bar @update="updateOpenings"/>
      <br>
    </div>
    <div class="col-lg-12">
      <div class="row">
        <div class="col-md-4 col-lg-3" v-for="(opening,index) in openings" v-bind:key="index">
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
import SearchBar from './search-bar'

export default {
  components: {
    SearchBar
  },
  metaInfo () {
    return { title: 'Manage Users' }
  },
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
    updateOpenings: function(data){
      this.openings = data;
    }
  },
}
</script>