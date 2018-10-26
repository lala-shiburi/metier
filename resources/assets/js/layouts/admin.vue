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
            <router-link :to="{ name: 'opening.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Dashboard
            </router-link>
            <router-link :to="{ name: 'opening.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Users
            </router-link>
            <router-link :to="{ name: 'company.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Companies
            </router-link>
            <router-link :to="{ name: 'user.search' }" class="list-group-item list-group-item-action sidebar-nav" active-class="active">
              Openings
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
</script>

