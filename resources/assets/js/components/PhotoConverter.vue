<template>
  <div class="photo-preview-container">
    <div class="scaffold-div">
      <div class="scaffold-div">
        <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
        <img ref="photo" class="absolute-center" :src="placeholder ? public_path + '/' + placeholder : public_path+'/images/photo.png'">
      </div>
      <div class="upload-button" v-on:click="prompFile">
        <div class="bg"></div>
        <div class="text">Upload Company Logo</div>
        <input type="file" ref="file_input">
        <input v-model="form[field]" :name="field">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PhotoConverter',

  props: {
    form: {
      type: Object,
      required: true
    },
    field: {
      type: String,
      required: true
    },
    placeholder:{
      type: String,
      default: null
    }
  },
  data: () => ({
    public_path: location.origin,
  }),
  methods: {
    prompFile(){
      this.$refs.file_input.click()
    },
    processFile(files){
      var imageTypes = ['image/png','image/x-icon','image/jpeg', 'image/gif', 'image/bmp', 'image/jpg'];
      var $this = this;

			var fileType = files[0].type;

			if (!imageTypes.includes(fileType)) {
				alert('dropped file is not an image');
				return false;
			}

			// FileReader support
			if (FileReader && files && files.length) {
				var fr = new FileReader();
				fr.onload = function () {
          $this.$refs.photo.src = fr.result;
          $this.form[$this.field] = fr.result;
				}
				fr.readAsDataURL(files[0]);
			}
		}
  },
  mounted(){
    var $this = this;
    jQuery(this.$refs.file_input).change(function(evt){
      var tgt = evt.target || window.event.srcElement,
			    files = tgt.files;
      $this.processFile(files)
    });
  }
}
</script>
