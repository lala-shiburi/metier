<template>
  <div class="row">
    <div class="col-md-12">
      <unick-table :columnHeaders="tableColumns" :rows="applications"></unick-table>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Hiring Applications' }
  },
  data : () =>({
    applications: [],
    public_path: location.origin,
    user : {},
    tableColumns : [
      {text:'Job', function: function(){}}, 
      {text:'Company', function: function(){}},
      {text:'Date Submitted', function: function(){}}
    ]
  }),
  methods: {
    async fetchApplications(){
      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/hiringApplications',
        params: { user_id: this.user.id }
      })
      this.applications = data.hiringApplications;
    }
  },
  mounted(){
    this.user = this.$store.getters['auth/user'];
    this.fetchApplications();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
