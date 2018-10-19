<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Company Basic Information
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
          <label class="col-md-3 col-form-label text-md-right">Name</label>
          <div class="col-md-7">
            <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" name="name" rows="10">
            <has-error :form="form" field="name"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Email</label>
          <div class="col-md-7">
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" name="email" rows="10">
            <has-error :form="form" field="email"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Address</label>
          <div class="col-md-7">
            <input v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }" class="form-control" name="address" rows="10">
            <has-error :form="form" field="address"/>
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
import Form from 'vform'
import SidebarPopup from '~/components/SidebarPopup'
import VueQuillEditor from 'vue-quill-editor'
export default {
  components: {
    SidebarPopup,
    'quill-editor': VueQuillEditor.quillEditor,
  },
  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data: () => ({
    form: new Form({
      company_id: null,
      name: '',
      email: '',
      address: '',
    })
  }),
  methods: {
    async update(){
      const {data} = await this.form.patch('/api/company/update/basic/info');
      
      this.$emit('update', data)
      this.$refs.modal.hide()
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(){
      this.form.company_id = this.company.id
      this.form.name = this.company.name
      this.form.email = this.company.email
      this.form.address = this.company.address
      this.$refs.modal.show()
    },
  },
}
</script>
<style>
.ql-editor {
  min-height: 200px;
}
</style>

