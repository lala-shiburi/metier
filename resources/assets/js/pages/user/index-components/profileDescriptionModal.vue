<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        About yourself
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
          <quill-editor class="form-control" style="height:initial;" :class="{ 'is-invalid': form.errors.has('description') }" v-model="form.description"
            :options="editorOption">
          </quill-editor>
          <has-error :form="form" field="description"/>
        </div>
        <div class="modal-footer">
          <a class="btn btn-secondary text-white" @click="close">Cancel</a>
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
    user: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    public_path: location.origin,
    form: new Form({
      user_id: '',
      description: ''
    }),
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
  }),
  methods: {
    async update(){
      const {data} = await this.form.post('/api/userInfo/update/user_description');
      await this.$store.dispatch('auth/fetchUser')
      this.$emit('update', data.user)
      this.$refs.modal.hide()
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(){
      this.form.user_id = this.user.id
      this.form.description = this.user.description
      this.$refs.modal.show()
    },
  },
}
</script>
