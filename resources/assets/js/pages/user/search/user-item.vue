<template>
  <div class="list-group-item list-group-item-action">
    <button v-if="companies.length == 1" class="btn btn-light">
      <i class="fa fa-bookmark-o" aria-hidden="true"></i> Save
    </button>
    <div class="dropdown pull-right" v-if="companies.length > 1">
      <button class="btn" :class="user.companies_who_saved.length?'btn-outline-primary': 'btn-light'" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bookmark-o" aria-hidden="true"></i> Save
      </button>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        <a @click="save(user, company)" class="dropdown-item" :class="IsSavedByCompany(user,company) ? 'active' : ''" href="#" v-for="company in companies" v-bind:key="company.id">{{company.name}}</a>
      </div>
    </div>
    <router-link class="text-dark no-deco" :to="{ name: 'user.profile', params:{id:user.id} }">
      <img :src="user.photo" width="50px" class="rounded">
      <span class="d-inline-block align-top">
        <div><strong>{{user.name}}</strong></div>
        <div>
          <small>
            <template v-if="user.current_work_experience[0]">
              {{(user.current_work_experience[0].position)}} | {{user.current_work_experience[0].length}} |
            </template>
            <template v-else>
              No work experience |
            </template>
            <template>
              <skill-icon v-for="(lang,index) in user.programming_languages" v-bind:key="index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
            </template>
            <template>
              <skill-icon v-for="(lang,index) in user.user_technologies" v-bind:key="index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
            </template>
          </small>
        </div>
      </span>
    </router-link>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  props:{
    user: {
      type: Object,
      required: true
    },
    companies: {
      type: Array,
      required: true
    }
  },
  methods: {
    async save(user, company){
      
      var un_save = this.IsSavedByCompany(user, company);

      // mark or un-mark saved
      this.markSaved(user, company)

      const {data} = await axios({
        method:'post',
        url: "/api/company/save/user",
        params: {user_id : user.id, company_id: company.id, save: un_save ? 0 : 1}
      })
    },
    // checks if user is saved by the company
    IsSavedByCompany(user, company){
      return jQuery.grep(user.companies_who_saved, function(v, i){
        return v.company_id == company.id
      }).length > 0;
    },
    // remove companies who saved user
    unSaveUserFromCompany(company, user){
      var index = null;
      jQuery.grep(user.companies_who_saved, function(v, i){
        if(v.company_id == company.id){
          index = i
        }
      })
      user.companies_who_saved.splice(index, 1)
    },
    // mark or un-mark user as saved
    markSaved(user, company){
      if(this.IsSavedByCompany(user, company)){
        this.unSaveUserFromCompany(company, user)
      }
      else{
        user.companies_who_saved.push({company_id: company.id})
      }
    }
  },
}
</script>
<style scoped scss>
.no-deco{
  text-decoration:none;
}
</style>