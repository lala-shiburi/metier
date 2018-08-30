<template>
  <div>
    <div class="modal fade" ref="create-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <form @submit.prevent="create" @keydown="createForm.onKeydown($event)">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Educational Background</h5>
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
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/school.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">School Name</label>
                    <div class="col-md-7">
                      <input v-model="createForm.school_name" :class="{ 'is-invalid': createForm.errors.has('school_name') }" class="form-control" name="school_name">
                      <has-error :form="createForm" field="school_name"/>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Address</label>
                    <div class="col-md-7">
                      <input v-model="createForm.school_address" :class="{ 'is-invalid': createForm.errors.has('school_address') }" class="form-control" name="school_address">
                      <has-error :form="createForm" field="school_address"/>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-7">
                      <input v-model="createForm.school_email" :class="{ 'is-invalid': createForm.errors.has('school_email') }" class="form-control" name="school_email">
                      <has-error :form="createForm" field="school_email"/>
                    </div>
                  </div>

                  <!-- Number -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Contact Number</label>
                    <div class="col-md-7">
                      <input v-model="createForm.school_number" :class="{ 'is-invalid': createForm.errors.has('school_number') }" class="form-control" name="school_number">
                      <has-error :form="createForm" field="school_number"/>
                    </div>
                  </div>

                  <!-- Course -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Course</label>
                    <div class="col-md-7">
                      <input type="text" v-model="createForm.course" :class="{ 'is-invalid': createForm.errors.has('course') }" class="form-control" name="course">
                      <has-error :form="createForm" field="course"/>
                    </div>
                  </div>

                  <!-- From -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="createForm.from" :class="{ 'is-invalid': createForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="createForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row">
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
                <h5 class="modal-title" id="exampleModalLongTitle">Update Educational Background</h5>
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
                            <img ref="photo" class="absolute-center" :src="public_path+'/images/school.png'">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                  <!-- Name -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">School Name</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.school_name" :class="{ 'is-invalid': updateForm.errors.has('school_name') }" class="form-control" name="school_name">
                      <has-error :form="updateForm" field="school_name"/>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Address</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.school_address" :class="{ 'is-invalid': updateForm.errors.has('school_address') }" class="form-control" name="school_address">
                      <has-error :form="updateForm" field="school_address"/>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.school_email" :class="{ 'is-invalid': updateForm.errors.has('school_email') }" class="form-control" name="school_email">
                      <has-error :form="updateForm" field="school_email"/>
                    </div>
                  </div>

                  <!-- Number -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Contact Number</label>
                    <div class="col-md-7">
                      <input v-model="updateForm.school_number" :class="{ 'is-invalid': updateForm.errors.has('school_number') }" class="form-control" name="school_number">
                      <has-error :form="updateForm" field="school_number"/>
                    </div>
                  </div>

                  <!-- Course -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">Course</label>
                    <div class="col-md-7">
                      <input type="text" v-model="updateForm.course" :class="{ 'is-invalid':updateForm.errors.has('course') }" class="form-control" name="course">
                      <has-error :form="updateForm" field="course"/>
                    </div>
                  </div>

                  <!-- From -->
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">From</label>
                    <div class="col-md-7">
                      <input type="date" v-model="updateForm.from" :class="{ 'is-invalid':updateForm.errors.has('from') }" class="form-control" name="from">
                      <has-error :form="updateForm" field="from"/>
                    </div>
                  </div>

                  <!-- To -->
                  <div class="form-group row">
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
      school_name: '',
      school_address: '',
      school_email: '',
      school_number: '',
      course: '',
      from: '',
      to: '',
    }),
    updateForm: new Form({
      id: 0,
      user_id: '',
      school_name: '',
      school_address: '',
      school_email: '',
      school_number: '',
      course: '',
      from: '',
      to: '',
    }),
  }),
  methods: {
    async create(){
      const {data} = await this.createForm.post('/api/userInfo/add/education_background');;
      this.$emit('update', data.educationalBackgrounds);
      jQuery(this.$refs['create-modal']).modal('hide');
    },
    async update(){
      const {data} = await this.updateForm.post('/api/userInfo/update/education_background');
      this.$emit('update', data.educationalBackgrounds);
      jQuery(this.$refs['update-modal']).modal('hide');
    },
    prepUpdate(data){
      jQuery(this.$refs['update-modal']).modal('show');

      this.updateForm.id = data.id;
      this.updateForm.user_id = this.$store.getters['auth/user'].id;
      this.updateForm.school_name = data.school_name;
      this.updateForm.school_address = data.school_address;
      this.updateForm.school_email = data.school_email;
      this.updateForm.school_number = data.school_number;
      this.updateForm.course = data.course;
      this.updateForm.from = data.from;
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
