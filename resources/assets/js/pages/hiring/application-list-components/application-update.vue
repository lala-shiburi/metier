<template>
  <div>
    <sidebar-popup ref="application-detail-modal">
      <div class="header-part">
        <entity-header v-if="application.id">
          <template slot="icon">
            <iconized-photo size="medium-icon" :photo="application.user.photo"></iconized-photo>
          </template>
          <template slot="text">
            <div class="text-ellipsis">
              {{application.user.name}}
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
          <application-progress-line ref="progress-component" :application="application"/>
        </div>
      </div>
      <div class="main-container" ref="panels-container">
        <div class="initial-form panel has-footer">
          <p class="text-center">
            Have you finished <b>{{this.currentStep.name}}</b>?
            <br>
            <br>
            <button type="button" class="btn btn-primary" v-on:click="displayRatePanel">Fill up results</button>
          </p>
        </div>
        <div class="rate-form panel has-footer">
          <form @submit.prevent="validateRateForm" @keydown="rateForm.onKeydown($event)">
            <div class="text-center container-body">
              Rate the result 1 to 10.
              <div class="form-group">
                  <b>Rate</b>
                  <div>
                    <select v-model="rateForm.result" :class="{ 'is-invalid': rateForm.errors.has('result') }" class="custom-select" name="result">
                      <option value="" selected>-select</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                    <has-error :form="rateForm" field="result"/>
                  </div>
                  <br>
              </div>
            </div>
            <div class="footer">
              <v-button :loading="rateForm.busy" type="success">Next</v-button>
            </div>
          </form>
        </div>
        <div class="note-form panel has-footer">
          <note-adder :notes="notes"/>
          <div class="footer">
            <button type="button" v-on:click="displayRatePanel" class="btn btn-secondary">Back</button>
            <button type="button" v-on:click="showSubmitPanel" class="btn btn-primary">Next</button>
          </div>
        </div>
        <div class="panel has-footer submit-form">
          <form @submit.prevent="submitResult" @keydown="stepResultForm.onKeydown($event)">
            <div class="container-body">
              Result is {{rateForm.result}} out of 10.
              <div>
                <br>
                <h4>
                  Notes
                </h4>
                <dl>
                  <div class="note-card" v-for="(note, index) in notes" v-bind:key="index">
                    <dt>{{note.title}}</dt>
                    <dd>- {{note.note}}</dd>
                  </div>
                </dl> 
              </div>
            </div>
            <div class="footer">
              <button type="button" v-on:click="showNoteForm" class="btn btn-secondary">Back</button>
              <v-button :loading="stepResultForm.busy" type="success">Submit</v-button>
            </div>
          </form>
        </div>
        <div class="panel has-footer done-panel">
          <div class="text-center">
            Result successfuly submitted.
            <div class="clearfix"></div>
            <br>
            <button type="button" v-on:click="showApplication(application)" class="btn btn-primary">Proceed To Next Step</button>
          </div>
        </div>
        <div class="panel has-footer finished-procedure-panel">
          <div class="text-center">
            <p>
              <i class="fa fa-check-circle text-success fa-4x" aria-hidden="true"></i>
            </p>
            Hiring procedure finished!
            <div class="clearfix"></div>
            <br>
            <button type="button" v-on:click="close" class="btn btn-secondary">Close</button>
          </div>
        </div>
      </div>
    </sidebar-popup>
  </div>
</template>

<script>

import ApplicationProgressLine from './../../../components/hiring/application-progress-line'
import SidebarPopup from './../../../components/SidebarPopup'
import Form from 'vform'
import Vue from 'vue'
import swal from 'sweetalert2'
import axios from 'axios'
import NoteAdder from './note-adder'

export default {
  components:{
    ApplicationProgressLine,
    SidebarPopup,
    NoteAdder
  },
  name: 'ApplicationUpdate',
  data: () => ({
    application: {},
    rateForm: new Form({
      result: ''
    }),
    stepResultForm: new Form({
      result: '',
      hiring_step_id: '',
      hiring_application_id: '',
      notes: []
    }),
    notes: [],
    currentStep:{},
    hiring_steps: [],
    hiring_step_results: [],
    procedure_done: false,
    panelManager:null,
  }),
  mounted () {
    this.panelManager = new panelManager(this.$refs['panels-container']);
    jQuery(this.$el).find('.panel').hide();
    jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    showApplication(data){
      this.reset();
      this.panelManager.hideAll();
      this.$refs['application-detail-modal'].show();
      this.application = data.application;
      this.rerenderProgressLine();

      this.fetchProcedure();
    },
    async submitResult(){
      this.stepResultForm.result = this.rateForm.result;
      this.stepResultForm.notes = this.notes;
      this.stepResultForm.hiring_step_id = this.currentStep.id;
      this.stepResultForm.hiring_application_id = this.application.id;
      const {data} = await this.stepResultForm.post('/api/company/hiringprocess/create/step/result');

      this.showDonePanel();
      this.hiring_step_results.push(data.hiringStepResult);
      this.reset();
      this.$emit('update', data.hiringStepResult);
    },
    showAppropriatePanel(){
      if(this.procedure_done){
        this.panelManager.showPanel('.finished-procedure-panel');
      }
      else{
        this.panelManager.showPanel('.initial-form');
      }
    },
    rerenderProgressLine(){
      var $this = this;
      console.log(this);
      Vue.nextTick(function () {
        $this.$refs['progress-component'].fetchApplication();
      })
      
    },
    close(){
      this.$refs['application-detail-modal'].hide();
    },
    reset(){
      this.rateForm.reset()
      this.stepResultForm.reset();
      this.notes = [],
      this.findCurrentStep();
      this.rerenderProgressLine();
      this.showAppropriatePanel();
    },
    showNoteForm(){
      this.panelManager.showPanel('.note-form');
    },
    showDonePanel(){
      this.panelManager.showPanel('.done-panel');
    },
    displayRatePanel(){
      this.panelManager.showPanel('.rate-form');
    },
    async validateRateForm(){
      const { data } = await this.rateForm.post('/api/company/hiringprocess/validate/hiring/step/result');
      this.showNoteForm();
    },
    showSubmitPanel(){
      this.panelManager.showPanel('.submit-form');
    },
    async fetchProcedure(){
      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/hiring/step/results',
        params: { application_id : this.application.id },
      })
      
      this.hiring_steps = data.hiring_steps;
      this.hiring_step_results = data.hiring_step_results;
      this.findCurrentStep();
      this.showAppropriatePanel();
    },
    findCurrentStep(){
      for(var i = 0; i < this.hiring_steps.length; i++){
        var result_found = this.getStepMatchedResult(this.hiring_steps[i]);

        if(result_found){
          if(this.hiring_steps.length - 1 == i ){
            this.procedure_done = true;
            console.log('finished')
          }
          else{
            if(!this.getStepMatchedResult(this.hiring_steps[i])){
              this.currentStep = this.hiring_steps[i]
              i = this.hiring_steps.length;
              this.procedure_done = false;
            }
          }
        }
        else{
          this.currentStep = this.hiring_steps[i]
          i = this.hiring_steps.length;
          this.procedure_done = false;
        }
      }
    },
    getStepMatchedResult(step){
      var result_found;
      for(var x = 0; x < this.hiring_step_results.length; x++){
        if(step.id == this.hiring_step_results[x].hiring_step_id){
          result_found = step;
        }
      }

      return result_found;
    }
  },
}
</script>
<style lang="scss" scoped>
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

