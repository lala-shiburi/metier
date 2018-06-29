<template>
  <div class="profile-view-modal" v-if="display">
    <div class="back-drop" v-on:click="display=false"></div>
    <div class="close-bttn" v-on:click="display=false">
      <i class="fa fa-times-circle fa-2x"></i>
    </div>
    <div class="modal-visible">
      <img class="absolute-center" :src="images[index]" height="90%">
    </div>
    <div class="button-right" v-on:click="goRight">
      <i class="fa fa-arrow-circle-right fa-2x"></i>
    </div>
    <div class="button-left" v-on:click="goLeft">
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
  }
}
</script>
