<template>
  <div>
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
                <div v-if="programmingLanguages.length == 0 && userTechnologies.length == 0">
                  <label class="text-muted"> What skills do you have? </label>
                </div>
                <div style="margin-bottom: 20px;">
                  <icon-button data-toggle="modal" data-target="#skill-modal">
                    ADD SKILLS
                  </icon-button>
                </div>
                <div v-if="programmingLanguages.length > 0">
                  <label>Programming Languages</label>
                  <br>
                  <skill-icon v-for="(lang,index) in programmingLanguages" v-bind:key="index" :icon="lang.tag_name"></skill-icon>
                </div>
                <div v-if="userTechnologies.length > 0">
                  <label>Frameworks</label>
                  <br>
                  <skill-icon v-for="(tech,index) in userTechnologies" v-bind:key="index" :icon="tech.tag_name"></skill-icon>
                  <!--  -->
                </div>
                
              </div>
            </card>
            <card class="m-tb-10" title="Work Experience">
              <div style="margin-bottom: 20px;">
                <icon-button data-toggle="modal" data-target="#work-experience-modal">
                  ADD WORK EXPERIENCE
                </icon-button>
              </div>
              <info-preview v-for="(experience, index) in workExperiences" icon="company" v-bind:key="index" :title="experience.company_name" :subtitle="experience.position">
                {{experience.length}}
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
    <div class="modal fade" id="skill-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-content">
            <form @submit.prevent="validateSkillsForm" @keydown="skillsForm.onKeydown($event)">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Select your skills</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" style="max-height: 450px; overflow:auto;">
                <skill-selector ref="skillsSelector" :form="skillsForm">
                  <!--  -->
                </skill-selector>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <v-button :loading="skillsForm.busy" type="success">Save</v-button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="work-experience-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="createWorkExperience" @keydown="workExperienceForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Work Experience</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <div style="text-align:center">
                    <div style="width:200px; display:inline-block; background:#d9d9d9;">
                      <div class="photo-preview-container">
                        <div class="scaffold-div">
                          <div class="scaffold-div">
                            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/company.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Company Name</label>
                    <div class="col-md-7">
                      <input v-model="workExperienceForm.company_name" :class="{ 'is-invalid': workExperienceForm.errors.has('company_name') }" class="form-control" name="company_name">
                      <has-error :form="workExperienceForm" field="company_name"/>
                    </div>
                  </div>

                  <!-- Position -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Position</label>
                    <div class="col-md-7">
                      <input v-model="workExperienceForm.position" :class="{ 'is-invalid': workExperienceForm.errors.has('position') }" class="form-control" name="position">
                      <has-error :form="workExperienceForm" field="position"/>
                    </div>
                  </div>

                  <!-- from -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="workExperienceForm.from" :class="{ 'is-invalid': workExperienceForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="workExperienceForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="workExperienceForm.to" :class="{ 'is-invalid': workExperienceForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="workExperienceForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="workExperienceForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
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
    followedCompanies: [],

    // forms
    skillsForm: new Form({
      user_id: this.user_id,
      skills : {
        programming_languages : [],
        technologies: []
      }
    }),
    workExperienceForm: new Form({
      user_id: '',
      company_name: '',
      position: '',
      from: '',
      to: ''
    })
  }),
  methods: {
    async fetch(fetch){
      const { data } = await axios({
          method: 'get',
          url: '/api/userInfo/fetch/'+fetch,
          params: { user_id: this.user_id }
        })
      this[fetch] = data;
    },
    async validateSkillsForm(){
      const {data} = await this.skillsForm.post('/api/userInfo/update/skills');
      this.programmingLanguages = data.programming_languages;
      this.userTechnologies = data.technologies;
      jQuery('#skill-modal').modal('hide');
    },
    async createWorkExperience(){
      const {data} = await this.workExperienceForm.post('/api/userInfo/add/work_experience');
    }
  },
  mounted(){
    var $this = this;
    this.user_id = this.$store.getters['auth/user'].id;
    this.skillsForm.user_id = this.$store.getters['auth/user'].id;
    this.workExperienceForm.user_id = this.$store.getters['auth/user'].id;
    this.fetch('user');
    this.fetch('programmingLanguages');
    this.fetch('userTechnologies');
    this.fetch('workExperiences');
    this.fetch('educationalBackgrounds');
    this.fetch('followedCompanies');
    jQuery('#skill-modal').on('show.bs.modal',function(){
      $this.$refs.skillsSelector.updateProgrammingLanguages($this.programmingLanguages);
      $this.$refs.skillsSelector.updateTechnologies($this.userTechnologies);
    });
    jQuery('#work-experience-modal').on('hide.bs.modal',function(){
      $this.workExperienceForm.reset();
      $this.workExperienceForm.user_id = $this.$store.getters['auth/user'].id;
    });
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
