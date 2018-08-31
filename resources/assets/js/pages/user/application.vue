<template>
  <card title="Application" v-if="application">
    <div class="row">
      <div class="col-md-4">
        <opening-card :noApply="true" :opening="application.opening"/>
      </div>
      <div class="col-md-8 border-left-md">
        <div class="media">
          <img class="mr-3" style="width: 50px;" :src="application.user.photo" alt="Generic placeholder image">
          <div class="media-body">
            <h5 class="mt-0 mb-1">{{application.user.name}}</h5>
            <p v-html="application.application_letter"></p>
          </div>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',

  data : () =>({
    public_path: location.origin,
    application: null,
  }),
  methods: {
    fetch_application: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/application/fetch/one',
          params: { application_id: this.$route.params.application_id }
        })
      this.application = data.application
    }
  },
  mounted(){
    this.fetch_application();
  },
  watch: {
    $route(){
      this.fetch_application();
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
