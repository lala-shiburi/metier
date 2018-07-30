<template>
  <div class="side-popup hidden" ref="popup">
    <div v-on:click="hide" class="side-background"></div>
    <div class="popup">
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
    },
    hide(){
      jQuery(this.$refs.popup).addClass('hidden');
    }
  },
  mounted(){
    // 
  }
}
</script>
