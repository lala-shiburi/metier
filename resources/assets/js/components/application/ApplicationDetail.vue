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
          <div class="text-muted text-ellipsis">Applying for Soft Developer Position</div>
        </template>
        <template slot="buttons">
          <button type="button" v-on:click="close" class="btn btn-light">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </template>
      </entity-header>
      
      <div style="padding: 25px 50px;;">
        <progress-step>
          <template slot="steps">
            <li class="step" v-for="(step, index) in application.opening.hiring_procedure.hiring_steps" v-bind:key="index">
              <div class="circle" data-toggle="tooltip" data-html="true" :title="'<b>'+step.name+'</b><p>'+(step.description ? step.description : '')+'</p>'"></div>
            </li>
          </template>
        </progress-step>
      </div>
    </div>
    <div class="main-container">
      <div ref="initial-form" class="panel has-footer">
        <p class="text-center">
          Have you finished <b>Initial interview</b>?
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
      <div class="panel" ref="submit-form">
        <div class="text-center">
          You have completed the field requirements. Please click submit.
          <button type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
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
    notes: [],
  }),
  mounted () {
    jQuery(this.$el).find('.panel').hide();
    jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    showApplication(data){
      Object.assign(this.$data, this.$options.data());
      this.application = data;
      this.$refs['application-detail-modal'].show();
      this.displayInitPanel();
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

      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['note-form']).show();
      console.log(data);
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
      jQuery('.modal-backdrop').removeClass("modal-backdrop");  
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
    showSubmitPanel(){
      jQuery(this.$el).find('.panel').hide();
      jQuery(this.$refs['submit-form']).show();
    }
  }
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

