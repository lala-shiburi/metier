<template>
  <ul class="progress-line" ref="steps">
    <slot name="steps"/>
  </ul>
</template>

<script>
export default {
  name: 'ProgressStep',

  data : () =>({
    public_path: location.origin
  }),
  methods: {
    renderProgressLine(){
      // remove lines
      jQuery(this.$el).find('.line').remove();
      
      var steps = this.$refs.steps;
      this.steps = steps.children;
      var width = jQuery(this.$refs.steps).width();
      var length_unit = (width / steps.children.length);
      for(var i = 0; i < steps.children.length; i++){
        if(i > 0)
        {
          var line = document.createElement('div');
          jQuery(line).addClass('line');
          jQuery(line).css({width: (width / (steps.children.length - 1))});
          jQuery(steps.children[i]).prepend(line);
          jQuery(steps.children[i]).css({ 
            left: ((length_unit * i) + ((length_unit / (steps.children.length - 1)) * (i) )),
          });
        }

        jQuery(steps.children[i]).css({ 'z-index' : steps.children.length - i });

      }
    }
  },
  mounted(){
    this.renderProgressLine();
  }
}
</script>
