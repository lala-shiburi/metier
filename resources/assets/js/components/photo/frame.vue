<template>
  <div class="photo-preview-container photo-item">
    <div class="scaffold-div">
      <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
      <img class="absolute-center" :style="'width:'+width+'; height:'+height" v-if="src" :src="src">
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PhotoFrame',

  props: {
    // icon: { type: String, required: true },
    // size: { type: String, default: null },
    image: {
      type: String,
      required: true,
    }
  },
  data : () =>({
    public_path: location.origin,
    width: 'initial',
    height: 'initial'
  }),
  asyncComputed: {
    src(){
      var img = new Image
      var $this = this
      return new Promise((resolve, reject)=>{
        img.onload = () => {
          resolve(img.src)
          if(img.width > img.height){
            this.height = '100%'
          }
          else{
            this.width = '100%'
          }
        }
        img.src = this.image
      })
    }
  },
  methods: {
    // 
  },
}
</script>
