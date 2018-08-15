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
                <div class="scaffold-div" v-on:click="showPhotoEditor">
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
            <label class="text-muted" v-if="!user.description && authorizeEdit"> How do you describe yourself? </label>
            <div v-if="userAddresses.length == 0 && !authorizeEdit" class="text-muted">
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
              <div v-if="workExperiences.length == 0" class="text-muted">
                Information not available.
                <br>
                <br>
              </div>
              <div style="margin-bottom: 20px;">
                <icon-button v-if="authorizeEdit" data-toggle="modal" data-target="#work-experience-modal">
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
              <div v-if="educationalBackgrounds.length == 0" class="text-muted">
                Information not available.
                <br>
                <br>
              </div>
              <div style="margin-bottom: 20px;">
                <icon-button v-if="authorizeEdit" data-toggle="modal" data-target="#educational-background-modal">
                  ADD EDUCATIONAL BACKGROUND
                </icon-button>
              </div>
              <info-preview v-for="(education, index) in educationalBackgrounds" v-bind:key="index" icon="school" :title="education.school_name" :subtitle="education.course">
                {{education.from.split('-')[0]}} - {{education.to.split('-')[0]}}
                <template slot="options" v-if="authorizeEdit">
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
      <div v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
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
      <div v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
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
      <div v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
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
      <div v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
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
      <div v-if="authorizeEdit" class="modal-dialog modal-dialog-centered modal-lg">
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
    <photo-editor ref="photo-editor" @update="updateUserPhoto"></photo-editor>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import swal from 'sweetalert2'
import Form from 'vform'
import userBasicInfoModal from './../../components/user-profile/basicInfoModal'
import userAddressInfoModal from './../../components/user-profile/addressInfoModal'
import userContactInfoModal from './../../components/user-profile/contactInfoModal'
import photoEditor from './../../components/PhotoEditor'

[
  userBasicInfoModal,
  userAddressInfoModal,
  userContactInfoModal,
  photoEditor,
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
    user: {},
    programmingLanguages:[],
    userTechnologies: [],
    workExperiences: [],
    educationalBackgrounds: [],
    followedCompanies: [],
    userAddresses: [],
    userContactNumbers: [],

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
    }),
    userDescriptionForm: new Form({
      user_id: '',
      description: ''
    }),
    userBasicInfoForm: new Form({
      user_id: '',
      first_name: '',
      last_name: '',
      birth_date: '',
      gender: '',
    }),
  }),
  methods: {
    showPhotoEditor(){
      this.$refs['photo-editor'].show(this.user.photo);
    },
    async updateUserPhoto(photo_data){
      var form = new Form({
        photo_data: photo_data
      });

      this.$refs['photo-editor'].loading(true);

      const {data} = await form.patch('/api/userInfo/update/photo');
      
      this.user = data;
      this.$refs['photo-editor'].loading(false);
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
    async updateDescription(){
      const {data} = await this.userDescriptionForm.post('/api/userInfo/update/user_description');

      this.user = data.user;
      this.userDescriptionForm.description = this.description;
      jQuery('#description-modal').modal('hide');
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
    prepUpdateBasicInfo(){
      this.$refs['user-basic-info-modal'].prepUpdate(this.user);
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
    },
    updateUser(user){
      this.user = user
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
                console.log(data.data.status);
                if(data.data.status == 'created'){
                  $this.user = data.data.user
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
      this.workExperienceForm.user_id = this.$store.getters['auth/user'].id;
      this.educationalBackgroundForm.user_id = this.$store.getters['auth/user'].id;
      this.userDescriptionForm.user_id = this.$store.getters['auth/user'].id;
      this.userDescriptionForm.description = this.$store.getters['auth/user'].description;
      this.fetch('user');
      this.fetch('programmingLanguages');
      this.fetch('userTechnologies');
      this.fetch('workExperiences');
      this.fetch('userAddresses');
      this.fetch('educationalBackgrounds');
      this.fetch('followedCompanies');
      this.fetch('userContactNumbers');
    }
  },
  computed: {
    authorizeEdit(){
      return this.user.id == this.$store.getters['auth/user'].id
    }
  },
  mounted(){
    var $this = this;
    this.loadEveryThing();
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
  },
  watch: {
    $route(){
      this.loadEveryThing();
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
