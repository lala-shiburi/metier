<template>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-tile-view">
        <div class="profile-cover">
          <img class="absolute-center" :src="user.cover_photo">
        </div>
        <div class="row">
          <div class="col-lg-2 col-5">
            <div class="profile-photo">
              <div class="scaffold-div">
                <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                <img class="absolute-center" :src="user.photo">
              </div>
            </div>
          </div>
          <div class="col-lg-10 col-7">
            <h3>{{user.name}}</h3>
            <label>Software Developer</label>
          </div>
        </div>
      </div>
      <card class="m-tb-10">
        <div>
          <h5>Description</h5>
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </div>
        <br>
      </card>
      
      <div class="row">
        <div class="col-md-4">
          <card class="m-tb-10" title="Basic Info">
            <ul class="simple-list">
              <li>
                <ellipsis-text label="Email">
                  {{user.email}}
                </ellipsis-text>
              </li>
              <li>
                <ellipsis-text label="Birth Date">
                  {{user.birth_date}}
                </ellipsis-text>
              </li>
              <li>
                <ellipsis-text label="Gender">
                  {{user.gender}}
                </ellipsis-text>
              </li>
            </ul>
          </card>
          <card class="m-tb-10" title="Resume File">
            <a href="#" class="btn btn-primary">
              Download
            </a>
          </card>
          <card class="m-tb-10" title="Address">
            <ul class="simple-list">
              <li>
                <ellipsis-text>
                  Shokay Lapu-Lapu City Cebu
                </ellipsis-text>
              </li>
            </ul>
          </card>
          <card class="m-tb-10" title="Contact Number">
            <ul class="simple-list">
              <li>
                <ellipsis-text>
                  09678687823
                </ellipsis-text>
              </li>
            </ul>
          </card>
        </div>
        <div class="col-md-8">
          <card class="m-tb-10" title="Skills">
            <div>
              <label>Programming Languages</label>
              <br>
              <div v-if="opening.programming_languages.length == 0 && opening.technologies.length == 0">
                <label class="text-muted"> What skills do you have? </label>
              </div>
              <div v-if="opening.programming_languages.length > 0">
                <label>Programming Languages</label>
                <br>
                <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" :icon="lang.tag_name"></skill-icon>
              </div>
              <div v-if="opening.technologies.length > 0">
                <label>Frameworks</label>
                <br>
                <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" :icon="tech.tag_name"></skill-icon>
                <!--  -->
              </div>
              
            </div>
            <div>
              <label>Frameworks</label>
              <br>
              <skill-icon icon="angular"></skill-icon>
            </div>
          </card>
          <card class="m-tb-10" title="Work Experience">
            <info-preview icon="company" title="Nexseed Inc." subtitle="Engineer">
              8 months
            </info-preview>
          </card>
          <card class="m-tb-10" title="Educational Background">
            <info-preview icon="school" title="DMCCFI Inc." subtitle="Bachelor of Science in Information Technology">
              Major in Web Development
            </info-preview>
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
    user: {},
    programmingLanguages:[],
    userTechnologies: [],
    workExperiences: [],
    educationalBackgrounds: [],
    followedCompanies: []
  }),
  methods: {
    async fetch(fetch){
      const { data } = await axios({
          method: 'get',
          url: '/api/userInfo/'+fetch,
          params: { user_id: this.user_id }
        })
      this[fetch] = data;
    }
  },
  mounted(){
    this.user_id = this.$store.getters['auth/user'].id;
    this.fetch('user');
    this.fetch('programmingLanguages');
    this.fetch('userTechnologies');
    this.fetch('workExperiences');
    this.fetch('educationalBackgrounds');
    this.fetch('followedCompanies');
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
