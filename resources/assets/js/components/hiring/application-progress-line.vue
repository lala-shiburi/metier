<template>
  <ul class="progress-line" :class="finished ? 'finished' : ''" ref="steps">
    <li class="step" :class="step.result ? 'active': ''" v-for="(step, index) in hiring_steps" v-bind:key="index">
      <div class="circle" data-toggle="tooltip" data-html="true" :title="'<b>'+step.name+'</b><p>'+(step.description ? step.description : '')+'</p>'"></div>
    </li>
  </ul>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: 'ProgressStep',
  props:{
    application:{
      type: Object,
      required: true,
    },
  },
  data : () =>({
    public_path: location.origin,
    hiring_steps: [],
    finished: false,
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

        var line2 = document.createElement('div');
        var progress_line_width = (width / (steps.children.length - 1)) / 2;
        jQuery(line2).addClass('line line-half');
        jQuery(line2).css({
          width: progress_line_width,
          left: 0
        })
        jQuery(steps.children[i]).prepend(line2);


        jQuery(steps.children[i]).css({ 'z-index' : steps.children.length - i });

        jQuery('[data-toggle="tooltip"]').tooltip()
      }
    },
    async fetchApplication(){
      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/hiring/step/results',
        params: { application_id : this.application.id },
      })
      
      this.mergeStepWithResult(data)
      this.getCurrentStep(data)
    },
    mergeStepWithResult(data){
      var result = [];
      var $this = this;
      for(var i = 0; i < data.hiring_steps.length; i++){
        result.push(data.hiring_steps[i]);
        for(var x = 0; x < data.hiring_step_results.length; x++){
          if(data.hiring_step_results[x].hiring_step_id == data.hiring_steps[i].id){
            result[i].result = data.hiring_step_results[x]
          }
        }
      }
      this.hiring_steps = result;

      Vue.nextTick(function () {
        $this.renderProgressLine()
      });
    },
    getCurrentStep(data){
      this.finished = true;
      var step = null;
      var current_step = null;
      for(var i = 0; i < data.hiring_steps.length; i++){
        step = data.hiring_steps[i];
        var matched_result = null;
        for(var x = 0; x < data.hiring_step_results.length; x++){
          if(data.hiring_step_results[x].hiring_step_id == data.hiring_steps[i].id){
            matched_result = data.hiring_step_results[x]
          }
        }
        
        if(!matched_result){
          this.finished = false;
          current_step = step;
        }
      }
      this.$emit('update', {'step':current_step, finished: this.finished});
    }
  },
  mounted(){
    this.fetchApplication();
  }
}
</script>
