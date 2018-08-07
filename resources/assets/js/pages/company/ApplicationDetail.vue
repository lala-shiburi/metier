<template>
  <div>
    <sidebar-popup ref="application-detail-modal">
      <div v-if="application" class="header-part">
        <entity-header>
          <template slot="icon">
            <iconized-photo size="medium-icon" :photo="application.user.photo"></iconized-photo>
          </template>
          <template slot="text">
            <div class="text-ellipsis">
              <router-link style="color: inherit; font-weight: bold;" :to="{ name: 'user.profile', params: { id: application.user.id} }">
                {{application.user.name}}
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
      <div class="main-container">
        <div ref="initial-form" class="panel has-footer">
          <p class="text-center">
            Have you finished <b>{{this.currentStep.name}}</b>?
            <br>
            <br>
            <button type="button" class="btn btn-primary" v-on:click="displayRatePanel">Fill up results</button>
          </p>
          <div class="footer">
            <button type="button" class="btn btn-light btn-sm">Dismiss Application</button>
          </div>
        </div>
        <div ref="rate-form" class="panel has-footer">
          <form @submit.prevent="validateRateForm" @keydown="rateForm.onKeydown($event)">
            <div class="text-center container-body">
              Rate the result 1 to 10.
              <div class="form-group">
                  <b>Rate</b>
                  <div>
                    <select v-model="rateForm.result" :class="{ 'is-invalid': rateForm.errors.has('result') }" class="form-control" name="result">
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
        <div ref="note-form" class="panel has-footer">
          <div class="text-center container-body">
            <div class="text-muted">
              Do you have any special noted?
            </div>
            <button type="button" v-on:click="prepEditNote(false)" class="btn btn-success">Add Note</button>
            <br>
            <br>
            <div>
              <div class="note-card" v-for="(note, index) in notes" v-bind:key="index">
                <div class="note-header">{{note.title}}</div>
                <div>{{note.note}}</div>
                <br>
                <button type="button" v-on:click="prepEditNote(note, index)" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                <button type="button" v-on:click="prepDeleteNote(note, index)" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button>
              </div>
            </div>
          </div>
          <div class="footer">
            <button type="button" v-on:click="displayRatePanel" class="btn btn-secondary">Back</button>
            <button type="button" v-on:click="showSubmitPanel" class="btn btn-primary">Next</button>
          </div>
        </div>
        <div class="panel has-footer" ref="submit-form">
          <form @submit.prevent="validateStepResultForm" @keydown="stepResultForm.onKeydown($event)">
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
        <div class="panel has-footer" ref="done-panel">
          <form @submit.prevent="validateStepResultForm" @keydown="stepResultForm.onKeydown($event)">
            <div class="text-center">
              Result successfuly submitted.
              <br>
              <button type="button" v-on:click="showApplication(application)" class="btn btn-secondary">Proceed To Next Step</button>
            </div>
          </form>
        </div>
        <div class="panel has-footer" ref="finished-procedure-panel">
          <div class="text-center">
            <p>
              <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
            </p>
            Hiring procedure finished!
            <br>
            <button type="button" v-on:click="close" class="btn btn-secondary">Close</button>
          </div>
        </div>
      </div>
    </sidebar-popup>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <form style="width: 100%;" @submit.prevent="validateResultNote" @keydown="noteForm.onKeydown($event)">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Note</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Title</label>
                <div class="col-md-7">
                  <input v-model="noteForm.title" :class="{ 'is-invalid': noteForm.errors.has('title') }" class="form-control" name="title" rows="10"/>
                  <has-error :form="noteForm" field="title"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Note</label>
                <div class="col-md-7">
                  <textarea v-model="noteForm.note" :class="{ 'is-invalid': noteForm.errors.has('note') }" class="form-control" name="note" rows="10">
                  </textarea>
                  <has-error :form="noteForm" field="note"/>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <v-button :loading="noteForm.busy" type="success">Save</v-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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
  name: 'ApplicationDetail',
  data: () => ({
    application: false,
    rateForm: new Form({
      result: ''
    }),
    noteForm: new Form({
      title: '',
      note: '',
      currentIndex: -1
    }),
    stepResultForm: new Form({
      result: '',
      hiring_step_id: '',
      hiring_application_id: '',
      notes: []
    }),
    notes: [],
    currentStep:{},
    procedure_done: false
  }),
  mounted () {
    jQuery(this.$el).find('.panel').hide();
    jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    showApplication(data){

      // reset data
      Object.assign(this.$data, this.$options.data());
      
      this.application = data;
      this.$refs['application-detail-modal'].show();
      var $this = this;
      this.setNexTick(function () {
        $this.$refs['progress-component'].renderProgressLine();
      });

      this.displayInitPanel();

      // get current step
      var _steps = {};
      var next_step = {};
      for(var i = 0; i < data.opening.hiring_procedure.hiring_steps.length; i++){
        for(var x = 0; x < data.hiring_step_results.length; x++){
          if(data.hiring_step_results[x].hiring_step_id == data.opening.hiring_procedure.hiring_steps[i].id){
            var __step = data.opening.hiring_procedure.hiring_steps[i];
            if(__step.level >= (_steps.level ? _steps.level : 0)){
              _steps = __step;
              if(x < data.opening.hiring_procedure.hiring_steps.length - 1){
                next_step = data.opening.hiring_procedure.hiring_steps[i + 1];
              }
              else
              {
                this.procedure_done = true;
              }
            }
          }
        }
      }
      if(!this.procedure_done && !next_step.level){
        next_step = data.opening.hiring_procedure.hiring_steps[0];
      }

      this.currentStep = next_step;
      this.stepResultForm.hiring_step_id = next_step.id;
      this.stepResultForm.hiring_application_id = data.id;
      
      if(this.procedure_done){
        jQuery(this.$el).find('.panel').hide();
        jQuery(this.$refs['finished-procedure-panel']).show();
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
    close(){
      this.$refs['application-detail-modal'].hide();
    },
    displayInitPanel(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['initial-form']).show();
    },
    displayRatePanel(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['rate-form']).show();
    },
    async validateRateForm(){
      const { data } = await this.rateForm.post('/api/company/hiringprocess/validate/hiring/step/result');
      this.showNoteForm();
    },
    showNoteForm(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['note-form']).show();
    },
    showDonePanel(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['done-panel']).show();
    },
    prepEditNote(data,index){
      if(data){
        this.noteForm.currentIndex = index;
        this.noteForm.title = data.title;
        this.noteForm.note = data.note;
      }
      else{
        this.noteForm.reset();
      }
      jQuery(this.$refs.modal).modal('show');
    },
    prepDeleteNote(data, index){
      var $this = this;
      swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $this.notes.splice(index,1);
          swal(
            'Deleted!',
            'Step has been deleted.',
            'success'
          )
        }
      })
    },
    async validateResultNote(){
      const { data } = await this.noteForm.post('/api/company/hiringprocess/validate/hiring/step/note');
      if(this.noteForm.currentIndex >= 0)
      {
        this.notes[this.noteForm.currentIndex] = {
          title: this.noteForm.title,
          note: this.noteForm.note,
        }
        this.$forceUpdate()
      }
      else
      {
        this.notes.push({
          title: this.noteForm.title,
          note: this.noteForm.note,
        })
      }
      jQuery(this.$refs.modal).modal('hide');
    },
    async validateStepResultForm(){
      this.stepResultForm.result = this.rateForm.result;
      this.stepResultForm.notes = this.notes;
      const {data} = await this.stepResultForm.post('/api/company/hiringprocess/create/step/result');

      this.showDonePanel();

      this.$emit('update', data.hiringStepResult);
    },
    showSubmitPanel(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['submit-form']).show();
    },
    setNexTick(callback){
      Vue.nextTick(function () {
        callback();
      })
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

