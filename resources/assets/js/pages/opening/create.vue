<template>
  <div>
    <wizard ref="wizard" :currentPanel="0">
      <template slot="steps">
        <div class="step-container" name="Basic Info">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/info-sign.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Description">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/opening-description.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Description">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/code.png'"></iconized-photo>
          </div>
        </div>
        <div class="step-container" name="Skills">
          <div class="step">
            <iconized-photo size="medium-icon" :photo="public_path+'/images/check.png'"></iconized-photo>
          </div>
        </div>
      </template>
      <template slot="panels">
        <form @submit.prevent="validateForm1" @keydown="form1.onKeydown($event)">
          <alert-success :form="form1" message="Registration Successful"/>

          <div style="text-align:center">
            <photo-converter style="width:200px; display:inline-block; background:#d9d9d9;" :form="form1" field="photo"></photo-converter>
          </div>
          <br>
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Position / Title</label>
            <div class="col-md-7">
              <input v-model="form1.title" :class="{ 'is-invalid': form1.errors.has('title') }" class="form-control" name="title">
              <has-error :form="form1" field="title"/>
            </div>
          </div>

          <!-- Address -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Salary Range</label>
            <div class="col-md-7">
              <select v-model="form1.salary_range" :class="{ 'is-invalid': form1.errors.has('salary_range') }" class="form-control" name="salary_range">
                <option value="" selected>-select</option>
                <option v-for="(range, index) in salary_ranges" v-bind:key="index" :value="index">
                  {{range}}
                </option>
              </select>
              <has-error :form="form1" field="salary_range"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Years of Experience</label>
            <div class="col-md-7">
              <select v-model="form1.professional_years" :class="{ 'is-invalid': form1.errors.has('professional_years') }" class="form-control" name="professional_years">
                <option value="" selected>-select</option>
                <option v-for="(range, index) in work_experiences" v-bind:key="index" :value="index">
                  {{range}}
                </option>
              </select>
              <has-error :form="form1" field="professional_years"/>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form1.busy" type="success">Save</v-button>
            </div>
          </div>
        </form>
        <form @submit.prevent="create" @keydown="form.onKeydown($event)">
          <alert-success :form="form" message="Registration Successful"/>

          <div style="text-align:center">
            <photo-converter style="width:200px; display:inline-block; background:#d9d9d9;" :form="form" field="photo"></photo-converter>
          </div>
          <br>
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-7">
              <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" name="name">
              <has-error :form="form" field="name"/>
            </div>
          </div>

          <!-- Address -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Address</label>
            <div class="col-md-7">
              <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-control" name="address">
              <has-error :form="form" field="address"/>
            </div>
          </div>

          <!-- Email -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Email</label>
            <div class="col-md-7">
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" name="email">
              <has-error :form="form" field="email"/>
            </div>
          </div>

          <!-- Website Url -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Company Website Url</label>
            <div class="col-md-7">
              <input v-model="form.website_url" :class="{ 'is-invalid': form.errors.has('website_url') }" class="form-control" name="website_url">
              <has-error :form="form" field="website_url"/>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-group row">
            <div class="col-md-9 ml-md-auto">
              <v-button :loading="form.busy" type="success">Save</v-button>
            </div>
          </div>
        </form>
      </template>
    </wizard>
  </div>
</template>

<script>
import Form from 'vform'
export default {
  middleware: 'auth',
  scrollToTop: false,

  metaInfo () {
    return { title: 'Create Company' }
  },

  data: () => ({
    form1: new Form({
      title: '',
      salary_range: '',
      professional_years: '',
    }),
    form: new Form({
      title: '',
      salary_range: '',
      professional_years: '',
    }),
    public_path: location.origin,
    salary_ranges: window.config.salary_ranges,
    work_experiences: window.config.work_experiences
  }),

  methods: {
    async validateForm1 () {
      const {data} = await this.form1.post('/api/opening/validate/basicInfo')
      // this.$router.push("/company/profile/"+data.company_id);
    },
    right(){
      this.$refs.wizard.next();
    },
    left(){
      this.$refs.wizard.previews();
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
