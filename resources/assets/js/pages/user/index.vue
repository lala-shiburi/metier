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
              <label>{{workExperiences.length > 0 ? (workExperiences[0].is_current == 1 ? workExperiences[0].position : '' ) :''}}</label>
            </div>
          </div>
        </div>
        <card class="m-tb-10">
          <div>
            <h5>Description</h5>
            <label class="text-muted"> How do you describe yourself? </label>
            <br>
            <icon-button v-if="!user.description">
              ADD DESCRIPTION
            </icon-button>
            <div v-else style="position: absolute; top: 15px; left: 0px; text-align: right; right: 15px;">
              <i class="small-option-btn fa fa-edit"></i>
            </div>
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
                <template slot="options">
                  <i class="option-btn fa fa-edit" v-on:click="prepEditWorkExperience(experience, index)"></i>
                  <i class="option-btn fa fa-close" v-on:click="prepDeleteWorkExperience(experience, index)"></i>
                </template>
              </info-preview> 
            </card>
            <card class="m-tb-10" title="Educational Background">
              <div style="margin-bottom: 20px;">
                <icon-button data-toggle="modal" data-target="#educational-background-modal">
                  Add Education Background
                </icon-button>
              </div>
              <info-preview v-for="(education, index) in educationalBackgrounds" v-bind:key="index" icon="school" :title="education.school_name" :subtitle="education.course">
                {{education.from.split('-')[0]}} - {{education.to.split('-')[0]}}
                <template slot="options">
                  <i class="option-btn fa fa-edit"></i>
                  <i class="option-btn fa fa-close" v-on:click="prepDeleteEducationalBackground(education, index)"></i>
                </template>
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

                  <!-- current job -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Status</label>
                    <div class="col-md-7">
                      <div class="btn-group btn-group-toggle">
                        <label class="btn btn-secondary" :class="workExperienceForm.current == 0 ? 'active': ''">
                          <input type="radio" name="current" value="0" v-model="workExperienceForm.current" id="option2"> Previews Job
                        </label>
                        <label class="btn btn-secondary" :class="workExperienceForm.current == 1 ? 'active': ''">
                          <input type="radio" name="current" value="1" v-model="workExperienceForm.current" id="option1" checked> Present Job
                        </label>
                      </div>
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
                  <div class="form-group row" v-if="workExperienceForm.current == 0">
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
    <div class="modal fade" id="educational-background-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="createEducationalBackground" @keydown="educationalBackgroundForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Educational Background</h5>
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
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/school.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">School Name</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_name" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_name') }" class="form-control" name="school_name">
                      <has-error :form="educationalBackgroundForm" field="school_name"/>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Address</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_address" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_address') }" class="form-control" name="school_address">
                      <has-error :form="educationalBackgroundForm" field="school_address"/>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_email" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_email') }" class="form-control" name="school_email">
                      <has-error :form="educationalBackgroundForm" field="school_email"/>
                    </div>
                  </div>

                  <!-- Number -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Contact Number</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_number" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_number') }" class="form-control" name="school_number">
                      <has-error :form="educationalBackgroundForm" field="school_number"/>
                    </div>
                  </div>

                  <!-- Course -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Course</label>
                    <div class="col-md-7">
                      <input type="text" v-model="educationalBackgroundForm.course" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('course') }" class="form-control" name="course">
                      <has-error :form="educationalBackgroundForm" field="course"/>
                    </div>
                  </div>

                  <!-- From -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="educationalBackgroundForm.from" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="educationalBackgroundForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="educationalBackgroundForm.to" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="educationalBackgroundForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="educationalBackgroundForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-work-experience-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="createWorkExperience" @keydown="editWorkExperienceForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Work Experience</h5>
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
                      <input v-model="editWorkExperienceForm.company_name" :class="{ 'is-invalid': editWorkExperienceForm.errors.has('company_name') }" class="form-control" name="company_name">
                      <has-error :form="editWorkExperienceForm" field="company_name"/>
                    </div>
                  </div>

                  <!-- Position -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Position</label>
                    <div class="col-md-7">
                      <input v-model="editWorkExperienceForm.position" :class="{ 'is-invalid': editWorkExperienceForm.errors.has('position') }" class="form-control" name="position">
                      <has-error :form="editWorkExperienceForm" field="position"/>
                    </div>
                  </div>

                  <!-- current job -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Status</label>
                    <div class="col-md-7">
                      <div class="btn-group btn-group-toggle">
                        <label class="btn btn-secondary" :class="editWorkExperienceForm.current == 0 ? 'active': ''">
                          <input type="radio" name="current" value="0" v-model="editWorkExperienceForm.current" id="option2"> Previews Job
                        </label>
                        <label class="btn btn-secondary" :class="editWorkExperienceForm.current == 1 ? 'active': ''">
                          <input type="radio" name="current" value="1" v-model="editWorkExperienceForm.current" id="option1" checked> Present Job
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- from -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="editWorkExperienceForm.from" :class="{ 'is-invalid': editWorkExperienceForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="editWorkExperienceForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row" v-if="editWorkExperienceForm.current == 0">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="editWorkExperienceForm.to" :class="{ 'is-invalid': editWorkExperienceForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="editWorkExperienceForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="editWorkExperienceForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="edit-educational-background-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="createEducationalBackground" @keydown="educationalBackgroundForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Educational Background</h5>
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
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/school.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">School Name</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_name" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_name') }" class="form-control" name="school_name">
                      <has-error :form="educationalBackgroundForm" field="school_name"/>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Address</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_address" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_address') }" class="form-control" name="school_address">
                      <has-error :form="educationalBackgroundForm" field="school_address"/>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_email" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_email') }" class="form-control" name="school_email">
                      <has-error :form="educationalBackgroundForm" field="school_email"/>
                    </div>
                  </div>

                  <!-- Number -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Contact Number</label>
                    <div class="col-md-7">
                      <input v-model="educationalBackgroundForm.school_number" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('school_number') }" class="form-control" name="school_number">
                      <has-error :form="educationalBackgroundForm" field="school_number"/>
                    </div>
                  </div>

                  <!-- Course -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Course</label>
                    <div class="col-md-7">
                      <input type="text" v-model="educationalBackgroundForm.course" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('course') }" class="form-control" name="course">
                      <has-error :form="educationalBackgroundForm" field="course"/>
                    </div>
                  </div>

                  <!-- From -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="educationalBackgroundForm.from" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="educationalBackgroundForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="educationalBackgroundForm.to" :class="{ 'is-invalid': educationalBackgroundForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="educationalBackgroundForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="educationalBackgroundForm.busy" type="success">Save</v-button>
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
import swal from 'sweetalert2'
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
      to: '',
      current:0
    }),
    educationalBackgroundForm: new Form({
      user_id: '',
      school_name: '',
      school_address: '',
      school_email: '',
      school_number: '',
      course: '',
      from: '',
      to: '',
    }),
    editWorkExperienceForm: new Form({
      id: 0,
      user_id: '',
      company_name: '',
      position: '',
      from: '',
      to: '',
      current:0
    }),
    editEducationalBackgroundForm: new Form({
      id: 0,
      user_id: '',
      school_name: '',
      school_address: '',
      school_email: '',
      school_number: '',
      course: '',
      from: '',
      to: '',
    })
  }),
  methods: {
    async fetch(fetch){
      axios({
          method: 'get',
          url: '/api/userInfo/fetch/'+fetch,
          params: { user_id: this.user_id }
        }).then( data => {
          this[fetch] = data.data;
        });
    },
    async validateSkillsForm(){
      const {data} = await this.skillsForm.post('/api/userInfo/update/skills');
      this.programmingLanguages = data.programming_languages;
      this.userTechnologies = data.technologies;
      jQuery('#skill-modal').modal('hide');
    },
    async createWorkExperience(){
      const {data} = await this.workExperienceForm.post('/api/userInfo/add/work_experience');
      this.workExperiences = data.workExperiences;
      jQuery('#work-experience-modal').modal('hide');
    },
    async createEducationalBackground(){
      const {data} = await this.educationalBackgroundForm.post('/api/userInfo/add/education_background');

      this.educationalBackgrounds = data.educationalBackgrounds;
      jQuery('#educational-background-modal').modal('hide');
    },
    prepEditWorkExperience(data){
      this.editWorkExperienceForm.id = data.id;
      this.editWorkExperienceForm.user_id = this.$store.getters['auth/user'].id;
      this.editWorkExperienceForm.company_name = data.company_name;
      this.editWorkExperienceForm.position = data.position;
      this.editWorkExperienceForm.from = data.from;
      this.editWorkExperienceForm.current = data.is_current;
      this.editWorkExperienceForm.to = data.to;
      jQuery('#edit-work-experience-modal').modal('show');
    },
    prepDeleteWorkExperience(data,index){
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
            url: '/api/userInfo/delete/work_experience',
            params: { work_experience_id: data.id }
          }).then( data => {
            if(data.data == 'deleted'){
              var work_experience = $this.workExperiences;
              work_experience.splice(index, 1);
              $this.workExperiences = work_experience;

              swal(
                'Deleted!',
                'Work Experience successfuly removed.',
                'success'
              )
            }
          });
        }
      });
    },
    prepDeleteEducationalBackground(data,index){
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
            url: '/api/userInfo/delete/education_background',
            params: { education_background_id: data.id }
          }).then( data => {
            if(data.data == 'deleted'){
              var education_background = $this.educationalBackgrounds;
              education_background.splice(index, 1);
              $this.educationalBackgrounds = education_background;

              swal(
                'Deleted!',
                'Work Experience successfuly removed.',
                'success'
              )
            }
          });
        }
      });
    }
  },
  mounted(){
    var $this = this;
    this.user_id = this.$store.getters['auth/user'].id;
    this.skillsForm.user_id = this.$store.getters['auth/user'].id;
    this.workExperienceForm.user_id = this.$store.getters['auth/user'].id;
    this.educationalBackgroundForm.user_id = this.$store.getters['auth/user'].id;
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
    jQuery('#educational-background-modal').on('hide.bs.modal',function(){
      $this.educationalBackgroundForm.reset();
      $this.educationalBackgroundForm.user_id = $this.$store.getters['auth/user'].id;
    });
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
