<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Contact Info
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
          <label class="col-md-3 col-form-label text-md-right">Number</label>
          <div class="col-md-7">
            <input v-model="form.number" :class="{ 'is-invalid': form.errors.has('number') }" class="form-control" name="number" rows="10">
            <has-error :form="form" field="number"/>
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
export default {
  name: 'UserContactInfoModal',
  components: {
    SidebarPopup
  },
  props: {
    // 
  },

  data: () => ({
    public_path: location.origin,
    form: new Form({
      id: null,
      user_id: '',
      number: '',
    }),
  }),
  methods: {
    async update(){
      const {data} = await this.form.post('/api/userInfo/add/contact_number');
      
      this.$emit('update', data.contact_numbers);
      this.$refs.modal.hide()
    },
    prepUpdate(data){
      this.$refs.modal.show()
      this.form.id = data.id;
      this.form.user_id = data.user_id;
      this.form.number = data.number;
    },
    prepCreate(user_id){
      this.$refs.modal.show()
      console.log(user_id)
      this.form.reset();
      this.form.user_id = user_id;
    },
    close(){
      this.$refs.modal.hide()
    },
  },
}
</script>
