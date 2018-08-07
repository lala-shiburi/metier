<template>
  <div>
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
            <br>
            <div class="card h-d-f-r" v-for="(collaborator, index) in collaborators" v-bind:key="index">
              <div class="d-bttns p-15">
                <i v-on:click="prep_remove_collaborator(collaborator,index)" class="fa fa-close bttn"></i>
              </div>
              <div class="card-body">
                <h5 class="card-title">
                  <iconized-photo size="medium-icon" :photo="collaborator.photo"></iconized-photo>
                  {{collaborator.name}}
                </h5>
                </div>
              <div class="card-footer text-muted">
                {{formatedDate(collaborator.pivot.created_at,true)}}
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
    </sidebar-popup>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add New Collaborator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-4 has-border-right-sm" style="min-height: 300px;">
                <div class="text-center" v-if="collaboratorForm.user">
                  <div class="photo-preview-container" style="width: 100%; max-width: 200px; display: inline-block;">
                    <div class="scaffold-div">
                      <img class="bg-holder" :src="public_path+'/images/company.png'">
                      <img class="absolute-center" :src="collaboratorForm.user.photo">
                    </div>
                  </div>
                  <p class="h6">{{collaboratorForm.user.name}}</p>
                  <p><small>{{collaboratorForm.user.description}}</small></p>
                </div>
                <div class="text-center text-muted" v-else>
                  <br>
                  Please select desired collaborator.
                </div>
              </div>
              <div class="col-sm-8">
                <form style="width: 100%;" @submit.prevent="searchCollaborator" @keydown="searchCollaboratorForm.onKeydown($event)">
                  <div class="input-group">
                      <input type="text" placeholder="Search Collaborator" class="form-control" v-model="searchCollaboratorForm.keyword">
                      <div class="input-group-append">
                        <v-button :loading="searchCollaboratorForm.busy" type="success" class="btn btn-outline-secondary">
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </v-button>
                      </div>
                  </div>
                </form>
                <div class="collaborator-list">
                  <div class="collaborator-item" :class="user.id == (collaboratorForm.user ? collaboratorForm.user.id : null) ? 'active' : ''" v-on:click="selectCollaborator(user)" v-for="(user, index) in searchedCollaborator" v-bind:key="index">
                    <iconized-photo size="medium-icon" :photo="user.photo"></iconized-photo>
                    {{user.name}}
                  </div>
                  <div class="text-muted text-center" v-if="searchedCollaborator.length == 0">
                    <br>
                    Nothing to show.
                  </div>
                </div>
              </div>
            </div>
          </div>
          <form style="width: 100%;" @submit.prevent="addCollaborator" @keydown="collaboratorForm.onKeydown($event)">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <v-button :loading="collaboratorForm.busy" type="success">Save</v-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
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
    collaborators: [],
    collaboratorForm: new Form({
      user: null,
      company_id:null,
      priviledge: ''
    }),
    searchCollaboratorForm: new Form({
      keyword:''
    }),
    searchedCollaborator: [],
    selectedCollaborator: null
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
      this.collaboratorForm.reset();
      this.collaboratorForm.company_id = this.company.id;
    },
    async searchCollaborator(){
      const {data} = await this.searchCollaboratorForm.post('/api/userInfo/fetch/search');
      this.searchedCollaborator = data;
    },
    selectCollaborator(data){
      this.collaboratorForm.user = data;
    },
    async addCollaborator(){
      const { data } = await this.collaboratorForm.post('/api/company/add/collaborator');
      if(data.status == 'success'){
        this.fetchCollaborators();
        jQuery(this.$refs.modal).modal('hide');
      }
      else{
        swal({
          type: 'error',
          title: 'Oops...',
          text: data.message,
        })
      }
    },
    prep_remove_collaborator(data, index){
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
          axios({
            method: 'delete',
            url: '/api/company/delete/collaborator',
            params: { company_id: $this.company.id, user_id: data.id }
          }).then( data => {
            if(data.data.status == 'success'){
              $this.collaborators.splice(index, 1);
              $this.$forceUpdate();

              swal(
                'Deleted!',
                'Collaborator successfuly removed.',
                'success'
              )
            }
          });
        }
      });
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
  .collaborator-list{
    margin-top: 10px;
    & .collaborator-item{
      background: white;
      border-bottom: 1px solid #cecece;
      cursor: pointer;
      &:hover{
        background-color: #f9f9f9;
      }
      &.active{
        background: #e3e3e3;
      }
    }
  }
  .d-bttns{
    transform: initial;
    top: initial;
    bottom: -30px;
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

