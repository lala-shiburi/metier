<template>
  <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Contact Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Number</label>
                    <div class="col-md-7">
                      <input v-model="form.number" :class="{ 'is-invalid': form.errors.has('number') }" class="form-control" name="number" rows="10">
                      <has-error :form="form" field="number"/>
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
  name: 'UserContactInfoModal',

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
      jQuery(this.$refs.modal).modal('hide');
    },
    prepUpdate(data){
      jQuery(this.$refs.modal).modal('show');
      this.form.id = data.id;
      this.form.user_id = data.user_id;
      this.form.number = data.number;
    },
    prepCreate(user_id){
      jQuery(this.$refs.modal).modal('show');
      console.log(user_id)
      this.form.reset();
      this.form.user_id = user_id;
    }
  },
}
</script>
