<template>
  <sidebar-popup ref="application-detail-modal">
    <div v-if="application" class="header-part">
      <entity-header>
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
      <div class="panel results-container">
        <div class="container-body">
          <div class="card mb-3" v-for="(result, index) in hiring_step_results" v-bind:key="index">
            <div class="card-header">
              {{result.hiring_step.name}}
            </div>
            <div class="card-body">
              <h5 class="card-title text-center">Result is {{result.result}} out of 10.</h5>
              <blockquote class="blockquote mb-0" v-for="(note, index) in result.notes" v-bind:key="index">
                <p>{{note.note}}</p>
                <footer class="blockquote-footer">{{note.title}}</footer>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </div>
  </sidebar-popup>
</template>

<script>

import SidebarPopup from './../../../components/SidebarPopup'
import Form from 'vform'
import axios from 'axios'
import ApplicationProgressLine from './../../../components/hiring/application-progress-line'
import swal from 'sweetalert2'
export default {
  name: 'ApplicationResults',
  components: {
    SidebarPopup,
    ApplicationProgressLine
  },
  data: () => ({
    application: null,
    hiring_step_results:[],
    panelManager:null
  }),
  mounted () {
    // 
    this.panelManager = new panelManager(this.$refs['panels-container']);
  },
  methods: {
    showApplicationResults(data){
      this.panelManager.hideAll();
      this.application = data;
      this.$refs['application-detail-modal'].show();
      this.rerenderProgressLine();
      this.fetchResults();
    },
    async fetchResults(){
      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/results',
        params: { application_id : this.application.id },
      })
      
      this.hiring_step_results = data.results;
      this.panelManager.showPanel('.results-container')
    },
    rerenderProgressLine(){
      var $this = this;
      Vue.nextTick(function () {
        $this.$refs['progress-component'].fetchApplication();
      })
    },
    close(){
      this.$refs['application-detail-modal'].hide();
    },
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

