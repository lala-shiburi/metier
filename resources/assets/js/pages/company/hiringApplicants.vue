<template>
  <div class="simple-card">
    <div class="simple-card-header row">
      <div class="col-md-9">
        Hiring Application List
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
    <div class="hiring-progress-table">
      <div class="header">
        <div class="row item-row">
          <div class="col-md-5 part">
            Applicant
          </div>
          <div class="col-md-7 part">
            Progress
          </div>
        </div>
      </div>
      <div class="body">
        <div class="row item-row">
          <div class="col-md-5 part">
            <router-link class="n" :to="{ name: 'opening.profile', params: { id: 0 }}">
              <iconized-photo size="medium-icon" :photo="'http://localhost:8000/storage/photos/1_opening_picture_1531894847.png'"></iconized-photo> Uasdasd
            </router-link>
            : appling for Engineer
          </div>
          <div class="col-md-7 part progress-line-container">
            <progress-step>
              <template slot="steps">
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
              </template>
            </progress-step>
          </div>
        </div>
        <div class="row item-row">
          <div class="col-md-5 part">
            <router-link class="n" :to="{ name: 'opening.profile', params: { id: 0 }}">
              <iconized-photo size="medium-icon" :photo="'http://localhost:8000/storage/photos/1_opening_picture_1531894847.png'"></iconized-photo> Uasdasd
            </router-link>
            : appling for Engineer
          </div>
          <div class="col-md-7 part progress-line-container">
            <progress-step>
              <template slot="steps">
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
                <li class="step">
                  <div class="circle"></div>
                </li>
              </template>
            </progress-step>
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
    company: {},
    openings: [],
  }),
  methods: {
    fetch_company: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch',
          params: { company_id: this.company_id }
        })
      this.company = data.data;
    },
    fetch_openings: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch/openings',
          params: { company_id: this.company_id }
        })
      this.openings = data.openings;
    }
  },
  created: function(){
    this.company_id = this.$route.params.id;
  },
  mounted(){
    this.fetch_company();
    this.fetch_openings();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
