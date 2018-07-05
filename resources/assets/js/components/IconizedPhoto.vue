<template>
  <div :data-toggle="title?tooltip:''" data-html="true" :title="'<b>'+title+'</b>'" class="iconized-photo" :class="size? size: 'small-icon'">
    <div class="photo-preview-container" style="width:initial; height:100%;">
      <div class="scaffold-div" style="height:100%; background:white;">
        <img src="http://localhost:8000/images/bg-img.png" class="bg-holder" style="width:initial; height:100%;"> 
        <img :src="photo" class="absolute-center" style="width:initial; height:100%;">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'IconizedPhoto',

  props: {
    photo: { type: String, required: true },
    size: { type: String, default: null },
    title: { type: String, default: null },
  },

  data: () => ({
    // 
  }),
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
