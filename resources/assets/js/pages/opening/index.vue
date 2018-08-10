<template>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-tile-view">
        <div class="profile-cover" style="height: 300px;">
          <img class="absolute-center" :src="public_path+'/images/opening-background.jpg'">
        </div>
        <div class="row" style="margin-top: -15%;">
          <div class="col-md-6 offset-md-3">
            <opening-card v-if="opening.id" :opening="opening" :noApply="true">
              <div style="margin-top: 10px;">
                <router-link class="btn btn-primary" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
                  Apply
                </router-link>
                <router-link v-if="authorizeEdit" class="btn btn-success" :to="{ name: 'opening.edit', params: { id: opening.id} }">
                  Edit  
                </router-link>
              </div>
            </opening-card>
          </div>
        </div>
      </div>
      <card class="m-tb-10">
        <div>
          <h5>Description</h5>
          {{opening.details}}
        </div>
        <br>
      </card>
      
      <div class="row">
        <div class="col-md-4">
          <card class="opening-card" title="Company">
            <div class="row">
              <div class="col-md-4">
                <div class="photo-preview-container opening-photo">
                  <div class="scaffold-div">
                    <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                    <img class="absolute-center" :src="opening.company.photo">
                    <div class="company-name">
                      <!-- <ellipsis-text>
                          {{opening.company.name}}
                      </ellipsis-text> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <h5>
                  <router-link :to="{ name: 'company.profile', params: { id: opening.company.id} }">
                    {{opening.company.name}}
                  </router-link>
                  </h5>
                <ellipsis-text class="job-des" v-if="opening.company.employee_count">
                  <template slot="icon">
                    <img class="job-des-icon" :src="public_path+'/images/employees.png'" alt="">
                  </template>
                  {{opening.company.employee_count}}
                </ellipsis-text>
                <ellipsis-text class="job-des">
                  <template slot="icon">
                    <img class="job-des-icon" :src="public_path+'/images/location.png'" alt="">
                  </template>
                  {{opening.company.address}}
                </ellipsis-text>
              </div>
            </div>
          </card>
        </div>
        <div class="col-md-8">
          <card title="Skills Requirements">
            <div v-if="opening.programming_languages.length > 0">
              <label>Programming Languages</label>
              <br>
              <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" :icon="lang.tag_name"></skill-icon>
            </div>
            <div v-if="opening.technologies.length > 0">
              <label>Frameworks</label>
              <br>
              <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" :icon="tech.tag_name"></skill-icon>
            </div>
            <div v-if="opening.programming_languages.length == 0 && opening.technologies.length == 0">
              <label> No Skill Requirements </label>
            </div>
          </card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',

  data : () =>({
    public_path: location.origin,
    opening_id: null,
    opening: {},
    authorizeEdit: false
  }),
  methods: {
    fetch_opening: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: { opening_id: this.opening_id }
        })
      this.opening = data.data;
      this.authorizeEdit = data.meta.authorizeEdit;
    }
  },
  created: function(){
    this.opening_id = this.$route.params.id;
  },
  mounted(){
    this.fetch_opening();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
