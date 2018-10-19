<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Website Link
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
          <label class="col-md-3 col-form-label text-md-right">Website URL</label>
          <div class="col-md-7">
            <input v-model="form.website_url" :class="{ 'is-invalid': form.errors.has('website_url') }" class="form-control" name="website_url" rows="10">
            <has-error :form="form" field="website_url"/>
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
      website_url: ''
    })
  }),
  methods: {
    async update(){
      const {data} = await this.form.patch('/api/company/update/website/info');
      
      this.$emit('update', data)
      this.$refs.modal.hide()
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(){
      this.form.company_id = this.company.id
      this.form.website_url = this.company.website_url
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

