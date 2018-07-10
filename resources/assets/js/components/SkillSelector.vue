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
            <li class="item d-i" v-on:click="selectItem(lang[0])" :class="lang[0]" v-for="(lang, index) in programming_languages" v-bind:key="index">
              <skill-icon :icon="lang[0]" size="x-small-icon"></skill-icon> {{lang[1]}}
              <div class="box-check">
                <i class="fa fa-check check" aria-hidden="true"></i>
              </div>
            </li>
          </ul>
          <div class="h">
            Technology
          </div>
          <ul class="items">
            <li class="item d-i" v-on:click="selectItem(tech[0])" :class="tech[0]" v-for="(tech, index) in technologies" v-bind:key="index">
              <skill-icon :icon="tech[0]" size="x-small-icon"></skill-icon> {{tech[1]}}
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
        <div class="selected-round-item d-i" v-on:click="unSelectItem(lang[0])" :class="lang[0]" v-for="(lang, index) in programming_languages" v-bind:key="index">
          <div class="close-bttn">
            <i class="fa fa-close"></i>
          </div>
          <skill-icon :icon="lang[0]" pos="left" size="medium-icon"></skill-icon>
        </div>
      </div>
      <div class="col-md-12">
        <div class="selected-round-item d-i" v-on:click="unSelectItem(tech[0])"  :class="tech[0]" v-for="(tech, index) in technologies" v-bind:key="index">
          <div class="close-bttn">
            <i class="fa fa-close"></i>
          </div>
          <skill-icon :icon="tech[0]" pos="left" size="medium-icon"></skill-icon>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkillSelector',

  props: {},

  data: () => ({
    programming_languages: window.config.programming_languages,
    technologies: window.config.technologies,
    skills: []
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    selectItem: function(item){
      this.skills.push(item);
      jQuery(this.$el).find('.d-i').each(function(){
        if(jQuery(this).hasClass(item))
        jQuery(this).addClass('active');
      });
    },
    unSelectItem: function(item){
      this.skills.splice(this.skills.indexOf(item),1);
      console.log(this.skills);
      jQuery(this.$el).find('.d-i').each(function(){
        if(jQuery(this).hasClass(item))
        jQuery(this).removeClass('active');
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
