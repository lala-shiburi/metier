<template>
  <sidebar-popup ref="modal">
    <h6 class="p-15 border-bottom">
      Step
    </h6>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <form @submit.prevent="validateStep" @keydown="stepForm.onKeydown($event)">
      <div class="modal-body">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Name</label>
            <div class="col-md-7">
              <input v-model="stepForm.name" :class="{ 'is-invalid': stepForm.errors.has('name') }" class="form-control" name="name">
              <has-error :form="stepForm" field="name"/>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Description <span class="text-muted">(optional)</span></label>
            <div class="col-md-7">
              <textarea v-model="stepForm.description" :class="{ 'is-invalid': stepForm.errors.has('description') }" class="form-control" name="description"/>
              <has-error :form="stepForm" field="description"/>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <a class="btn btn-secondary text-white" @click="close">Close</a>
        <v-button :loading="stepForm.busy" type="success">Save</v-button>
      </div>
      </form>
  </sidebar-popup>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import swal from 'sweetalert2'
import SidebarPopup from '~/components/SidebarPopup'

export default {
  middleware: 'auth',
  components:{
    SidebarPopup
  },
  data : () =>({
    stepForm: new Form({
      name: '',
      description: '',
      index: -1
    }),
  }),
  methods: {
    validateStep: async function(){
      const {data} = await this.stepForm.post('/api/company/hiringprocess/validate/process/step');

      this.$emit('update', this.stepForm)
      this.$refs.modal.hide()
    },
    prep_create(){
      this.stepForm.reset();
      this.$refs.modal.show()
    },
    prep_edit: function(data,index){
      this.stepForm.name = data.name;
      this.stepForm.id = data.id;
      this.stepForm.description = data.description;
      this.stepForm.index = index;
      this.$refs.modal.show()
    },
    close(){
      this.$refs.modal.hide()
    }
  },
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
