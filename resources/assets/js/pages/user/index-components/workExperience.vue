<template>
  <div>
    <div class="modal fade" ref="create-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="create" @keydown="createForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Work Experience</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <div style="text-align:center">
                    <div style="width:200px; display:inline-block; background:#d9d9d9;">
                      <div class="photo-preview-container">
                        <div class="scaffold-div">
                          <div class="scaffold-div">
                            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/company.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Company Name</label>
                    <div class="col-md-7">
                      <input v-model="createForm.company_name" :class="{ 'is-invalid': createForm.errors.has('company_name') }" class="form-control" name="company_name">
                      <has-error :form="createForm" field="company_name"/>
                    </div>
                  </div>

                  <!-- Position -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Position</label>
                    <div class="col-md-7">
                      <input v-model="createForm.position" :class="{ 'is-invalid': createForm.errors.has('position') }" class="form-control" name="position">
                      <has-error :form="createForm" field="position"/>
                    </div>
                  </div>

                  <!-- current job -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Status</label>
                    <div class="col-md-7">
                      <div class="btn-group btn-group-toggle">
                        <label class="btn btn-secondary" :class="createForm.current == 0 ? 'active': ''">
                          <input type="radio" name="current" value="0" v-model="createForm.current" id="option2"> Previews Job
                        </label>
                        <label class="btn btn-secondary" :class="createForm.current == 1 ? 'active': ''">
                          <input type="radio" name="current" value="1" v-model="createForm.current" id="option1" checked> Present Job
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- from -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="createForm.from" :class="{ 'is-invalid': createForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="createForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row" v-if="createForm.current == 0">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="createForm.to" :class="{ 'is-invalid': createForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="createForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="createForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" ref="update-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="update" @keydown="updateForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Work Experience</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <div style="text-align:center">
                    <div style="width:200px; display:inline-block; background:#d9d9d9;">
                      <div class="photo-preview-container">
                        <div class="scaffold-div">
                          <div class="scaffold-div">
                            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/company.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Company Name</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.company_name" :class="{ 'is-invalid': updateForm.errors.has('company_name') }" class="form-control" name="company_name">
                      <has-error :form="updateForm" field="company_name"/>
                    </div>
                  </div>

                  <!-- Position -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Position</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.position" :class="{ 'is-invalid': updateForm.errors.has('position') }" class="form-control" name="position">
                      <has-error :form="updateForm" field="position"/>
                    </div>
                  </div>

                  <!-- current job -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Status</label>
                    <div class="col-md-7">
                      <div class="btn-group btn-group-toggle">
                        <label class="btn btn-secondary" :class="updateForm.current == 0 ? 'active': ''">
                          <input type="radio" name="current" value="0" v-model="updateForm.current" id="option2"> Previews Job
                        </label>
                        <label class="btn btn-secondary" :class="updateForm.current == 1 ? 'active': ''">
                          <input type="radio" name="current" value="1" v-model="updateForm.current" id="option1" checked> Present Job
                        </label>
                      </div>
                    </div>
                  </div>

                  <!-- from -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="updateForm.from" :class="{ 'is-invalid': updateForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="updateForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row" v-if="updateForm.current == 0">
                    <label class="col-md-3 col-form-label text-md-right">To</label>
                    <div class="col-md-7">
                      <input type="date" v-model="updateForm.to" :class="{ 'is-invalid': updateForm.errors.has('to') }" class="form-control" name="to">
                      <has-error :form="updateForm" field="to"/>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <v-button :loading="updateForm.busy" type="success">Save</v-button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
export default {
  name: 'WorkExperience',

  props: {
    // 
  },

  data: () => ({
    public_path: location.origin,
    createForm: new Form({
      user_id: '',
      company_name: '',
      position: '',
      from: '',
      to: '',
      current:0
    }),
    updateForm: new Form({
      id: 0,
      user_id: '',
      company_name: '',
      position: '',
      from: '',
      to: '',
      current:0
    }),
  }),
  methods: {
    async create(){
      const {data} = await this.createForm.post('/api/userInfo/add/work_experience');
      this.$emit('update', data.workExperiences);
      jQuery(this.$refs['create-modal']).modal('hide');
    },
    async update(){
      const {data} = await this.updateForm.post('/api/userInfo/update/work_experience');
      this.workExperiences = data.workExperiences;
      this.$emit('update', data.workExperiences);
      jQuery(this.$refs['update-modal']).modal('hide');
    },
    prepUpdate(data){
      jQuery(this.$refs['update-modal']).modal('show');
      this.updateForm.id = data.id;
      this.updateForm.user_id = this.$store.getters['auth/user'].id;
      this.updateForm.company_name = data.company_name;
      this.updateForm.position = data.position;
      this.updateForm.from = data.from;
      this.updateForm.current = data.is_current;
      this.updateForm.to = data.to;
    },
    prepCreate(){
      jQuery(this.$refs['create-modal']).modal('show');
      this.createForm.reset();
      this.createForm.user_id = this.$store.getters['auth/user'].id;
    }
  },
}
</script>
