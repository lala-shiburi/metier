<template>
  <div class="progress-line-container">
    <ul v-if="hiring_steps.length" class="progress-line" :class="application.status == 2 ? 'finished' : ''" ref="steps">
      <li class="step" :class="step.result ? ((application.status == 3) ? 'inactive' : 'active'): ''" data-toggle="tooltip" data-html="true" :title="'<b>'+step.name+'</b><p>'+(step.description ? step.description : '')+'</p>'" v-for="(step, index) in hiring_steps" v-bind:key="index">
        <div class="circle"></div>
      </li>
    </ul>
    <unick-loader v-else class="loader" />
  </div>
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
        jQuery(steps.children[i]).find('.line').remove()
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

        jQuery(this.$el).find('[data-toggle="tooltip"]').tooltip({
          trigger: 'hover'
        })
      }
    },
    async fetchApplication(){
      var $this = this
      this.hiring_steps=[];

      const { data } = await axios({
        method: 'get',
        url: '/api/application/fetch/hiring/step/results',
        params: { application_id : this.application.id },
      })
      
      this.mergeStepWithResult(data)
      this.getCurrentStep(data)
      Vue.nextTick(function () {
        layout_events.push(function(){
          $this.renderProgressLine()
        })
        setRenderEvent(function(){
          $this.renderProgressLine()
        })
      });
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
      var current_step = null;

      for(var i = 0; i < data.hiring_steps.length; i++){
        var result_found = this.getStepMatchedResult(data.hiring_steps[i], data.hiring_step_results);

        if(result_found){
          if(data.hiring_steps.length - 1 == i ){
            this.finished = true;
          }
          else{
            if(!this.getStepMatchedResult(data.hiring_steps[i], data.hiring_step_results)){
              current_step = data.hiring_steps[i]
              i = data.hiring_steps.length;
              this.finished = false;
            }
          }
        }
        else{
          current_step = data.hiring_steps[i]
          i = data.hiring_steps.length;
          this.finished = false;
        }
      }
      
      this.$emit('update', {'step':current_step, finished: this.finished});
    },
    getStepMatchedResult(step, hiring_step_results){
      var result_found;
      for(var x = 0; x <  hiring_step_results.length; x++){
        if(step.id == hiring_step_results[x].hiring_step_id){
          result_found = step;
        }
      }

      return result_found;
    }
  },
  mounted(){
    var $this = this
    if(this.application.id){
      this.fetchApplication()
    }
  },
  watch:{
    application(){
      this.fetchApplication();
    }
  }
}

function setRenderEvent(event){
  var rtime;
  var timeout = false;
  var delta = 200;
  jQuery(window).resize(function(){
    rtime = new Date();
    if (timeout === false) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
  })
  function resizeend() {
    if (new Date() - rtime < delta) {
      setTimeout(resizeend, delta);
    } else {
      timeout = false;
      event()
    }
  }
}
</script>
<style lang="scss" scoped>
.progress-line-container{
  position: relative;
  min-height: 50px;
  .loader{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
  }
}
</style>

