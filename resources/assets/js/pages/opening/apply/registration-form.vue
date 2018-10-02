<template>
  <form @submit.prevent="validate" @keydown="form.onKeydown($event)">
    <div class="form-group text-center">
      <h6>Do you have an existing account?</h6>
      <br>
      <div>
        <button @click="loginWithExistingAccount" class="btn btn-success">Login</button>
      </div>
      <br>
      <div class="text-muted">if not</div>
      <br>
      <a class="text-dark" data-toggle="collapse" href="#collapseExample">
        Create Account
      </a>
    </div>
    <div class="collapse" id="collapseExample">
      <div>
        <h6>Basic Information</h6>
        <div class="row">
          <div class="col-md-6 form-group">
            <label>First Name</label>
            <input type="text" v-model="form.first_name" :class="{ 'is-invalid': form.errors.has('first_name') }" class="form-control form-control-sm" name="first_name">
            <has-error :form="form" field="first_name"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Last Name</label>
            <input v-model="form.last_name" type="text" :class="{ 'is-invalid': form.errors.has('last_name') }" class="form-control form-control-sm" name="last_name">
            <has-error :form="form" field="last_name"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Birthdate</label>
            <input v-model="form.birth_date" type="date" :class="{ 'is-invalid': form.errors.has('birth_date') }" class="form-control form-control-sm" name="birth_date">
            <has-error :form="form" field="birth_date"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Gender</label>
            <select v-model="form.gender" :class="{ 'is-invalid': form.errors.has('gender') }" class="form-control form-control-sm" name="gender">
              <option value='' selected>Choose Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <has-error :form="form" field="gender"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Contact #</label>
            <input v-model="form.number" :class="{ 'is-invalid': form.errors.has('number') }" type="text" class="form-control form-control-sm" name="number">
            <has-error :form="form" field="number"/>
          </div>
          <div class="col-md-6 form-group">
            <label>Resume File</label>
            <document-upload-input :form="form" field="resume_file" :invalid="form.errors.has('resume_file')"/>
            <has-error :form="form" field="resume_file"/>
          </div>
          <div class="col-md-6 form-group">
            <h6>Account Credentials</h6>
            <div class="form-group">
              <label>Email</label>
              <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" type="email" class="form-control form-control-sm" name="email">
              <has-error :form="form" field="email"/>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" type="password" class="form-control form-control-sm" name="password">
              <has-error :form="form" field="password"/>
            </div>
            <div class="form-group">
              <label>Re-Password</label>
              <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" type="password" class="form-control form-control-sm" name="password_confirmation">
              <has-error :form="form" field="password_confirmation"/>
            </div>
          </div>
        </div>
        <small id="emailHelp" class="form-text text-muted">
          Please note that with the information you provide in this registration form, we will create a personal account for you. 
          You will automatically be logged-in after you submit your application.
        </small>
        <br>
        <div class="border-top pt-3">
          <a href="JavaScript:void(0)" class="btn btn-secondary" v-on:click="back">Back</a>
          <v-button :loading="form.busy" type="success">Next</v-button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import swal from 'sweetalert2'
import Vue from 'vue'
export default {
  props:{
    form: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    // 
  }),
  methods: {
    back(){
      this.$emit('back');
    },
    forward(){
      this.$emit('forward')
    },
    async validate(){
      const {data} = await this.form.post('/api/application/validate/guest/onsite/registration/validation')
      this.forward();
    },
    loginWithExistingAccount(){
      jQuery('#login-button').trigger('click')
    }
  },
}
</script>
