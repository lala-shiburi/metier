<template>
  <card title="Create Company">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('password_updated')"/>

      <div style="text-align:center">
        <photo-converter style="width:200px; display:inline-block; background:#d9d9d9;" :form="form" :field="form.photo"></photo-converter>
      </div>
      <br>
      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Name</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password">
          <has-error :form="form" field="password"/>
        </div>
      </div>

      <!-- Address -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Address</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password">
          <has-error :form="form" field="password"/>
        </div>
      </div>

      <!-- Email -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Email</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password">
          <has-error :form="form" field="password"/>
        </div>
      </div>

      <!-- Website Url -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">Company Website Url</label>
        <div class="col-md-7">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" name="password">
          <has-error :form="form" field="password"/>
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
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      photo: '',
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
