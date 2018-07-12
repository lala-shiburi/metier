<template>
  <card class="opening-card">
    <div class="row">
      <div class="col-md-3">
        <div class="photo-preview-container opening-photo">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="opening.picture">
            <div class="company-name">
              <!-- <ellipsis-text>
                  {{opening.company.name}}
              </ellipsis-text> -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <h5>
          <router-link :to="{ name: 'opening.profile', params: { id: opening.id} }">
            {{opening.title}}
          </router-link>
          </h5>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/company.png'" alt="">
          </template>
          <router-link :to="{ name: 'company.profile', params: { id: opening.company.id} }">
            <div class="company-logo">
              <div class="photo-preview-container">
                <div class="scaffold-div">
                  <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                  <img class="absolute-center" :src="opening.company.photo">
                </div>
              </div>
            </div>
            {{opening.company.name}}
          </router-link>
        </ellipsis-text>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/opening-description.png'" alt="">
          </template>
          {{opening.details}}
        </ellipsis-text>
        <ellipsis-text class="job-des" v-if="opening.salary_range">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/salary.png'" alt="">
          </template>
          {{opening.salary_range}}
        </ellipsis-text>
        <ellipsis-text class="job-des" v-if="opening.programming_languages.length > 0 || opening.technologies.length > 0">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/code.png'" alt="">
          </template>
          <span class="skills"> 
            <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
            <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" size="x-small-icon" :icon="tech.tag_name"></skill-icon>
          </span>
        </ellipsis-text>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/calendar.png'" alt="">
          </template>
          {{opening.created_at}}
        </ellipsis-text>
        <div style="margin-top:10px;">
          <v-button>
            Apply
          </v-button>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
export default {
  name: 'OpeningCard',

  props: {
    opening: {
      type: Object,
      required: true
    }
  },
  data : () =>({
    public_path: location.origin
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
