<template>
  <div class="photo-previewer row">
    <div class="col-12 photo-item photo-preview-container photo-item">
      <div class="scaffold-div">
        <img class="bg-holder" :src="public_path+'/images/default-opening.png'">
        <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
      </div>
    </div>
    <div class="col-12">
      <div class="row">
        <div class="col-4 photo-preview-container photo-item">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
          </div>
        </div>
        <div class="col-4 photo-preview-container photo-item">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
          </div>
        </div>
        <div class="col-4 photo-preview-container photo-item">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PhotoViewer',

  props: {
    // icon: { type: String, required: true },
    // size: { type: String, default: null },
  },
  data : () =>({
    public_path: location.origin
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
