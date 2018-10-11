<template>
  <div>
      <form @submit.prevent="search" @keydown="searchForm.onKeydown($event)">
        <div class="input-group mb-3">
          <input type="text" class="form-control" v-model="searchForm.keyword" placeholder="Search">
          <div class="input-group-append">
            <v-button :loading="searchForm.busy" class="btn btn-outline-secondary" type="success">
              <i class="fa fa-search" aria-hidden="true"></i>
            </v-button>
          </div>
        </div>
        <div>
          <div class="mb-2" v-if="programming_languages.length || technologies.length">
            <span>
              <skill-icon v-for="(lang,index) in programming_languages" v-bind:key="index" :icon="lang.tag_name"/>
            </span>
            <span>
              <skill-icon v-for="(tech,index) in technologies" v-bind:key="index" :icon="tech.tag_name"/>
            </span>
          </div>
          <button @click="showSkillFilter" type="button" class="btn btn-light btn-sm">
            ADD SKILL FILTER
          </button>
        </div>
      </form>
    <skill-selector-modal @update="updateSkillFilter" :form="searchForm" ref="skill-selector-modal"/>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import SkillSelectorModal from './skill-selector-modal'

export default {
  components: {
    SkillSelectorModal
  },
  data : () =>({
    public_path: location.origin,
    provinces: window.config.provinces,
    searchForm: new Form({
      keyword: '',
      province: '',
      search_province: false,
      skills: {
        programming_languages: [],
        technologies: []
      }
    }),
    programming_languages:[],
    technologies:[],
  }),
  methods: {
    search: async function(){
      const { data } = await this.searchForm.post('/api/user/fetch/search')
      this.$emit('update', data.users)
    },
    showSkillFilter(){
      this.$refs['skill-selector-modal'].show(this.technologies,this.programming_languages);
    },
    updateSkillFilter(data){
      this.search()
      this.programming_languages = data.programming_languages
      this.technologies = data.technologies
    }
  },
  mounted(){
    this.search();
  }
}
</script>
