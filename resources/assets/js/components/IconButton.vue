<template>
  <button></button>
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
