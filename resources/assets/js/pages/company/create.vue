<template>
  <card title="Create Company">
    <form v-if="false" @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" message="Registration Successful"/>

      <div class="text-center">
        <img ref="company-logo" v-on:click="showPhotoEditor" :src="photo" class="rounded img-thumbnail" width="200px">
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
      
      <!-- Province -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Employee Count(Optional)</label>
        <div class="col-md-7">
          <select v-model="form.employee_count" :class="{ 'is-invalid': form.errors.has('employee_count') }" class="form-control" name="employee_count">
            <option value="" selected>-select</option>
            <option v-for="(employee_count, index) in employee_counts" v-bind:key="index" :value="employee_count"> {{employee_count}} </option>
          </select>
          <has-error :form="form" field="province"/>
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
      
      <!-- Province -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Province</label>
        <div class="col-md-7">
          <select v-model="form.province" :class="{ 'is-invalid': form.errors.has('province') }" class="form-control" name="province">
            <option value="" selected>-select</option>
            <option v-for="(province, index) in provinces" v-bind:key="index" :value="province.name"> {{province.name}} </option>
          </select>
          <has-error :form="form" field="province"/>
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
    <profile-picture-modal ref="photo-editor" @update="updateLogo"/>
    <h6>Please Contact Us</h6>
    <br>
    <p>
      Jobseed would like to verify your business. Please send us a brief description of your business.
    </p>
    <p>
      Click <router-link :to="{ name: 'contact-us'}">here</router-link>.
    </p>
    <p>
      After we verify you business, we will send you an email with a link to a company registration form.
    </p>
  </card>
</template>

<script>
import Form from 'vform'
import ProfilePictureModal from '~/components/photo-editors/profilePictureModal'
export default {
  middleware: 'auth',
  scrollToTop: false,
  components: {
    ProfilePictureModal
  },
  metaInfo () {
    return { title: 'Create Company' }
  },

  data: () => ({
    form: new Form({
      name: '',
      photo: '',
      address: '',
      email: '',
      website_url: '',
      province: '',
      employee_count: ''
    }),
    photo: location.origin+'/images/photo.png',
    company_photo_added: false,
    provinces: window.config.provinces,
    employee_counts: window.config.employee_counts
  }),

  methods: {
    async create () {
      if(!this.company_photo_added)
      {
        this.form.photo = null
      }
      const {data} = await this.form.post('/api/company/create')
      this.$router.push("/company/profile/"+data.company_id);
    },
    updateLogo(photo_data){
      this.photo = photo_data
      this.form.photo = photo_data;
      this.$refs['company-logo'].src = photo_data;
      this.form.photo = true
    },
    showPhotoEditor(){
      this.$refs['photo-editor'].prepUpdate(this.form.photo);
    },
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
