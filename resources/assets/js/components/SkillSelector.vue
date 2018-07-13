<template>
  <div class="row">
    <div class="col-md-3">
      <div class="skill-multi-select">
        <div class="header">
          Skills
        </div>
        <div class="item-list">
          <div class="h">
            Programming Language
          </div>
          <ul class="items">
            <li class="item d-i text-ellipsis" v-on:click="addLang(lang)" :class="lang.tag_name" v-for="(lang, index) in programming_languages" v-bind:key="index">
              <skill-icon :icon="lang.tag_name" size="x-small-icon"></skill-icon> {{lang.name}}
              <div class="box-check">
                <i class="fa fa-check check" aria-hidden="true"></i>
              </div>
            </li>
          </ul>
          <div class="h">
            Technology
          </div>
          <ul class="items">
            <li class="item d-i text-ellipsis" v-on:click="addTech(tech)" :class="tech.tag_name" v-for="(tech, index) in technologies" v-bind:key="index">
              <skill-icon :icon="tech.tag_name" size="x-small-icon"></skill-icon> {{tech.name}}
              <div class="box-check">
                <i class="fa fa-check check" aria-hidden="true"></i>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="col-md-12">
        <div class="selected-round-item d-i" :class="lang.tag_name" v-for="(lang, index) in programming_languages" v-bind:key="index">
          <div class="close-bttn" v-on:click="removeLang(lang)">
            <i class="fa fa-close"></i>
          </div>
          <skill-icon :icon="lang.tag_name" pos="left" size="medium-icon"></skill-icon>
        </div>
      </div>
      <div class="col-md-12">
        <div class="selected-round-item d-i" :class="tech.tag_name" v-for="(tech, index) in technologies" v-bind:key="index">
          <div class="close-bttn" v-on:click="removeTech(tech)">
            <i class="fa fa-close"></i>
          </div>
          <skill-icon :icon="tech.tag_name" pos="left" size="medium-icon"></skill-icon>
        </div>
      </div>
      <div class="col-md-12" v-if="form.skills.programming_languages.length == 0 && form.skills.technologies.length == 0">
        <div class="alert alert-light" role="alert">
          Select skills from skill sidebar.
        </div>
      </div>
      <slot/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkillSelector',

  props: {
    form: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    programming_languages: window.config.programming_languages,
    technologies: window.config.technologies,
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    addLang: function(item){
      if(this.form.skills.programming_languages.indexOf(item.id) >= 0){
        this.removeLang(item);
      }
      else
      {
        this.form.skills.programming_languages.push(item.id);
        jQuery(this.$el).find('.d-i').each(function(){
          if(jQuery(this).hasClass(item.tag_name))
          jQuery(this).addClass('active');
        });
      }
    },
    removeLang: function(item){
      this.form.skills.programming_languages.splice(this.form.skills.programming_languages.indexOf(item.id),1);
      jQuery(this.$el).find('.d-i').each(function(){
        if(jQuery(this).hasClass(item.tag_name))
        jQuery(this).removeClass('active');
      });
    },
    addTech: function(item){
      if(this.form.skills.technologies.indexOf(item.id) >= 0){
        this.removeTech(item);
      }
      else
      {
        this.form.skills.technologies.push(item.id);
        jQuery(this.$el).find('.d-i').each(function(){
          if(jQuery(this).hasClass(item.tag_name))
          jQuery(this).addClass('active');
        });
      }
    },
    removeTech: function(item){
      this.form.skills.technologies.splice(this.form.skills.technologies.indexOf(item.id),1);
      jQuery(this.$el).find('.d-i').each(function(){
        if(jQuery(this).hasClass(item.tag_name))
        jQuery(this).removeClass('active');
      });
    },
    updateProgrammingLanguages: function(array){
      this.form.skills.programming_languages = [];
      array.forEach(item => {
        this.addLang(item);
      });
    },
    updateTechnologies: function(array){
      this.form.skills.technologies = [];
      array.forEach(item => {
        this.addTech(item);
      });
    }
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
