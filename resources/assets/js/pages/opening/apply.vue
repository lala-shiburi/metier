<template>
  <div style="padding-bottom: 100px;">
    <wizard ref="wizard" :currentPanel="0">
      <template slot="steps">
        <div class="step-container" name="Basic Info">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/info-sign.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Fill up">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/opening-description.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Complete">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/check.png'"></iconized-photo>
          </div>
        </div>
      </template>
      <template slot="panels">
        <form @submit.prevent="apply" @keydown="opening.onKeydown($event)">

          <opening-card :noApply="true" v-if="opening.id" :opening="opening">
            <!-- Submit Button -->
            <div style="height: 50px;">
              <v-button :loading="opening.busy" style="position:absolute; bottom: 15px; right:15px;" type="success">Continue</v-button>
            </div>
          </opening-card>

        </form>
        <form @submit.prevent="create" @keydown="form1.onKeydown($event)">
          <!-- Application Letter -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Application Letter</label>
            <div class="col-md-7">
              <quill-editor class="form-control" :class="{ 'is-invalid': form1.errors.has('application_letter') }" v-model="form1.application_letter"
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
            <div class="col-md-9 ml-md-auto">
              <a href="JavaScript:void(0)" class="btn btn-secondary" v-on:click="left">Back</a>
              <v-button :loading="form1.busy" type="success">Submit</v-button>
            </div>
          </div>
        </form>
        <form>

          <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Well done!</h4>
            <p>Your Application is now ready to be submitted.</p>
            <hr>
            <p class="mb-0">Click Submit button.</p>
          </div>
          
          <!-- Submit Button -->
          <div class="form-group row" style="margin-top: 30px;">
            <div class="col-md-12" style="text-align:center;">
              <router-link :to="{ name: 'company.profile', params: { id : opening.company_id } }" class="navbar-brand">
                <!-- {{ appName }} -->
                See other openings
              </router-link>
            </div>
          </div>
        </form>
      </template>
    </wizard>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
import VueQuillEditor from 'vue-quill-editor'
import Vue from 'vue'
import { mapGetters } from 'vuex'
Vue.component('quill-editor', VueQuillEditor.quillEditor)
export default {
  middleware: 'auth',

  metaInfo () {
    return { title: 'Create Application' }
  },

  data: () => ({
    form1: new Form({
      application_letter: '',
      expected_salary: ''
    }),
    form2: new Form({
      application_letter: '',
      expected_salary: '',
      user_id: null,
      opening_id: null
    }),
    opening:{},
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
    }
  }),

  methods: {
    apply(){
      this.$refs.wizard.next();
    },
    async create () {
      this.form1.user_id = this.user.id;
      this.form1.opening_id = this.$route.params.opening_id;
      const {data} = await this.form1.post('/api/application/create/application')
      this.$refs.wizard.next();
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
    var $this = this;
    (async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: { opening_id: $this.$route.params.opening_id }
        })
      $this.opening = data;
    }())
  }
}
</script>

<style>
.ql-editor {
  min-height: 200px;
}
</style>
