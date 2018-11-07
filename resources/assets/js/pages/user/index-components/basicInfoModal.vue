<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Basic Info
      </h6>
    </div>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <div class="modal-body">
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">First Name</label>
          <div class="col-md-7">
            <input v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control" name="first_name" rows="10">
            <has-error :form="form" field="first_name"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Last Name</label>
          <div class="col-md-7">
            <input v-model="form.last_name" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control" name="last_name" rows="10">
            <has-error :form="form" field="last_name"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Job Title</label>
          <div class="col-md-7">
            <input v-model="form.job_title" :class="{ 'is-invalid': form.errors.has('job_title') }" class="form-control" name="job_title" rows="10">
            <has-error :form="form" field="job_title"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Email</label>
          <div class="col-md-7">
            <input disabled :value="user.email" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Birth Date</label>
          <div class="col-md-7">
            <input v-model="form.birth_date" type="date" :class="{ 'is-invalid': form.errors.has('birth_date') }" class="form-control" name="birth_date" rows="10">
            <has-error :form="form" field="birth_date"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Gender</label>
          <div class="col-md-7">
            <select v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" class="form-control" name="gender">
              <option value="" selected>-select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <has-error :form="form" field="birth_date"/>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="close">Close</button>
          <v-button :loading="form.busy" type="success">Save</v-button>
        </div>
      </div>
    </form>
  </sidebar-popup>
</template>

<script>
import axios from 'axios'
import SidebarPopup from '~/components/SidebarPopup'
import Form from 'vform'
export default {
  name: 'UserBasicInfoModal',
  components: {
    SidebarPopup
  },
  props: {
    user: { type: Object, required: true },
    size: { type: String, default: null },
  },

  data: () => ({
    public_path: location.origin,
    form: new Form({
      user_id: '',
      first_name: '',
      last_name: '',
      job_title: '',
      // email: '',
      birth_date: '',
      gender: '',
    }),
  }),
  methods: {
    async update(){
      const {data} = await this.form.post('/api/userInfo/update/basic_info');
      
      this.$refs.modal.hide()
      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      this.$emit('update',data.user);
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(user){
      this.$refs.modal.show()
      this.form.user_id = user.id
      this.form.first_name = user.first_name
      this.form.last_name = user.last_name
      this.form.birth_date = user.birth_date
      this.form.job_title = user.job_title
      this.form.gender = user.gender
    }
  },
}
</script>
