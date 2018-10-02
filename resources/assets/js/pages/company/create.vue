<template>
  <card title="Create Company">
    <form @submit.prevent="create" @keydown="form.onKeydown($event)">
      <alert-success :form="form" message="Registration Successful"/>

      <div class="text-center">
        <img ref="company-logo" v-on:click="showPhotoEditor" :src="form.photo" class="rounded img-thumbnail" width="200px">
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
      photo: location.origin+'/images/photo.png',
      address: '',
      email: '',
      website_url: '',
      province: ''
    }),
    company_photo_added: false,
    provinces: window.config.provinces,
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
