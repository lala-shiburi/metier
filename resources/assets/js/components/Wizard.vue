<template>
  <div class="wizard" style="position:relative;">
    <card :title="title">
      <div style="padding: 25px; margin-bottom: 50px;">
        <div class="steps" ref="steps">
          <slot name="steps"/>
        </div>
      </div>
      <div ref="wizard" style="padding-top: 25px; border-top:1px solid #d5d5d5;">
        <slot name="panels"/>
      </div>
    </card>
  </div>
</template>

<script>
function wiz_actives(elms, index){
  for(var i = elms.length - 1; i >= 0; i--){
    if(i <= index)
    {
      jQuery(elms[i]).addClass("active");
    }
    else
    {
      jQuery(elms[i]).removeClass("active");
    }
  }
}
import Vue from 'vue'
export default {
  name: 'Wizard',

  props: {
    currentPanel: {
      type: Number,
      required: true
    },
    title: {
      type: String,
      default: 'Create Opening'
    }
  },
  data: () => ({
    panels: [],
    current_index: 0,
    interval: 200,
    steps: []
  }),
  methods: {
    show(index){
      if(index > this.current_index){
        jQuery(this.panels[this.current_index]).hide();
        jQuery(this.panels[index]).show();
      }
      else{
        jQuery(this.panels[this.current_index]).hide();
        jQuery(this.panels[index]).show();
      }
      wiz_actives(this.steps,index)
      this.current_index = index;
    },
    next(){
      if(this.current_index == this.panels.length-1)return false;
      jQuery(this.panels[this.current_index]).hide();
      jQuery(this.panels[this.current_index+1]).show();
      wiz_actives(this.steps,this.current_index+1)
      this.current_index += 1;
    },
    previews(){
      if(this.current_index == 0)return false;
      jQuery(this.panels[this.current_index]).hide();
      jQuery(this.panels[this.current_index-1]).show();
      wiz_actives(this.steps,this.current_index-1)
      this.current_index -= 1;
    },
    appendLines(){
      var steps = this.$refs.steps;
      var width = jQuery(this.$refs.steps).width();
      for(var i = 0; i < steps.children.length; i++){
        if(i > 0)
        {
          var line = document.createElement('div');
          jQuery(line).addClass('line');
          jQuery(steps.children[i]).prepend(line);
        }
        var text = document.createElement('span');
        jQuery(text).addClass('text');
        jQuery(text).html(jQuery(steps.children[i]).attr('name'));
        jQuery(steps.children[i]).append(text);

        jQuery(steps.children[i]).css({ 'z-index' : steps.children.length - i });

        this.renderLines();
      }
    },
    renderLines(){
      var $this = this
      Vue.nextTick(function () {
        $this.loadPanels();

        var steps = $this.$refs.steps;
        $this.steps = steps.children;
        var width = jQuery($this.$refs.steps).width();
        var length_unit = (width / steps.children.length);
        var line_width = (width / (steps.children.length-1))
        for(var i = 0; i < steps.children.length; i++){
          if(i > 0)
          {
            jQuery(steps.children[i]).find('.line').css({width: line_width});
            jQuery(steps.children[i]).css({ 
              left: ((length_unit * i) + ((length_unit / (steps.children.length - 1)) * (i) )),
            });
          }
          $this.show($this.current_index);
        }
      });
    },
    loadPanels(){
      this.panels = [];
      for(var i = 0; i < this.$refs.wizard.children.length; i++){
        this.panels.push(this.$refs.wizard.children[i]);
        if(i > 0)
        {
          jQuery(this.$refs.wizard.children[i]).hide();
        }
      }
    }
  },
  mounted(){
    this.current_index = this.currentPanel;

    this.appendLines()

    // remove error indecation when select changed
    jQuery(this.$el).find('select').change(function(){
      jQuery(this).removeClass('is-invalid');
      jQuery(this).closest('.invalid-feedback').remove();
    });

    windowResizeDetector.addEvent(this.renderLines)
    layout_events.push(this.renderLines)
    console.log(this)
  }
}
</script>
