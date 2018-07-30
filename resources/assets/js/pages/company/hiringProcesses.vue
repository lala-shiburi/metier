<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        Hiring Procedures
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
    <div class="p-10" style="padding: 0px 10px;">
      <ul class="list-inline">
        <li class="list-inline-item">
          <router-link :to="{ name: 'company.hiringprocceses.create', params: { company_id: company_id } }" class="btn btn-primary btn-sm">
            ADD PROCEDURE
          </router-link>
        </li>
      </ul>
    </div>
    <div class="unick-table">
      <div class="header">
        <div class="row item-row">
          <div class="col-md-12 part">
            Hiring Process
          </div>
        </div>
      </div>
      <div class="body">
        <div class="row item-row" :class="recent == process.id ? 'recent':''" v-for="(process,index) in hiringProcesses" v-bind:key="index">
          <div class="col-md-12 p-10 p-r-50 h-d-f-r">
            {{process.name}}
            <div class="d-bttns p-15">
              <i class="fa fa-edit bttn" v-on:click="editHiringProcesses(process)"></i>
              <i class="fa fa-close bttn" v-on:click="prep_delete(process, index)"></i>
            </div>
          </div>
        </div>
        <div class="row item-row" v-if="hiringProcesses.length == 0">
          <div class="col-md-12 p-10 p-r-50 h-d-f-r">
            <center> Nothing to show </center>
          </div>
        </div>
      </div>
    </div>

    <div v-if="false" class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Basic Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" v-if="modalData">
            <opening-card :noApply="true" :opening="modalData.opening"/>
            <div style=" background: #f2f2f2; padding: 15px;">
              <div style="margin-bottom: 15px;" v-if="modalData.expected_salary">
                <b> Expected Salary </b>
                <br>
                <span v-html="modalData.expected_salary"></span>
              </div>
              <div>
                <b> Application Letter </b>
                <br>
                <span v-html="modalData.application_letter"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ProgressStep from './../../components/ProgressStep'
import swal from 'sweetalert2'

import Vue from 'vue'
[
  ProgressStep,
].forEach(Component => {
  Vue.component(Component.name, Component)
})

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
    openings: [],
    hiringProcesses:[],
    recent:null,
  }),
  methods: {
    fetchHiringProcesses: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/hiringprocess/fetch/processes',
          params: { company_id: this.company_id }
        })
      this.hiringProcesses = data.hiringProcesses;
    },
    editHiringProcesses: function(data){
      this.$router.push('/company/'+this.company_id+'/hiringprocceses/create/'+data.id);
    },
    prep_delete(data, index){
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
            url: '/api/company/hiringprocess/delete/process',
            params: { id: data.id }
          }).then( data => {
            if(data.data.status == 'success'){
              $this.hiringProcesses.splice(index, 1);
              $this.$forceUpdate();

              swal(
                'Deleted!',
                'Contact Info successfuly removed.',
                'success'
              )
            }
          });
        }
      });
    }
  },
  created: function(){
    this.company_id = this.$route.params.id;
    this.recent = this.$route.query.newcreated;
  },
  mounted(){
    this.fetchHiringProcesses();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
