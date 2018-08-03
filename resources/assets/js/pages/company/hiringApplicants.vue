<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        Hiring Application List
      </div>
      <div class="col-md-3">
        <div class="input-group input-group-sm mb-3">
          <input type="text" placeholder="Search Company" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div class="unick-table">
      <div class="header">
        <div class="row item-row">
          <div class="col-md-4 part">
            Applicant
          </div>
          <div class="col-md-8 part">
            Progress
          </div>
        </div>
      </div>
      <div class="body">
        <div class="row item-row" v-for="(application, index) in applications" v-bind:key="index">
          <div class="col-md-4 part">
            <div class="text-truncate">
            <router-link class="n" :to="{ name: 'user.profile', params: { id: application.user.id }}">
              <iconized-photo size="medium-icon" :photo="application.user.photo"></iconized-photo>
              {{application.user.name}}
            </router-link>
            : <router-link class="n" :to="{ name: 'opening.profile', params: { id: application.opening.id }}">
                {{application.opening.title}}
              </router-link>
            </div>
          </div>
          <div class="col-md-8 part progress-line-container">
            <progress-step :class="checkIfFinished(application) ? 'finished' : ''">
              <template slot="steps">
                <li class="step" :class="hiringStepsWithResult(application, step).result ? 'active' : ''" v-for="(step, index) in application.opening.hiring_procedure.hiring_steps" v-bind:key="index">
                  <div class="circle" data-toggle="tooltip" data-html="true" :title="'<b>'+step.name+'</b><p>'+(step.description ? step.description : '')+'</p>'"></div>
                </li>
              </template>
            </progress-step>
          </div>
          <div class="col-md-12">
            <div class="p-10">
              <button type="button" v-if="application.hiring_step_results.length > 0" v-on:click="displayApplicationDetail(application)" class="btn btn-primary btn-sm">Proceed To Next Step</button>
              <button type="button" v-else-if="application.hiring_step_results.length == 0" v-on:click="displayApplicationDetail(application)" class="btn btn-primary btn-sm">Start Hiring Procedure</button>
              <button type="button" v-if="application.hiring_step_results.length > 0" v-on:click="showApplicationResults(application)" class="btn btn-info btn-sm">View Results</button>
            </div>
          </div>
        </div>
        <div class="row item-row" v-if="applications.length == 0">
          <div class="col-md-12 p-10 p-r-50 h-d-f-r">
            <center> Nothing to show </center>
          </div>
        </div>
      </div>
    </div>

    <application-detail @update="updateApplicationResult" ref="application-detail-component"></application-detail>
    <application-results ref="application-application-results-component"></application-results>
  </div>
</template>

<script>
import axios from 'axios'
import ProgressStep from './../../components/ProgressStep'
import ApplicationDetail from './ApplicationDetail'
import ApplicationResults from './ApplicationResults'
import Vue from 'vue'
[
  ProgressStep,
  ApplicationDetail,
  ApplicationResults,
].forEach(Component => {
  Vue.component(Component.name, Component)
})

export default {
  middleware: 'auth',
  data : () =>({
    public_path: location.origin,
    company_id: null,
    company: {},
    applications: [],
  }),
  methods: {
    fetch_company: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch',
          params: { company_id: this.company_id }
        })
      this.company = data.data;
    },
    fetch_applications: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch/hiring/applications',
          params: { company_id: this.company_id }
        })
      this.applications = data;
    },
    setTooltip: function(){
      console.log(el);
      // jQuery(el).tooltip();
    },
    displayApplicationDetail(data){
      this.$refs['application-detail-component'].showApplication(data);
    },
    updateApplicationResult(data){
      console.log(data);
      for(var i = 0; i < this.applications.length; i++){
        if(data.hiring_application_id == this.applications[i].id){
          this.applications[i].hiring_step_results.push(data);
        }
      }      
    },
    hiringStepsWithResult(application, step){
      for(var i = 0; i < application.hiring_step_results.length; i++){
        if(application.hiring_step_results[i].hiring_step_id == step.id){
          step.result = application.hiring_step_results[i]
        }

      }
      return step;
    },
    checkIfFinished(application){
      var finished = true;
      for(var i = 0; i < application.opening.hiring_procedure.hiring_steps.length; i++){
        var foundStepResult = false;
        for(var x = 0; x < application.hiring_step_results.length; x++){
          if(application.hiring_step_results[x].hiring_step_id == application.opening.hiring_procedure.hiring_steps[i].id){
            foundStepResult = true;
            x = application.hiring_step_results.length;
          }
        }
        finished = foundStepResult;
        if(!finished){
          i = application.opening.hiring_procedure.hiring_steps.length;
        }
      }
      return finished;
    },
    showApplicationResults(data){
      this.$refs['application-application-results-component'].showApplicationResults(data);
    }
  },
  computed:{
    // 
  },
  created: function(){
    this.company_id = this.$route.params.id;
    this.fetch_applications();
    this.fetch_company();
    jQuery(this.$el).find('[data-toggle="tooltip"]').tooltip();
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
