<template>
  <div class="side-popup hidden" ref="popup">
    <div v-on:click="hide" class="side-background"></div>
    <div class="popup">
      <div class="top-right">
        <slot name="options"/>
      </div>
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SidebarPopup',

  props: {
    // 
  },
  data: () => ({
    // 
  }),
  methods: {
    show(){
      jQuery(this.$refs.popup).removeClass('hidden');
      jQuery('.sidebar-scroll-cancelled, body').css({overflow:'hidden'});
    },
    hide(){
      jQuery(this.$refs.popup).addClass('hidden');
      jQuery('.sidebar-scroll-cancelled, body').css({overflow:'auto'});
    }
  },
  mounted(){
    const $this = this;
    jQuery(document).keydown(function(ev){
      if(ev.which == 27){
        $this.hide();
      }
    })
  },
  beforeDestroy(){
    this.hide()
  }
}
</script>
<style lang="scss" scoped>
.top-right{
  position: absolute;
  top: 0px;
  right: 0px;
}
</style>
