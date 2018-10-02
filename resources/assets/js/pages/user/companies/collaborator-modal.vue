<template>
  <div>
    <sidebar-popup ref="application-detail-modal">
      <div v-if="company" class="contents">
        <div class="photos-container" style="min-height: 100px;">
          <div class="photo-preview-container cover">
            <div class="scaffold-div">
              <img class="bg-holder" :src="public_path+'/images/bg-cover.png'">
              <img class="absolute-center" :src="company.cover">
            </div>
          </div>
          <div class="photo-preview-container logo">
            <div class="scaffold-div">
              <img class="bg-holder" :src="public_path+'/images/company.png'">
              <img class="absolute-center" :src="company.photo">
            </div>
            <div class="company-name">{{company.name}}</div>
          </div>
          <button type="button" style="position:absolute; top: 0px; right: 0px;" v-on:click="closeCollaboratorModal" class="btn btn-light rounded-0">
            <i class="fa fa-close" aria-hidden="true"></i>
          </button>
        </div>
        <div class="p-15">
          <div class="text-center" v-if="enableEdit">
            <button type="button" v-on:click="prepEditCollaborator" class="btn btn-primary btn-sm">Add Collaborator</button>
          </div>
          <br>
          <div class="card mb-3" v-for="(collaborator, index) in collaborators" v-bind:key="index">
            <div class="card-body">
              <h5 class="card-title">
                <iconized-photo size="medium-icon" :photo="collaborator.photo"></iconized-photo>
                {{collaborator.name}}
              </h5>
              <span class="badge badge-pill badge-primary" v-if="collaborator.id == company.owner_id">Company Owner</span>
            </div>
            <div class="card-footer text-muted">
              {{formatedDate(collaborator.pivot.created_at,true)}}
              <button v-if="enableEdit && collaborator.id != company.owner_id" class="btn btn-light pull-right" v-on:click="prep_remove_collaborator(collaborator,index)">
                <i class="fa fa-close bttn"></i>
              </button>
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
    </sidebar-popup>
    <sidebar-popup ref="collaborator-search-modal">
      <div class="border-bottom">
        <h6 class="p-15">
          Select Collaborator
        </h6>
      </div>
      <template slot="options">
        <button type="button" v-on:click="closeSelectCollaboratorModal" class="btn btn-light">
          <i class="fa fa-close" aria-hidden="true"></i>
        </button>
      </template>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
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
          <button type="button" class="btn btn-secondary" @click="closeSelectCollaboratorModal">Close</button>
          <v-button :loading="collaboratorForm.busy" :disabled="!collaboratorForm.user" type="success">Save</v-button>
        </div>
      </form>
    </sidebar-popup>
  </div>
</template>

<script>

import SidebarPopup from '~/components/SidebarPopup'
import Form from 'vform'
import Vue from 'vue'
import { mapGetters } from 'vuex'
import swal from 'sweetalert2'
import axios from 'axios'
[
  SidebarPopup,
].forEach(Component => {
  Vue.component(Component.name, Component)
})
export default {
  components:{SidebarPopup},
  computed: mapGetters({
    user: 'auth/user'
  }),
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
    selectedCollaborator: null,
    enableEdit: false,
  }),
  mounted () {
    // jQuery(this.$el).find('.panel').hide();
    // jQuery(this.$refs['initial-form']).show();
  },
  methods: {
    show(company){

      // reset data
      Object.assign(this.$data, this.$options.data());

      // check if auth owns company
      this.enableEdit = company.owner_id == this.user.id

      jQuery(this.$el).find('.contents').scrollTop(0);
      this.company = company;
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
      this.$refs['collaborator-search-modal'].show()
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
        this.$refs['collaborator-search-modal'].hide()
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
    },
    closeSelectCollaboratorModal(){
      this.$refs['collaborator-search-modal'].hide()
    },
    closeCollaboratorModal(){
      this.$refs['application-detail-modal'].hide()
    }
  },
}
</script>
<style lang="scss" scoped>
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

