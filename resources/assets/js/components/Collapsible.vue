<template>
  <div>
    <button ref="toggle" data-toggle="collapse" href="#collapseExample" class="list-group-item list-group-item-action toggle">
      <slot name="toggle-content"/>
      <div class="toggle-indicator">
        <i class="fa fa-caret-down" aria-hidden="true"></i>
      </div>
    </button>
    <div class="bg-secondary sub-links collapse" id="collapseExample" ref="collapsible">
      <slot name="collapse-content"/>
      <br>
    </div>
  </div>
</template>

<script>
import Vue from 'vue'
export default {
  name: 'Collapsible',
  mounted(){
    var $this = this;
    Vue.nextTick(function () {
      // enable collapse manually
      jQuery($this.$refs.collapsible).collapse('hide');

      // search for active collapse if active then show collapsible
      Array.from($this.$refs.collapsible.children).forEach(element => {
        setTimeout(function(){
          if(jQuery(element).hasClass('active')){
            jQuery($this.$refs.collapsible).addClass('show')
            jQuery($this.$refs.toggle).addClass('open')
          }
        }, 200)
      });

      // collapse, uncollapse events
      jQuery($this.$refs.collapsible).on('show.bs.collapse', function(){
        jQuery($this.$refs.toggle).addClass('open')
      })
      jQuery($this.$refs.collapsible).on('hide.bs.collapse', function(){
        jQuery($this.$refs.toggle).removeClass('open')
      })
    })
  }
}
</script>
<style lang="scss" scoped>
.toggle{
  padding-right: 10px;
  .toggle-indicator{
    position: absolute;
    right: 10px;
    top: 10px;
    transition: 300ms ease all;
    transform: rotate(180deg);
  }
  &.open{
    .toggle-indicator{
      transform: rotate(0deg);
    }
  }
}
</style>
