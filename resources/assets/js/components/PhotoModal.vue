<template>
  <div class="profile-view-modal" v-if="display">
    <div class="back-drop" v-on:click="display=false"></div>
    <div class="close-bttn" v-on:click="display=false">
      <i class="fa fa-times-circle fa-2x"></i>
    </div>
    <div class="modal-visible">
      <img class="absolute-center" :src="images[index]" height="90%">
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
    images: { type: Array, required: true }
  },
  data : () =>({
    public_path: location.origin+'/',
    display: true,
    index: this.currentIndex
  }),
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
      console.log(ev.keyCode)
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
