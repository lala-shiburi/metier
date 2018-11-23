<template>
  <div class="profile-view-modal" v-if="display">
    <div class="back-drop" v-on:click="display=false"></div>
    <div class="close-bttn" v-on:click="display=false">
      <i class="fa fa-times-circle fa-2x"></i>
    </div>
    <div class="modal-visible">
      <img class="absolute-center" :src="current_src" :style="'height:'+height+'; width:'+width">
    </div>
    <div class="button-right" :class="index == images.length - 1 ? 'text-white-50' : ''" v-on:click="goRight">
      <i class="fa fa-arrow-circle-right fa-2x"></i>
    </div>
    <div class="button-left" :class="index == 0 ? 'text-white-50' : ''" v-on:click="goLeft">
      <i class="fa fa-arrow-circle-left fa-2x"></i>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PhotoModal',

  props: {
    currentIndex: { type: Number, required: true },
    images: { type: Array, required: true },
  },
  data : () =>({
    public_path: location.origin+'/',
    display: true,
    index: this.currentIndex,
    width: 'initial',
    height: 'initial',
  }),
  asyncComputed: {
    current_src(){
      var img = new Image
      return new Promise((resolve, reject)=>{
        img.onload = () => {
          resolve(this.images[this.index])

          // display height and image height ratio
          var doc_height = document.documentElement.clientHeight
          var doc_width = document.documentElement.clientWidth
          var height_ratio = doc_height / img.height
          var width_ratio = doc_width / img.width
          // calculated width based on ratio
          var calculated_width = height_ratio * img.width
          var calculated_height = width_ratio * img.height

          var height_should_dominate = false

          if(img.width > img.height){
            height_should_dominate =  calculated_width < doc_width
          }
          else{
            height_should_dominate =  calculated_height > doc_height
          }

          if(height_should_dominate){
            this.width = 'initial'
            this.height = '90%'
          }
          else{
            this.height = 'initial'
            this.width = '90%'
          }
        }

        img.src = this.images[this.index]
      })
    }
  },
  methods: {
    goRight: function(){
      if(this.index + 1 < this.images.length)
      this.index++
    },
    goLeft: function(){
      if(this.index != 0)
      this.index--
    }
  },
  created: function(){
    this.index = this.currentIndex
  },
  mounted(){
    var $this = this

    jQuery(document).keydown(function(ev){
      if(ev.keyCode == 37){
        $this.goLeft()
      }
      else if(ev.keyCode == 39){
        $this.goRight()
      }
      else if(ev.keyCode == 27){
        $this.display = false
      }
    })
  }
}
</script>
