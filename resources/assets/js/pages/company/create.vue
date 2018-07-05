<template>
  <card title="Create Company">
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
  </card>
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
    form: new Form({
      name: '',
      photo: '',
      address: '',
      email: '',
      website_url: ''
    })
  }),

  methods: {
    async create () {
      const {data} = await this.form.post('/api/company/create')
      this.$router.push("/company/profile/"+data.company_id);
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
