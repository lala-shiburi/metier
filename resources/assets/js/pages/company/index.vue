<template>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-tile-view">
        <cover @update="updateCompany" :company="company" :authorizeEdit="authorizeEdit"/>
        <div class="row">
          <div class="col-lg-2 col-md-3 col-5">
            <logo @update="updateCompany" :company="company" :authorizeEdit="authorizeEdit"/>
          </div>
          <div class="col-lg-5 col-md-5 col-7">
            <h3>{{company.name}}</h3>
            <!-- <label>Software Developer</label> -->
          </div>
          <div class="col-lg-5 col-md-4 col-12">
            <div class="btn-group pull-right" v-if="authorizeEdit">
              <router-link :to="{ name: 'opening.create', params: {company_id:company_id} }" class="btn btn-light">Create Opening</router-link>
              <span class="dvder"/>
              <div class="dropdown">
                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light">...</button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <router-link class="dropdown-item" :to="{ name: 'company.applicants.submitted', params: {id:company_id} }" data-toggle="dropdown">Hiring Applications</router-link>
                  <router-link class="dropdown-item" :to="{ name: 'company.hiringprocceses', params: {id:company_id} }" data-toggle="dropdown">Hiring Procedures</router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <card class="m-tb-10">
        <div>
          <h5>Introduction</h5>
          <div v-html="company.introduction"></div>
          <label class="text-muted" v-if="!company.introduction && authorizeEdit"> How do you describe {{company.name}}? </label>
          <div v-if="!company.introduction && !authorizeEdit" class="text-muted">
              Information not available.
          </div>
          <div v-if="authorizeEdit">
            <icon-button @click.native="prepUpdateIntroduction" v-if="!company.introduction">
              ADD INTRODUCTION
            </icon-button>
            <div v-else style="position: absolute; top: 15px; left: 0px; text-align: right; right: 15px;">
              <i @click="prepUpdateIntroduction" class="small-option-btn fa fa-edit"></i>
            </div>
          </div>
        </div>
        <br>
      </card>
      
      <div class="row">
        <div class="col-md-4">
          <card class="m-b-10" title="Basic Info">
            <div v-if="authorizeEdit" style="position: absolute; top: 10px; left: 0px; text-align: right; right: 15px;">
              <i class="small-option-btn fa fa-edit" v-on:click="prepUpdateBasicInfo" data-toggle="modal" data-target="#user-basic-info-modal"></i>
            </div>
            <ul class="simple-list">
              <li>
                <ellipsis-text label="Email" :title="company.email">
                  {{company.email}}
                </ellipsis-text>
              </li>
              <li>
                <ellipsis-text label="Address" :title="company.address">
                  {{company.address}}
                </ellipsis-text>
              </li>
            </ul>
          </card>
          <card class="m-tb-10" title="Photo">
            <div v-if="authorizeEdit" style="position: absolute; top: 10px; left: 0px; text-align: right; right: 15px;">
              <i class="small-option-btn fa fa-edit" @click="showPhotoUploader"></i>
            </div>
            <photo-viewer :images="company_photos"/>
          </card>
          <card class="m-tb-10" title="Website">
            <div v-if="authorizeEdit" style="position: absolute; top: 10px; left: 0px; text-align: right; right: 15px;">
              <i class="small-option-btn fa fa-edit" v-on:click="prepUpdateWebsiteInfo" data-toggle="modal" data-target="#user-basic-info-modal"></i>
            </div>
            <ul class="simple-list">
              <li>
                <ellipsis-text>
                  <a :href="'http://'+company.website_url" target="blank">{{company.website_url}}</a>
                </ellipsis-text>
              </li>
            </ul>
          </card>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6" v-for="(opening,index) in openings" v-bind:key="index">
              <opening-card @delete="removeOpening" :opening="opening"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    <basic-info-modal ref="basic-info-modal" @update="updateCompany" :company="company"/>
    <website-info-modal ref="website-info-modal" @update="updateCompany" :company="company"/>
    <introduction-modal  v-if="authorizeEdit" :company="company" ref="introduction-modal"/>
    <photo-uploader v-if="authorizeEdit" ref="photo-uploader" @update="updatePhotoGallery"/>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import Logo from './logo'
import Cover from './cover'
import IntroductionModal from './index-components/introduction-modal'
import BasicInfoModal from './index-components/basic-info-modal'
import WebsiteInfoModal from './index-components/website-info-modal'
import PhotoViewer from '~/components/PhotoViewer'
import PhotoUploader from './photo-management/index'

export default {
  components: {
    BasicInfoModal,
    WebsiteInfoModal,
    Logo,
    Cover,
    IntroductionModal,
    BasicInfoModal,
    PhotoViewer,
    PhotoUploader
  },
  data : () =>({
    public_path: location.origin,
    company_id: null,
    company: {},
    openings: [],
    authorizeEdit: false,
    company_photos: [],
  }),
  metaInfo () {
    return { title: this.company.name || 'Company' }
  },
  methods: {
    showPhotoUploader(){
      this.$refs['photo-uploader'].show()
    },
    fetch_company: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch',
          params: { company_id: this.company_id }
        })
      this.company = data.data;
      this.authorizeEdit = data.meta.edit_allowed;
    },
    updateCompany(data){
      this.company = data;
    },
    fetch_openings: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch/openings',
          params: { company_id: this.company_id }
        })
      this.openings = data.openings;
    },
    prepUpdateBasicInfo(){
      this.$refs['basic-info-modal'].prepUpdate();
    },
    prepUpdateWebsiteInfo(){
      this.$refs['website-info-modal'].prepUpdate(this.company);
    },
    removeOpening(data){
      for(var i = 0; i < this.openings.length; i++){
        if(this.openings[i].id == data.id){
          this.openings.splice(i, 1);
        }
      }

    },
    prepUpdateIntroduction(){
      this.$refs["introduction-modal"].prepUpdate()
    },
    updatePhotoGallery(){
      this.fetchCompanyPhotos()
    },
    async fetchCompanyPhotos(){
      const { data } = await axios({
        url: '/api/photo/fetch/company',
        method: 'get',
        params: {company_id: this.$route.params.id}
      })
      this.company_photos = data.photos
    }
  },
  created: function(){
    this.company_id = this.$route.params.id;
  },
  mounted(){
    this.fetch_company()
    this.fetch_openings()
    this.fetchCompanyPhotos()
  }
}
</script>