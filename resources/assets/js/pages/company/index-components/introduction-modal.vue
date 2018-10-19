<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Company Introduction
      </h6>
    </div>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <div class="modal-body">
        <div class="form-group">
          <quill-editor class="form-control" style="height:initial;" :class="{ 'is-invalid': form.errors.has('introduction') }" v-model="form.introduction"
            :options="editorOption">
          </quill-editor>
          <has-error :form="form" field="introduction"/>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" @click="close">Cancel</button>
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
  name: 'UserAddressInfoModal',
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
    public_path: location.origin,
    editorOption: {
      // some quill options
      modules: {
        toolbar: [
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'header': 1 }, { 'header': 2 }],
          [{ 'indent': '-1' }, { 'indent': '+1' }],
          [{ 'direction': 'rtl' }],
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          [{ 'font': [] }],
        ],
      }
    },
    form: new Form({
      introduction: '',
      company_id: null
    })
  }),
  methods: {
    async update(){
      const {data} = await this.form.patch('/api/company/update/introduction');
      
      this.company.introduction = this.form.introduction
      this.$refs.modal.hide()
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(){
      this.form.introduction = this.company.introduction
      this.form.company_id = this.company.id
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

