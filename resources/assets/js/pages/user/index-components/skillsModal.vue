<template>
  <div>
    <sidebar-popup ref="modal">
      <div class="border-bottom">
        <h6 class="p-15">
          Select your skills
        </h6>
      </div>
      <template slot="options">
        <button type="button" v-on:click="close" class="btn btn-light">
          <i class="fa fa-close" aria-hidden="true"></i>
        </button>
      </template>
      <form @submit.prevent="submitForm" @keydown="form.onKeydown($event)">
        <div v-show="loaded" class="modal-body">
          <skill-selector :selectOnly="true" ref="skillsSelector" :form="form"/>
          <br>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="close">Close</button>
            <v-button :loading="form.busy" type="success">Save</v-button>
          </div>
        </div>
        <center v-if="!loaded">
          <unick-loader class="loader" />
        </center>
      </form>
    </sidebar-popup>
  </div>
</template>

<script>
import SkillSelector from '~/components/SkillSelector'
import axios from 'axios'
import Form from 'vform'
import SidebarPopup from '~/components/SidebarPopup'
export default {
  name: 'SkillsModal',
  components:{
    SidebarPopup,
    SkillSelector
  },
  data: () => ({
    form: new Form({
      user_id: null,
      skills : {
        programming_languages : [],
        technologies: []
      }
    }),
    programmingLanguages: [],
    userTechnologies: [],
    loaded: false
  }),
  methods: {
    prepUpdate(){
      this.$refs.modal.show()
      this.$refs.skillsSelector.updateProgrammingLanguages(this.programmingLanguages);
      this.$refs.skillsSelector.updateTechnologies(this.userTechnologies);
    },
    close(){
      this.$refs['modal'].hide()
    },
    async submitForm(){
      const {data} = await this.form.post('/api/userInfo/update/skills');
      this.programmingLanguages = data.programming_languages
      this.userTechnologies = data.technologies
      this.$emit('update', {
        programmingLanguages: data.programming_languages,
        userTechnologies: data.technologies
      })
      this.close()
    },
    async fetchSkills(){
      var {data} = await axios({
        method: 'get',
        url: '/api/userInfo/fetch/programmingLanguages',
        params: { user_id: this.$route.params.id || this.$store.getters['auth/user'].id}
      })

      var programmingLanguages = data
      this.programmingLanguages = data

      var {data} = await axios({
        method: 'get',
        url: '/api/userInfo/fetch/userTechnologies',
        params: { user_id: this.$route.params.id || this.$store.getters['auth/user'].id}
      })

      var userTechnologies = data
      this.userTechnologies = data

      this.$emit('update', {
        programmingLanguages,
        userTechnologies
      })

      this.$refs.skillsSelector.updateProgrammingLanguages(this.programmingLanguages);
      this.$refs.skillsSelector.updateTechnologies(this.userTechnologies);

      this.loaded = true

      this.form.user_id = this.$store.getters['auth/user'].id
    }
  },
  mounted(){
    this.fetchSkills()
  },
  watch: {
    $route(){
      this.fetchSkills()
    }
  }
}
</script>
