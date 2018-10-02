<template>
  <div class="custom-file form-control" :class="{ 'is-invalid': invalid }">
    <label ref="label" class="custom-file-label" for="inputGroupFile01">Choose file</label>
    <input @change="upload($event.target.files)" :class="{ 'is-invalid': form.errors.has('resume_file') }" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
  </div>
</template>

<script>
import axios from 'axios'
import swal from 'sweetalert2'
export default {
  name: 'DocumentUploadInput',
  props:{
    form: {
      type: Object,
      required: true
    },
    field: {
      type: String,
      required: true
    },
    invalid: {
      type: Boolean,
      default: false
    }
  },
  data: () => ({}),
  methods: {
    upload(files){
      var ext = files[0].name.split('.')[1]
      this.form.busy = true
      if(ext=="pdf" || ext=="docx" || ext=="doc"){
        jQuery(this.$el).removeClass('is-invalid')
        jQuery(this.$refs.label).html(files[0].name)
        var formData = new FormData();
        formData.append('file',files[0],files[0].name);
        axios({
          method: 'post',
          url: '/api/application/upload/resume_file',
          data: formData,
          onUploadProgress: function(ev){
            console.log(ev)
          }
        }).then( ({data}) => {
          this.form[this.field] = data.filename
          this.form.busy = false
        });
      }
      else{
        this.form.busy = false
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please choose .pdf, .doc, or .docx files!',
        })
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.form-control{
  border: none!important;
  &.is-invalid{
    .custom-file-label{
      border-color: #dc3545;
    }
  }
}
</style>
