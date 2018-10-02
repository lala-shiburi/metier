<template>
    <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select Skill Filter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <skill-selector ref="skill-selector" :form="form">
                <div class="border-top pt-3">
                  <button class="btn btn-primary" @click="filter">Filter</button>
                </div>
              </skill-selector>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
import SkillSelector from './../../../components/SkillSelector'
import Form from 'vform'

export default {
  components: {
    SkillSelector
  },
  props: {
    form: {
      type: Object,
      required: true
    }
  },
  data : () =>({
    programming_languages: window.config.programming_languages,
    technologies: window.config.technologies,
  }),
  methods: {
    show(techs, langs){
      jQuery(this.$refs.modal).modal('show')
      this.$refs['skill-selector'].updateTechnologies(techs);
      this.$refs['skill-selector'].updateProgrammingLanguages(langs)
    },
    filter(){
      jQuery(this.$refs.modal).modal('hide')
      this.$emit('update', {
        technologies: this.getMatchTechnologies(),
        programming_languages: this.getMatchProgrammingLanguage()
      })
    },
    getMatchProgrammingLanguage(){
      var result = [];
      for(var i = 0; i < this.form.skills.programming_languages.length; i++){
        for(var x = 0; x < this.programming_languages.length; x++){
          if(this.form.skills.programming_languages[i] == this.programming_languages[x].id){
            result.push(this.programming_languages[x]);
            x == this.programming_languages.length
          }
        }
      }
      return result;
    },
    getMatchTechnologies(){
      var result = [];
      for(var i = 0; i < this.form.skills.technologies.length; i++){
        for(var x = 0; x < this.technologies.length; x++){
          if(this.form.skills.technologies[i] == this.technologies[x].id){
            result.push(this.technologies[x]);
            x == this.technologies.length
          }
        }
      }
      return result;
    }
  },
  mounted(){
    // 
  }
}
</script>
