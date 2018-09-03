<template>
  <card title="Application" v-if="application">
    <div class="row">
      <div class="col-md-4">
        <p><strong>Job Opening</strong></p>
        <opening-card :noApply="true" :opening="application.opening"/>
      </div>
      <div class="col-md-8 border-left-md">
        <p><strong>Progress</strong></p>
        <div class="progress-container">
          <application-progress-line :application="application" @update="updateCurrent" />
        </div>
        <div v-if="current_step">
          <div>
            <strong>Current Step : </strong> {{current_step.name}}
          </div>
          <div v-if="current_step.description">
            <strong>Step Description : </strong>
            {{current_step.description}}
          </div>
        </div>
        <div v-else class="alert alert-secondary" role="alert">
          Application procedure is finished.
        </div>
        <br>
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
import ApplicationProgressLine from './../../components/hiring/application-progress-line'
export default {
  middleware: 'auth',
  components:{
    ApplicationProgressLine
  },
  data : () =>({
    public_path: location.origin,
    application: null,
    current_step: null,
    application_finished: false
  }),
  methods: {
    fetch_application: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/application/fetch/one',
          params: { application_id: this.$route.params.application_id }
        })
      this.application = data.application
    },
    updateCurrent(data){
      this.current_step = data.step;
      this.application_finished = data.finished;
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

<style lang="scss" scoped>
.progress-container{
  padding: 20px;
  border-bottom: 1px solid #cecece;
  margin-bottom: 35px;
  padding-bottom: 40px;
}
</style>

