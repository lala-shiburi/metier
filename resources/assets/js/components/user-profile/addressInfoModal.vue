<template>
  <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
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
                      <input v-model="form.province" :class="{ 'is-invalid': form.errors.has('province') }" class="form-control" name="last_name" rows="10">
                      <has-error :form="form" field="province"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="form.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
export default {
  name: 'UserAddressInfoModal',

  props: {
    addresses: { type: Object, required: true },
    size: { type: String, default: null },
  },

  data: () => ({
    public_path: location.origin,
    form: new Form({
      user_id: '',
      address_text: '',
      province: '',
    }),
  }),
  methods: {
    async update(){
      const {data} = await this.form.post('/api/userInfo/update/basic_info');
      
      jQuery(this.$refs.modal).modal('hide');
    },
  },
  watch: {
    // 
  }
}
</script>
