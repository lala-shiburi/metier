<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        <router-link :to="{ name: 'company.hiringprocceses', params: {id:company_id} }" class="btn btn-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i></router-link> CREATE HIRING PROCEDURE
      </div>
    </div>
    <div class="unick-table">
      <form @submit.prevent="createProcess" @keydown="processForm.onKeydown($event)">
        <!-- Name -->
        <div class="row">
          <div class="col-md-6">
            <div><b>Name</b></div>
            <div>
              <input v-model="processForm.name" :class="{ 'is-invalid': processForm.errors.has('name') }" class="form-control" name="name">
              <has-error :form="processForm" field="name"/>
            </div>
            <div><b>Description</b></div>
            <div>
              <textarea v-model="processForm.description" :class="{ 'is-invalid': processForm.errors.has('description') }" class="form-control" name="description"/>
              <has-error :form="processForm" field="description"/>
            </div>
            <div style="padding: 10px 0px;">
              <v-button :loading="processForm.busy" type="success">SAVE</v-button>
              <button v-on:click="prep_edit" type="button" class="btn btn-primary pull-right">
                ADD STEP
              </button>
            </div>
          </div>
          <div class="col-md-6">
            <div class="p-10" style="margin-top:25px; border: 1px solid #cecece; border-radius: 4px;">
              <div class="header">
                <div class="row item-row">
                  <div class="col-md-12 part">
                    Hiring Steps
                  </div>
                </div>
              </div>
              <div class="body">
                <div class="row item-row" v-for="(step, index) in processForm.steps" v-bind:key="index">
                  <div class="col-md-12 p-10">
                    <div class="hiring-step-item">
                      <div class="left-buttons">
                        <i class="fa fa-arrow-up" v-on:click="moveStepUp(index, true)"></i>
                        <i class="fa fa-arrow-down" v-on:click="moveStepUp(index, false)"></i>
                      </div>
                      {{ step.name }}
                      <div class="right-buttons">
                        <i class="fa fa-edit" v-on:click="pre_edit(step, index)"></i>
                        <i class="fa fa-close" v-on:click="prep_delete(index)"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Basic Info</h5>
            <a class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </a>
          </div>
          <form @submit.prevent="validateStep" @keydown="stepForm.onKeydown($event)">
          <div class="modal-body">
              <!-- Name -->
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Name</label>
                <div class="col-md-7">
                  <input v-model="stepForm.name" :class="{ 'is-invalid': stepForm.errors.has('name') }" class="form-control" name="name">
                  <has-error :form="stepForm" field="name"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Description <span class="text-muted">(optional)</span></label>
                <div class="col-md-7">
                  <textarea v-model="stepForm.description" :class="{ 'is-invalid': stepForm.errors.has('description') }" class="form-control" name="description"/>
                  <has-error :form="stepForm" field="description"/>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-secondary" data-dismiss="modal" style="color: white;">Close</a>
            <v-button :loading="stepForm.busy" type="success">Save</v-button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import swal from 'sweetalert2'

export default {
  middleware: 'auth',
  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  },
  data : () =>({
    public_path: location.origin,
    company_id: null,
    stepForm: new Form({
      name: '',
      description: '',
      index: -1
    }),
    processForm: new Form({
      id: null,
      name: '',
      description: '',
      company_id: this.company_id,
      steps: [
        { name: 'Initial Exam' },
        { name: 'Initial Interview' },
        { name: 'Second Interview' },
        { name: 'Final Interview' },
      ]
    })
  }),
  methods: {
    prep_edit: function(){
      this.stepForm.reset();
      jQuery(this.$refs.modal).modal('show');
    },
    validateStep: async function(){
      const {data} = await this.stepForm.post('/api/company/hiringprocess/validate/process/step');

      if(this.stepForm.index > -1){
        this.processForm.steps[this.stepForm.index] = { 
          id: this.stepForm.id,
          name : this.stepForm.name, description: this.stepForm.description
        };

        this.$forceUpdate();
      }
      else{
        this.processForm.steps.push({name : this.stepForm.name});
      }
      jQuery(this.$refs.modal).modal('hide');
    },
    createProcess: async function(){
      const { data } = await this.processForm.post('/api/company/hiringprocess/create/process');

      this.$router.push('/company/'+this.company_id+'/hiringprocceses?newcreated='+data.hiringStepGroup.id);
    },
    moveStepUp: function(index, moveUp){
      var steps = this.processForm.steps;
      var step = steps[index];
      var result = [];

      if(moveUp){
        if(index != 0)
        {
          for(var i = 0; i < steps.length; i++){
            if(i == index - 1){
              result.push(step);
            }
            if(index != i){
              result.push(steps[i]);
            }
          }
          this.processForm.steps = result;
        }
      }
      else{
        if(index != this.processForm.steps.length -1)
        {
          for(var i = 0; i < steps.length; i++){
            if(index != i){
              result.push(steps[i]);
            }
            if(i == index + 1){
              result.push(step);
            }
          }
          this.processForm.steps = result;
        }
      }

    },
    pre_edit: function(data,index){
      this.stepForm.name = data.name;
      this.stepForm.id = data.id;
      this.stepForm.description = data.description;
      this.stepForm.index = index;
      jQuery(this.$refs.modal).modal('show');
    },
    prep_delete: function(index){
      var $this = this;
      if(this.processForm.steps.length < 2){
        swal({
          type: 'error',
          title: 'Oops...',
          text: 'Hiring process should atleast have one step!',
        })
      }
      else{
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
            $this.processForm.steps.splice(index,1);
            swal(
              'Deleted!',
              'Step has been deleted.',
              'success'
            )
          }
        })
      }
    }
  },
  created: async function(){
    this.company_id = this.$route.params.company_id;
    this.processForm.company_id = this.company_id;

    if(this.$route.params.id){
      var $this = this;
      const {data} = await axios({
          method: 'get',
          url: '/api/company/hiringprocess/fetch/one/process',
          params: { id: $this.$route.params.id }
      })

      $this.processForm.id = data.hiringProcess.id;
      $this.processForm.name = data.hiringProcess.name;
      $this.processForm.description = data.hiringProcess.description;
      $this.processForm.steps = data.hiringProcess.hiring_steps;
    }
  },
  mounted(){
    // 
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
