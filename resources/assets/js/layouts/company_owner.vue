<template>
  <div>
    <div class="sidebar" ref="sidebar" @click="hideUserOption">
      <div class="text-center pt-2 pb-2 position-relative">
        <router-link :to="{ name: 'home' }">
          <img :src="public_path+'/images/logo_brand.png'" style="height: 40px;">
        </router-link>
        <div class="transparent-cover v-small" @click="showSidebar"></div>
      </div>
      <div class="sidebar-menu border-top" ref="sidebar-menu">
        <div class="menu border-bottom">
          <div class="p-2 bg-light"><small>Main Navigation</small></div>
          <div class="list-group list-group-flush">
            <collapsible>
              <template slot="toggle-content">
                Dashboard
              </template>
              <template slot="collapse-content">
                <router-link :to="{ name: 'dashboard.applicant' }" class="sub-link sidebar-nav" active-class="active">
                  <i class="fa fa-user-o" aria-hidden="true"></i> Applicant
                </router-link>
                <router-link :to="{ name: 'dashboard.recruiter' }" class="sub-link sidebar-nav" active-class="active">
                  <i class="fa fa-building-o" aria-hidden="true"></i> Recruiter
                </router-link>
              </template>
            </collapsible>
            <router-link :to="{ name: 'opening.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Openings
            </router-link>
            <router-link :to="{ name: 'company.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Companies
            </router-link>
            <router-link :to="{ name: 'user.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              People
            </router-link>
          </div>
          <div class="p-2 bg-light border-bottom"><small @click="refresh">User Business</small></div>
          <div class="p-3 text-center bg-light" v-if="companies">
            <router-link v-if="companies.length == 1" :to="{ name: 'opening.create', params: { company_id: companies[0].id } }" class="btn btn-primary">Create Opening</router-link>
            <div v-if="companies.length > 1" class="dropdown">
              <button type="button" class="btn btn-primary" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create Opening</button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <router-link :to="{ name: 'opening.create', params: { company_id: company.id } }" class="dropdown-item" v-for="company in companies" v-bind:key="company.id">For {{company.name}}</router-link>
              </div>
            </div>
          </div>
          <div class="list-group list-group-flush">
            <router-link :to="{ name: 'user.openings' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              User Openings
            </router-link>
            <router-link :to="{ name: 'user.companies' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              User Companies
            </router-link>
            <router-link :to="{ name: 'user.followed.companies' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Companies You Followed
            </router-link>
            <router-link :to="{ name: 'user.saved.openings' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Openings You Saved
            </router-link>
            <router-link :to="{ name: 'user.company.saved.user' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Users You Saved
            </router-link>
          </div>
        </div>
        <unick-footer class="bg-light pb-3"/>
      </div>
    </div>
    <div class="sidebar-backdrop" @click="showSidebar"></div>
    <div class="main-layout sidebar-scroll-cancelled" data-addScrollTopBehavior ref="main-layout">
      <navbar @toggle="showSidebar" ref="navigation"/>
      <div class="mt-4 m-3" @click="hideUserOption">
        <child/>
      </div>
    </div>
  </div>
</template>

<script>
import mixin from './mixin'
export default {
  mixins:[mixin]
}

function triggerLayoutEvents(){
  for(var i=0; i < window.layout_events.length; i++){
    try{
      layout_events[i]()
    }catch(e){}
  }
}
</script>

