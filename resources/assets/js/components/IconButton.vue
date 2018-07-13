<template>
  <div class="small-round-bttn btn-primary">
    <div class="bttn-icon">
      <p>+</p>
    </div>
    <slot/>
  </div>
</template>

<script>
export default {
  name: 'IconButton',

  props: {
    // 
  },
  data : () =>({
    public_path: location.origin+'/',
  }),
  methods: {
    goRight: function(){
      if(this.index + 1 < this.images.length)
      this.index++
    },
  },
  created: function(){
    // 
  }
}
</script>
