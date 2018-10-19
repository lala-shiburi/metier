<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="profile-tile-view">
          <div class="profile-cover">
            <img class="absolute-center" :src="user.cover_photo" v-on:click="prepUpdateCover">
          </div>
          <div class="row">
            <div class="col-lg-2 col-md-3 col-5">
              <div class="profile-photo">
                <div class="scaffold-div">
                  <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                  <img class="absolute-center" v-on:click="prepUpdatePhoto" :src="user.photo">
                </div>
              </div>
            </div>
            <div class="col-lg-10 col-md-9 col-7">
              <h3>{{user.name}}</h3>
              <label>{{workExperiences.length > 0 ? (workExperiences[0].is_current == 1 ? workExperiences[0].position : '' ) :''}}</label>
            </div>
          </div>
        </div>
        <card class="m-tb-10">
          <div>
            <h5>Description</h5>
            <label class="text-muted" v-if="!user.description && authorizeEdit"> How do you describe yourself? </label>
            <div v-if="!user.description && !authorizeEdit" class="text-muted">
                Information not available.
            </div>
            {{user.description}}
            <div v-if="authorizeEdit">
              <icon-button v-if="!user.description"  data-toggle="modal" data-target="#description-modal">
                ADD DESCRIPTION
              </icon-button>
              <div v-else style="position: absolute; top: 15px; left: 0px; text-align: right; right: 15px;">
                <i class="small-option-btn fa fa-edit" data-toggle="modal" data-target="#description-modal"></i>
              </div>
            </div>
          </div>
          <br>
        </card>
        
        <div class="row">
          <div class="col-md-4">
            <card class="m-tb-10" title="Basic Info">
              <div v-if="authorizeEdit" style="position: absolute; top: 10px; left: 0px; text-align: right; right: 15px;">
                <i class="small-option-btn fa fa-edit" v-on:click="prepUpdateBasicInfo"></i>
              </div>
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
              <div v-if="!user.resume_file" class="text-muted">
                Information not available.
              </div>
              <br>
              <button v-if="authorizeEdit" style="margin:5px;" href="#" class="btn btn-primary" v-on:click="openFileInput">
                <i class="fa fa-upload" aria-hidden="true"></i> {{user.resume_file ? 'change' : 'Upload'}}
              </button>
              <a :href="user.resume_file" style="margin:5px;" class="btn btn-success" v-if="user.resume_file">
                <i class="fa fa-download" aria-hidden="true"></i>
              </a>
              <input type="file" ref="resume-file-input" @change="uploadResumeFile($event.target.files)" style="display:none;">
            </card>
            <card class="m-tb-10" title="Address">
              <div v-if="userAddresses.length == 0" class="text-muted">
                  Information not available.
              </div>
              <ul class="simple-list">
                <li v-for="(address,index) in userAddresses" v-bind:key="index">
                  <ellipsis-text>
                    {{ address.address_text }}
                  </ellipsis-text>
                  <div class="options" v-if="authorizeEdit">
                    <i class="option fa fa-edit" v-on:click="prepUpdateAddress(address)"></i>
                    <i class="option fa fa-close" v-on:click="prepDeleteAddress(address, index)"></i>
                  </div>
                </li>
              </ul>
              <icon-button v-if="authorizeEdit" v-on:click.native="prepAddAddress(user.id)">
                ADD ADDRESS
              </icon-button>
            </card>
            <card class="m-tb-10" title="Contact Number">
              <div v-if="userContactNumbers.length == 0" class="text-muted">
                  Information not available.
              </div>
              <ul class="simple-list">
                <li v-for="(number,index) in userContactNumbers" v-bind:key="index">
                  <ellipsis-text>
                    {{ number.number }}
                  </ellipsis-text>
                  <div class="options" v-if="authorizeEdit">
                    <i class="option fa fa-edit" v-on:click="prepUpdateContact(number)"></i>
                    <i class="option fa fa-close" v-on:click="prepDeleteContactInfo(number, index)"></i>
                  </div>
                </li>
              </ul>
              <icon-button v-if="authorizeEdit" v-on:click.native="prepAddContactInfo(user.id)">
                ADD NUMBER
              </icon-button>
            </card>
          </div>
          <div class="col-md-8">
            <card class="m-tb-10" title="Skills">
              <div>
                <div v-if="programmingLanguages.length == 0 && userTechnologies.length == 0 && authorizeEdit">
                  <label class="text-muted"> What skills do you have? </label>
                </div>
                <div v-if="programmingLanguages.length == 0 && userTechnologies.length == 0 && !authorizeEdit" class="text-muted">
                  Information not available.
                </div>
                <div v-if="authorizeEdit" style="margin-bottom: 20px;">
                  <icon-button v-on:click.native="prepUpdateSkills">
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
              <div v-if="workExperiences.length == 0" class="text-muted">
                Information not available.
                <br>
                <br>
              </div>
              <div style="margin-bottom: 20px;">
                <icon-button v-if="authorizeEdit" @click.native="prepCreateWorkexperience">
                  ADD WORK EXPERIENCE
                </icon-button>
              </div>
              <info-preview v-for="(experience, index) in workExperiences" icon="company" v-bind:key="index" :title="experience.company_name" :subtitle="experience.position">
                {{experience.length}}
                <template slot="options" v-if="authorizeEdit">
                  <i class="option-btn fa fa-edit" v-on:click="prepEditWorkExperience(experience)"></i>
                  <i class="option-btn fa fa-close" v-on:click="prepDeleteWorkExperience(experience, index)"></i>
                </template>
              </info-preview>
            </card>
            <card class="m-tb-10" title="Educational Background">
              <div v-if="educationalBackgrounds.length == 0" class="text-muted">
                Information not available.
                <br>
                <br>
              </div>
              <div style="margin-bottom: 20px;">
                <icon-button v-if="authorizeEdit" @click.native="prepCreateEducationalBackground">
                  ADD EDUCATIONAL BACKGROUND
                </icon-button>
              </div>
              <info-preview v-for="(education, index) in educationalBackgrounds" v-bind:key="index" icon="school" :title="education.school_name" :subtitle="education.course">
                {{education.from.split('-')[0]}} - {{education.to.split('-')[0]}}
                <template slot="options" v-if="authorizeEdit">
                  <i class="option-btn fa fa-edit" v-on:click="prepEditEducationalBackground(education)"></i>
                  <i class="option-btn fa fa-close" v-on:click="prepDeleteEducationalBackground(education, index)"></i>
                </template>
              </info-preview>
            </card>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="description-modal" tabindex="-1" role="dialog">
      <div  v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="updateDescription" @keydown="userDescriptionForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">About yourself</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Description</label>
                    <div class="col-md-7">
                      <textarea v-model="userDescriptionForm.description" :class="{ 'is-invalid': userDescriptionForm.errors.has('description') }" class="form-control" name="description" rows="10">
                      </textarea>
                      <has-error :form="userDescriptionForm" field="description"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="userDescriptionForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <user-basic-info-modal v-if="authorizeEdit" ref="user-basic-info-modal" @update="updateUser" :user="user"/>
    <user-address-info-modal v-if="authorizeEdit" ref="userAddInfoModal" @update="updateAddresses" :user="userAddresses"/>
    <user-contact-info-modal v-if="authorizeEdit" ref="userContactInfoModal" @update="updateContactInfos" :user="userAddresses"/>
    <work-experience-modal v-if="authorizeEdit" ref="work-experience-modal" @update="updateWorkExperience"/>
    <educational-background-modal v-if="authorizeEdit" ref="educational-background-modal" @update="updateEducationalBackground"/>
    <vue-photo-editor title="Profile Photo" ref="photo-editor" @update="updateUserPhoto"/>
    <skills-modal @update="updateSkills" ref="skills-modal"/>
    <profile-picture-modal ref="profile-picture-modal" @update="updateUserPhoto"/>
    <cover-picture-modal ref="cover-modal" @update="updateCover"/>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import swal from 'sweetalert2'
import Form from 'vform'
import { mapGetters } from 'vuex'
import vuePhotoEditor from 'unick-vue-photo-editor';
import userBasicInfoModal from './index-components/basicInfoModal'
import userAddressInfoModal from './index-components/addressInfoModal'
import userContactInfoModal from './index-components/contactInfoModal'
import workExperienceModal from './index-components/workExperience'
import educationalBackgroundModal from './index-components/educationalBackground'
import SkillsModal from './index-components/skillsModal'
import ProfilePictureModal from '~/components/photo-editors/profilePictureModal'
import CoverPictureModal from '~/components/photo-editors/coverPictureModal'

export default {
  middleware: 'auth',
  metaInfo () {
    return { title: this.user.name || 'User' }
  },
  components:{
    userBasicInfoModal,
    userAddressInfoModal,
    userContactInfoModal,
    vuePhotoEditor,
    workExperienceModal,
    educationalBackgroundModal,
    SkillsModal,
    ProfilePictureModal,
    CoverPictureModal
  },
  data : () =>({
    public_path: location.origin,
    programmingLanguages:[],
    userTechnologies: [],
    workExperiences: [],
    educationalBackgrounds: [],
    followedCompanies: [],
    userAddresses: [],
    userContactNumbers: [],
    user: {},

    // forms
    skillsForm: new Form({
      user_id: this.user_id,
      skills : {
        programming_languages : [],
        technologies: []
      }
    }),
    userDescriptionForm: new Form({
      user_id: '',
      description: ''
    }),
    authorizeEdit: false
  }),
  methods: {
    async updateUserPhoto(photo_data){
      var form = new Form({
        photo_data: photo_data
      });

      const {data} = await form.patch('/api/userInfo/update/photo');
      await this.$store.dispatch('auth/fetchUser')
      this.user = data;
    },
    async updateCover(canvasDataURL){
      var form = new Form({
        photo_data: canvasDataURL
      });

      const {data} = await form.patch('/api/userInfo/update/cover');
      this.$emit('update',data);
      this.user.cover_photo = data.cover_photo
    },
    async fetch(fetch){
      axios({
          method: 'get',
          url: '/api/userInfo/fetch/'+fetch,
          params: { user_id: this.user_id }
        }).then( data => {
          this[fetch] = data.data;
        });
    },
    prepUpdatePhoto(){
      if(this.authorizeEdit){
        this.$refs['profile-picture-modal'].prepUpdate(this.user.photo)
      }
    },
    prepUpdateCover(){
      if(this.authorizeEdit){
        this.$refs['cover-modal'].prepUpdate(this.user.cover_photo)
      }
    },
    updateSkills(data){
      this.programmingLanguages = data.programmingLanguages
      this.userTechnologies = data.userTechnologies
    },
    async updateDescription(){
      const {data} = await this.userDescriptionForm.post('/api/userInfo/update/user_description');

      await this.$store.dispatch('auth/fetchUser')
      this.userDescriptionForm.description = this.description;
      this.user = data.user;
      jQuery('#description-modal').modal('hide');
    },
    updateUser(data){
      this.user = data;
    },
    prepUpdateBasicInfo(){
      this.$refs['user-basic-info-modal'].prepUpdate(this.user);
    },
    prepUpdateSkills(){
      this.$refs['skills-modal'].prepUpdate()
    },

    // work experience methods
    updateWorkExperience(data){
      this.workExperiences = data;
    },
    prepEditWorkExperience(data){
      this.$refs["work-experience-modal"].prepUpdate(data);
    },
    prepCreateWorkexperience(){
      this.$refs["work-experience-modal"].prepCreate();
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
    
    // educational background modal
    prepEditEducationalBackground(data){
      this.$refs["educational-background-modal"].prepUpdate(data);
    },
    prepCreateEducationalBackground(){
      this.$refs["educational-background-modal"].prepCreate();
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
    },
    updateEducationalBackground(data){
      this.educationalBackgrounds = data;
    },
    
    prepUpdateAddress(data){
      this.$refs.userAddInfoModal.prepUpdate(data);
    },
    prepAddAddress(user_id){
      this.$refs.userAddInfoModal.prepCreate(user_id);
    },
    updateAddresses(data){
      this.userAddresses = data;
    },
    prepAddContactInfo(user_id){
      this.$refs.userContactInfoModal.prepCreate(user_id);
    },
    prepUpdateContact(data){
      this.$refs.userContactInfoModal.prepUpdate(data);
    },
    updateContactInfos(data){
      this.userContactNumbers = data;
    },
    prepDeleteContactInfo(data, index){
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
            url: '/api/userInfo/delete/contact_number',
            params: { address_id: data.id }
          }).then( data => {
            if(data.data == 'deleted'){
              var contact_numbers = $this.userContactNumbers;
              contact_numbers.splice(index, 1);
              $this.userContactNumbers = contact_numbers;

              swal(
                'Deleted!',
                'Contact Info successfuly removed.',
                'success'
              )
            }
          });
        }
      });
    },
    prepDeleteAddress(data, index){
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
            url: '/api/userInfo/delete/address',
            params: { address_id: data.id }
          }).then( data => {
            if(data.data == 'deleted'){
              var addresses = $this.userAddresses;
              addresses.splice(index, 1);
              $this.userAddresses = addresses;

              swal(
                'Deleted!',
                'Address successfuly removed.',
                'success'
              )
            }
          });
        }
      });
    },
    openFileInput(){
      this.$refs['resume-file-input'].click();
    },
    uploadResumeFile(files){
      var ext = files[0].name.split('.')[1];
      var $this = this;
      if(ext=="pdf" || ext=="docx" || ext=="doc"){
          swal({
          title: 'Please confirm',
          type: 'info',
          html:
              'Click save',
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          confirmButtonText:
              'Save',
          cancelButtonText:
          'Cancel',
          }).then(function(result){
            if(result.value){
              swal({
                  title: 'Saving',
                  text: 'Please wait...',
                  onOpen: () => {
                      swal.showLoading()
                  },
                  allowOutsideClick: () => !swal.isLoading()
              });

              var formData = new FormData();
              formData.append('resume_file',files[0],files[0].name);
              formData.append('user_id',$this.user.id);
              axios({
                method: 'post',
                url: '/api/userInfo/add/resume_file',
                data: formData
              }).then( data => {
                console.log(data.data);
                $this.user = data.data.user
                if(data.data.status == 'created'){
                  swal(
                    'Uploaded!',
                    'Resume file uploaded.',
                    'success'
                  )
                }
              });
            }
          })
      }
      else
      {
          swal({
              type: 'error',
              title: 'Oops...',
              text: 'Please choose .pdf, .doc, or .docx files!',
          })
      }
    },
    loadEveryThing(){
      var $this = this;
      this.user_id = this.$route.params.id ? this.$route.params.id : this.$store.getters['auth/user'].id;
      this.skillsForm.user_id = this.$store.getters['auth/user'].id;
      this.userDescriptionForm.user_id = this.$store.getters['auth/user'].id;
      this.userDescriptionForm.description = this.$store.getters['auth/user'].description;
      this.fetch('user');
      this.fetch('workExperiences');
      this.fetch('userAddresses');
      this.fetch('educationalBackgrounds');
      this.fetch('followedCompanies');
      this.fetch('userContactNumbers');
    },
    validateAuth(){
      this.authorizeEdit = this.user.id == this.$store.getters['auth/user'].id
    }
  },
  mounted(){
    var $this = this;
    this.loadEveryThing();
  },
  watch: {
    $route(){
      this.loadEveryThing();
    },
    user(){
      this.validateAuth()
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
