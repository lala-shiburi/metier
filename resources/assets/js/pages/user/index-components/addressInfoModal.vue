<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Address
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
          <label class="col-md-3 col-form-label text-md-right">Address</label>
          <div class="col-md-7">
            <input v-model="form.address_text" :class="{ 'is-invalid': form.errors.has('address_text') }" class="form-control" name="address_text" rows="10">
            <has-error :form="form" field="address_text"/>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">Province</label>
          <div class="col-md-7">
            <select v-model="form.province" :class="{ 'is-invalid': form.errors.has('province') }" class="form-control" name="province">
              <option value="" selected>-select</option>
              <option v-for="(province, index) in provinces" v-bind:key="index" :value="province.name"> {{province.name}} </option>
            </select>
            <has-error :form="form" field="province"/>
          </div>
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
export default {
  name: 'UserAddressInfoModal',
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
      address_text: '',
      province: '',
    }),
    provinces: window.config.provinces
  }),
  methods: {
    async update(){
      const {data} = await this.form.post('/api/userInfo/add/address');
      
      this.$emit('update', data.addresses);
      this.$refs.modal.hide()
    },
    close(){
      this.$refs.modal.hide()
    },
    prepUpdate(data){
      this.$refs.modal.show()
      this.form.id = data.id;
      this.form.user_id = data.user_id;
      this.form.address_text = data.address_text;
      this.form.province = data.province;
    },
    prepCreate(user_id){
      this.$refs.modal.show()
      console.log(user_id)
      this.form.reset();
      this.form.user_id = user_id;
    }
  },
}
</script>
