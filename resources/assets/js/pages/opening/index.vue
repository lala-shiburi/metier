<template>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-tile-view">
        <div class="profile-cover" style="height: 300px;">
          <img class="absolute-center" :src="public_path+'/images/register-background.png'">
        </div>
        <div class="row" style="margin-top: -15%;">
          <div class="col-md-10 offset-md-1">
            <opening-card v-if="opening.id" :opening="opening"></opening-card>
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
          <company-card title="Company" :company="opening.company"/>
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
    opening: {}
  }),
  methods: {
    fetch_opening: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: { opening_id: this.opening_id }
        })
      this.opening = data;
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
