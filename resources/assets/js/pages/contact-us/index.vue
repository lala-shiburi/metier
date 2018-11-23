<template>
  <div>
    <form v-if="!submitted" @submit.prevent="submit" @keydown="form.onKeydown($event)">
      <h1 class="display-4">Contact Us</h1>
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" id="name" placeholder="Enter name">
        <has-error :form="form" field="name"/>
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }" type="email" class="form-control" id="email" placeholder="Enter email">
        <has-error :form="form" field="email"/>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="subject">Subject</label>
        <input v-model="form.subject" name="subject" :class="{ 'is-invalid': form.errors.has('subject') }"  class="form-control" id="subject" placeholder="Enter subject">
        <has-error :form="form" field="subject"/>
      </div>
      <div class="form-group">
        <label for="body">Body</label>
        <textarea v-model="form.body" name="body" :class="{ 'is-invalid': form.errors.has('body') }" class="form-control" placeholder="Enter Body" id="body" rows="5"></textarea>
        <has-error :form="form" field="body"/>
      </div>
      <v-button :loading="form.busy" type="success">Submit</v-button>
    </form>
    <p v-else class="text-center">
      <i class="fa fa-check-circle" aria-hidden="true"></i> Message submitted.
    </p>
    <br>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
export default {
  metaInfo () {
    return { title: 'Contact Us' }
  },
  data : () =>({
    public_path: location.origin,
    form: new Form({
      name: '',
      email: '',
      subject: '',
      body: ''
    }),
    submitted: false
  }),
  methods: {
    async submit(){
      const { data } = await this.form.post('/api/support/contact_us')
      this.submitted = true
    }
  },
}
</script>
