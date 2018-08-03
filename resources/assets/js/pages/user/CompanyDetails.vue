<template>
  <sidebar-popup ref="application-detail-modal">
    <div v-if="company" class="contents">
      <div class="photos-container">
        <div class="photo-preview-container cover">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-cover.png'">
            <img class="absolute-center" :src="public_path+'/images/register-background.png'">
          </div>
        </div>
        <div class="photo-preview-container logo">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/company.png'">
            <img class="absolute-center" :src="company.photo">
          </div>
          <div class="company-name">{{company.name}}</div>
        </div>
      </div>
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#applications" role="tab" aria-controls="profile" aria-selected="false">Applications</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#collaborators" role="tab" aria-controls="home" aria-selected="true">Collaborators</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="applications">
          <div class="card" v-for="(application, index) in applications" v-bind:key="index">
            <div class="card-body">
              <h5 class="card-title">
                <iconized-photo size="medium-icon" :photo="application.user.photo"></iconized-photo>
                {{application.user.name}}
              </h5>
              <p class="card-text">
                <span v-html="application.application_letter"></span>
              </p>
              </div>
            <div class="card-footer text-muted">
              Submitted {{formatedDate(application.created_at,true)}}
            </div>
          </div>
          <div class="text-center text-muted" v-if="applications.length == 0">
            <br>
            <br>
            <br>
            Nothing to show.
          </div>
        </div>
        <div class="tab-pane fade" id="collaborators">
          <div class="text-center">
            <button type="button" v-on:click="prepEditCollaborator" class="btn btn-primary btn-sm">Add Collaborator</button>
          </div>
          <div class="card" v-for="(collaborator, index) in collaborators" v-bind:key="index">
            <div class="card-body">
              <h5 class="card-title">
                <iconized-photo size="medium-icon" :photo="collaborator.photo"></iconized-photo>
                {{collaborator.name}}
              </h5>
              </div>
            <div class="card-footer text-muted">
              {{formatedDate(collaborator.created_at,true)}}
            </div>
          </div>
          <div class="text-center text-muted" v-if="collaborators.length == 0">
            <br>
            <br>
            <br>
            Nothing to show.
          </div>
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

import SidebarPopup from './../../components/SidebarPopup'
import Form from 'vform'
import Vue from 'vue'
import swal from 'sweetalert2'
import axios from 'axios'
[
  SidebarPopup,
].forEach(Component => {
  Vue.component(Component.name, Component)
})
export default {
  name: 'CompanyDetails',
  data: () => ({
    company: null,
    public_path: location.origin,
    applications: [],
    collaborators: []
  }),
  mounted () {
    // jQuery(this.$el).find('.panel').hide();
    // jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    showCompanyDetails(data){
      // reset data
      Object.assign(this.$data, this.$options.data());

      jQuery(this.$el).find('.contents').scrollTop(0);
      this.company = data;
      var $this = this;
      jQuery(this.$el).find('.company-name').hide();
      this.$refs['application-detail-modal'].show();
      setTimeout(function(){
        jQuery($this.$el).find('.company-name').show();
        $this.fetchApplications()
        $this.fetchCollaborators()
      },10);
    },
    async fetchApplications(){
      const { data } = await axios({
        method: 'get',
        url: '/api/company/fetch/hiring/applications2',
        params: { company_id: this.company.id }
      });
      this.applications = data
    },
    async fetchCollaborators(){
      const { data } = await axios({
        method: 'get',
        url: '/api/company/fetch/collaborators',
        params: { company_id: this.company.id },
      });

      this.collaborators = data;
    },
    prepEditCollaborator(){
      jQuery(this.$refs.modal).modal('show');
    }
  },
}
</script>
<style lang="sass" scoped>
  .contents{
    overflow: auto;
    height: 100%;
  }
  .photos-container{
    position: relative; 
    & .cover{
      padding: 0px;
      .scaffold-div{
        border:none;
      }
    }
    & .logo{
      position: absolute;
      bottom: 5px;
      width: 100px;
      left: 5px;
      .scaffold-div{
        background: white;
        z-index: 1;
      }

      & .company-name{
        z-index: 0;
        position: absolute;
        background: white;
        font-size: 25px;
        padding: 0 10px;
        left: 100%;
        margin-left: -5px;
        bottom: 5px;
        white-space: nowrap;
        border-left: 1px solid #f5f5f5;
        animation: display-scale-opacity-animate 1000ms both;
      }
    }
  }
  .nav-tabs{
    .nav-link{
      border-radius: initial;
    }
  }
  #myTabContent{
    .tab-pane{
      padding: 15px;
      .card{
        margin-bottom: 5px;
      }
    }
  }
  @keyframes display-scale-opacity-animate{
  0%{
    transform: translateX(-100%);
  }
  10%{
    transform: translateX(-50%);
  }
  50%{
    transform: translateX(-30%);
  }
  100%{
    transform: translateX(0);
  }
}
</style>

