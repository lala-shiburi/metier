<template>
  <div>
    <div class="text-center container-body">
      <div class="text-muted">
        Do you have any special noted?
      </div>
      <button type="button" v-on:click="prepEditNote(false)" class="btn btn-success">Add Note</button>
      <br>
      <br>
      <div>
        <div class="note-card" v-for="(note, index) in notes" v-bind:key="index">
          <div class="note-header">{{note.title}}</div>
          <div>{{note.note}}</div>
          <br>
          <button type="button" v-on:click="prepEditNote(note, index)" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
          <button type="button" v-on:click="prepDeleteNote(note, index)" class="btn btn-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <form style="width: 100%;" @submit.prevent="validateResultNote" @keydown="noteForm.onKeydown($event)">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Note</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Title</label>
                <div class="col-md-7">
                  <input v-model="noteForm.title" :class="{ 'is-invalid': noteForm.errors.has('title') }" class="form-control" name="title" rows="10"/>
                  <has-error :form="noteForm" field="title"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">Note</label>
                <div class="col-md-7">
                  <textarea v-model="noteForm.note" :class="{ 'is-invalid': noteForm.errors.has('note') }" class="form-control" name="note" rows="10">
                  </textarea>
                  <has-error :form="noteForm" field="note"/>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <v-button :loading="noteForm.busy" type="success">Save</v-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

import Form from 'vform'
import swal from 'sweetalert2'
import axios from 'axios'

export default {
  name: 'NoteAdder',
  props:{
    notes:{
      type: Array,
      required: true
    }
  },
  data: () => ({
    noteForm: new Form({
      title: '',
      note: '',
      currentIndex: -1
    }),
  }),
  mounted () {
    // 
  },
  methods: {
    prepEditNote(data,index){
      if(data){
        this.noteForm.currentIndex = index;
        this.noteForm.title = data.title;
        this.noteForm.note = data.note;
      }
      else{
        this.noteForm.reset();
      }
      jQuery(this.$refs.modal).modal('show');
      jQuery('.modal-backdrop').hide();
    },
    goForward(){
      this.$emit('forward');
    },
    goBack(){
      this.$emit('back');
    },
    prepDeleteNote(data, index){
      var $this = this;
      swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $this.notes.splice(index,1);
          swal(
            'Deleted!',
            'Step has been deleted.',
            'success'
          )
        }
      })
    },
    async validateResultNote(){
      const { data } = await this.noteForm.post('/api/company/hiringprocess/validate/hiring/step/note');
      if(this.noteForm.currentIndex >= 0)
      {
        this.notes[this.noteForm.currentIndex] = {
          title: this.noteForm.title,
          note: this.noteForm.note,
        }
        this.$forceUpdate()
      }
      else
      {
        this.notes.push({
          title: this.noteForm.title,
          note: this.noteForm.note,
        })
      }
      jQuery(this.$refs.modal).modal('hide');
    },
  },
}
</script>
<style lang="scss" scoped>
  .note-card{
    background: #fafafa;
    font-size: 12px;
    text-align:left;
    border-bottom: 1px solid #ececec;
    padding: 10px;
    .note-header{
      font-weight: bold;
    }
  }
</style>

