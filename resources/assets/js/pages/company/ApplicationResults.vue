<template>
  <sidebar-popup ref="application-detail-modal">
    <div v-if="application" class="header-part">
      <entity-header>
        <template slot="icon">
          <iconized-photo size="medium-icon" photo="http://localhost:8000/images/member-placeholder.png"></iconized-photo>
        </template>
        <template slot="text">
          <div class="text-ellipsis">
            <router-link style="color: inherit; font-weight: bold;" :to="{ name: 'user.profile', params: { id: application.user.id} }">
              Uelmar Ortega
            </router-link>
          </div>
          <div class="text-muted text-ellipsis">Applying for {{application.opening.title}}</div>
        </template>
        <template slot="buttons">
          <button type="button" style="margin-top: -40px;" v-on:click="close" class="btn btn-light">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </template>
      </entity-header>
      
      <div style="padding: 25px 50px;">
        <progress-step :class="checkIfFinished(application) ? 'finished' : ''" ref="progress-component">
          <template slot="steps">
            <li class="step" :class="hiringStepsWithResult(application, step).result ? 'active' : ''" v-for="(step, index) in application.opening.hiring_procedure.hiring_steps" v-bind:key="index">
              <div class="circle" data-toggle="tooltip" data-html="true" :title="'<b>'+step.name+'</b><p>'+(step.description ? step.description : '')+'</p>'"></div>
            </li>
          </template>
        </progress-step>
      </div>
    </div>
    <div class="main-container" v-if="application">
      <div ref="rate-form" class="panel has-footer">
        <div class="text-center container-body">
          <div v-for="(result, index) in application.hiring_step_results" v-bind:key="index">
            <h3 class="font-weight-bold"><span class="badge badge-pill badge-primary">{{getResultStep(result).name}}</span></h3>
            <p class="text-justify"> Result is {{result.result}} out of 10. </p>
            <p class="text-justify" v-for="(note, index) in result.notes" v-bind:key="index">
              <b>{{note.title}}</b>
              <br>
              {{note.note}}
            </p>
          </div>
        </div>
        <div class="footer">
          <button type="button" v-on:click="close" class="btn btn-light btn-sm">Close</button>
        </div>
      </div>
    </div>
  </sidebar-popup>
</template>

<script>

import ProgressStep from './../../components/ProgressStep'
import SidebarPopup from './../../components/SidebarPopup'
import Form from 'vform'
import Vue from 'vue'
import swal from 'sweetalert2'
[
  SidebarPopup,
  ProgressStep,
].forEach(Component => {
  Vue.component(Component.name, Component)
})
export default {
  name: 'ApplicationResults',
  data: () => ({
    application: null
  }),
  mounted () {
    // jQuery(this.$el).find('.panel').hide();
    // jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    showApplicationResults(data){
      this.application = data;
      this.$refs['application-detail-modal'].show();
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
    close(){
      this.$refs['application-detail-modal'].hide();
    },
    hiringStepsWithResult(application, step){
      for(var i = 0; i < application.hiring_step_results.length; i++){
        if(application.hiring_step_results[i].hiring_step_id == step.id){
          step.result = application.hiring_step_results[i]
        }

      }
      return step;
    },
    getResultStep(result){
      var step = null;

      for(var i = 0; i < this.application.opening.hiring_procedure.hiring_steps.length; i++){
        if(result.hiring_step_id == this.application.opening.hiring_procedure.hiring_steps[i].id){
          step = this.application.opening.hiring_procedure.hiring_steps[i];
          i = this.application.opening.hiring_procedure.hiring_steps.length;
        }
      }
      return step;
    }
  },
}
</script>
<style lang="sass" scoped>
  .header-part{
    position: absolute; 
    top: 15px; 
    height: 120px; 
    width: 100%;
  }
  .main-container{
    position: absolute;
    top: 135px;
    bottom: 0px;
    width: 100%;
    padding: 15px;
    overflow: auto;
  }
  .has-footer{
    position: relative;
    padding-bottom: 50px;
    height: 100%;
    .container-body{
      position: absolute;
      width: 100%;
      top: 0px;
      bottom: 50px;
      overflow: auto;
      border-bottom: 1px solid #cecece;
    }
  }
  .note-card{
    background: #fafafa;
    font-size: 12px;
    text-align:left;
    border-bottom: 1px solid #ececec;
    padding: 10px;
    .note-header{
      font-weight: bold;
    }
  }
  .footer{
    position: absolute;
    bottom: 0px;
    width: 100%;
  }
</style>

