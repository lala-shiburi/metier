<template>
  <div style="padding-bottom: 100px;">
    <wizard v-if="!existing_application && opening" ref="wizard" :currentPanel="0">
      <template slot="steps">
        <div class="step-container" name="Opening">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/info-sign.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" v-if="!user || onsite_registered" name="Applicant Info">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/opening-description.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Application Letter">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/letter.svg'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Complete">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/check.png'"></iconized-photo>
          </div>
        </div>
      </template>
      <template slot="panels">
        <form @submit.prevent="apply">
          <div class="col-lg-4 offset-md-4">
            <opening-card :noApply="true" v-if="opening.id" :opening="opening">
              <!-- Submit Button -->
              <br>
              <div style="height: 50px;">
                <v-button :loading="opening.busy" style="position:absolute; bottom: 15px; right:15px;" type="success">Continue</v-button>
              </div>
            </opening-card>
          </div>
        </form>
        <registration-form v-if="!user" :form="registrationForm" @back="left" @forward="right"/>
        <form @submit.prevent="create" @keydown="form1.onKeydown($event)">
          <!-- Application Letter -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Application Letter</label>
            <div class="col-md-7">
              <quill-editor class="form-control" style="height:initial;" :class="{ 'is-invalid': form1.errors.has('application_letter') }" v-model="form1.application_letter"
                            :options="editorOption"
                            @blur="onEditorBlur($event)"
                            @focus="onEditorFocus($event)"
                            @ready="onEditorReady($event)">
              </quill-editor>
              <has-error :form="form1" field="application_letter"/>
            </div>
          </div>

          <!-- Expected Salary -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Expected Salary (Optional)</label>
            <div class="col-md-7">
              <input v-model="form1.expected_salary" :class="{ 'is-invalid': form1.errors.has('expected_salary') }" class="form-control" name="expected_salary">
              <has-error :form="form1" field="expected_salary"/>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-lg-12">
              <div class="border-top pt-3">
                <a href="JavaScript:void(0)" class="btn btn-secondary" v-on:click="left">Back</a>
                <v-button :loading="form1.busy" type="success">Submit</v-button>
              </div>
            </div>
          </div>
        </form>
        <form>

          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <p>Your Application is now ready to be submitted.</p>
            <hr>
          </div>
          
          <!-- Submit Button -->
          <div class="form-group row" style="margin-top: 30px;">
            <div class="col-md-12" style="text-align:center;">
              <router-link :to="{ name: 'company.profile', params: { id : opening.company.id } }" class="navbar-brand">
                <!-- {{ appName }} -->
                See other openings
              </router-link>
            </div>
          </div>
        </form>
      </template>
    </wizard>
    <card v-else>
      <div v-if="opening">
        Your application to this Job Opening already exist.
        <router-link :to="{ name: 'user.application.progress', params: { application_id : existing_application.id } }">
          See application
        </router-link>
      </div>
      <div class="text-center text-muted" v-else>
        Loading...
      </div>
    </card>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import VueQuillEditor from 'vue-quill-editor'
import Vue from 'vue'
import { mapGetters } from 'vuex'
import RegistrationForm from './registration-form'
export default {
  components: {
    'quill-editor':VueQuillEditor.quillEditor,
    RegistrationForm
  },
  metaInfo () {
    return { title: 'Create Application' }
  },

  data: () => ({
    form1: new Form({
      application_letter: '',
      expected_salary: ''
    }),
    onsite_registered: false,
    registrationForm: new Form({
      first_name:'',
      last_name:'',
      birthdate:'',
      gender:'',
      email:'',
      number: '',
      resume_file:'',
      password: '',
      password_confirmation:''
    }),
    opening: null,
    public_path: location.origin,
    editorOption: {
      // some quill options
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'header': 1 }, { 'header': 2 }],
          [{ 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'direction': 'rtl' }],
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          [{ 'font': [] }],
        ],
      }
    },
    existing_application: null
  }),

  methods: {
    apply(){
      this.$refs.wizard.next();
    },
    async fetch_opening(){
      const { data } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: { opening_id: this.$route.params.opening_id }
        })
      this.opening = data.data;
      this.existing_application = data.data.user_application;
    },
    async create () {
      this.form1.opening_id = this.$route.params.opening_id;

      // concat applicant info if auth does not exist
      if(!this.user){
        this.form1.applicant = this.registrationForm
      }

      const {data} = await this.form1.post('/api/application/create/application')
      this.loginApplicant(data)

      this.$refs.wizard.next();
    },
    async loginApplicant(data){
      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token.token,
        remember: false
      })
      this.onsite_registered = true

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')
    },
    onEditorBlur(quill) {
      console.log('editor blur!', quill)
    },
    onEditorFocus(quill) {
      console.log('editor focus!', quill)
    },
    onEditorReady(quill) {
      console.log('editor ready!', quill)
    },
    onEditorChange({ quill, html, text }) {
      console.log('editor change!', quill, html, text)
      this.content = html
    },
    right(){
      this.$refs.wizard.next();
    },
    left(){
      this.$refs.wizard.previews();
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  mounted(){
    this.fetch_opening();
  },
  watch: {
    user(){
      console.log('asdds')
      this.fetch_opening()
      this.$refs.wizard.renderLines()
    }
  }
}
</script>

<style>
.ql-editor {
  min-height: 200px;
}
</style>
