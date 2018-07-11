<template>
  <div class="wizard" style="position:relative;">
    <card title="Create Opening">
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
export default {
  name: 'Wizard',

  props: {
    currentPanel: {
      type: Number,
      required: true
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
    }
  },
  mounted(){
    this.current_index = this.currentPanel;
    for(var i = 0; i < this.$refs.wizard.children.length; i++){
      this.panels.push(this.$refs.wizard.children[i]);
      if(i > 0)
      {
        jQuery(this.$refs.wizard.children[i]).hide();
      }
    }

    var steps = this.$refs.steps;
    this.steps = steps.children;
    var width = jQuery(this.$refs.steps).width();
    console.log(width);
    var length_unit = (width / steps.children.length);
    for(var i = 0; i < steps.children.length; i++){
      if(i > 0)
      {
        var line = document.createElement('div');
        jQuery(line).addClass('line');
        jQuery(line).css({width: length_unit * 2 * ((1 / steps.children.length) * (steps.children.length - 1))});
        jQuery(steps.children[i]).prepend(line);
        jQuery(steps.children[i]).css({ 
          left: ((length_unit * i) + ((length_unit / (steps.children.length - 1)) * (i) )),
        });
      }
      var text = document.createElement('span');
      jQuery(text).addClass('text');
      jQuery(text).html(jQuery(steps.children[i]).attr('name'));
      jQuery(steps.children[i]).append(text);

      jQuery(steps.children[i]).css({ 'z-index' : steps.children.length - i });

      this.show(0);
    }

    // remove error indecation when select changed
    jQuery(this.$el).find('select').change(function(){
      jQuery(this).removeClass('is-invalid');
      jQuery(this).closest('.invalid-feedback').remove();
    });
  }
}
</script>
