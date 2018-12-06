<template>
  <div style="padding-bottom: 100px;">
    <div class="nav-head p-15">
      <logo/>
      <div class="links pull-right">
        <template v-if="authenticated">
          <router-link :to="{ name: 'home' }">
            {{ $t('home') }}
          </router-link>
        </template>
        <template v-else>
          <router-link :to="{ name: 'login' }">
            {{ $t('login') }}
          </router-link>
          |
          <router-link :to="{ name: 'register' }">
            {{ $t('register') }}
          </router-link>
        </template>
      </div>
    </div>
    <div  class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white">
      <div class="fullscreen-video-wrap">
        <video ref="video" :src="public_path + '/videos/fitradio.mp4'" muted class="absolute-center" autoplay="true" loop="true"></video>
        <div class="header-overlay"></div>
      </div>
      <div class="col-md-5">
        <search-box/>
        <br>
        <div class="title">
          Also, build your professional identity online and stay connected with opportunities.
          <router-link class="bg-white pl-2 pr-2 d-inline-block" :to="{ name: 'register' }">Create Account</router-link>
        </div>
      </div>
      <a href="/#openings" class="see-down">
        <i class="fa fa-angle-double-down icon" aria-hidden="true"></i>
      </a>
    </div>
    <div class="bg-white p-3">
      <div class="container text-center">
        <div>
          <skill-icon @click.native="setSkillSearch('programming_languages', lang)" v-for="(lang,index) in programming_languages" v-bind:key="index" :icon="lang.tag_name"/>
        </div>
        <div>
          <skill-icon @click.native="setSkillSearch('technologies', lang)" v-for="(lang,index) in technologies" v-bind:key="index" :icon="lang.tag_name"/>
        </div>
      </div>
    </div>
    <div class="container">
      <h4 class="mt-5"><a href="#openings" name="openings">#</a> Recent Openings</h4>
      <div class="mb-5">
        <router-link :to="{ name: 'opening.search' }" class="badge badge-primary">See all</router-link>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6" v-for="opening in openings" v-bind:key="opening.index">
          <opening-card :opening="opening"/>
        </div>
      </div>
    </div>
    <div class="container">
      <h4 class="mt-5"><a href="#openings" name="openings">#</a> Companies</h4>
      <div class="mb-5">
        <router-link :to="{ name: 'company.search' }" class="badge badge-primary">See all</router-link>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-4" v-for="(company, index) in companies" v-bind:key="index">
          <company-card :company="company"></company-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
import SearchBox from './components/search-box'
export default {
  layout: 'basic',
  middleware: 'guest',
  components: {SearchBox},

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    public_path: location.origin,
    openings: [],
    companies: [],
    programming_languages: window.config.programming_languages,
    technologies: window.config.technologies,
  }),
  methods: {
    async fetchRecentApplications(){
      const {data} = await axios({
        method: 'get',
        url: '/api/opening/fetch/recent',
      })

      this.openings = data.openings
    },
    async fetchMostPopularCompany(){
      const {data} = await axios({
        method: 'get',
        url: '/api/company/fetch/popular',
      })

      this.companies = data.companies
      console.log(data)
    },
    setSkillSearch(skills, lang){
      this.$router.push('/opening/search?'+skills+'='+lang.id)
    }
  },
  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  mounted(){
    this.fetchRecentApplications()
    this.fetchMostPopularCompany()
    this.$refs.video.onload = function(){
      this.play()
    }
  }
}
</script>

<style lang="scss" scoped>
.nav-head{
  position: absolute;
  width: 100%;
  z-index: 1000;
}
.links > a {
    color: white;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}

.fullscreen-video-wrap{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100vh;
	overflow: hidden;
}

.fullscreen-video-wrap video{
	min-width: 100%;
	min-height: 100%;
}

.header-overlay{
	height: 100vh;
	width: 100vw;
	position: absolute;
	top: 0;
	left: 0;
  background:linear-gradient(135deg, #5b247a 0%,#1bcedf 100%);
	opacity: 0.80;
}

.title {
  font-size: 15px;
  color: white;
}

.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;
}
.see-down{
  position: absolute;
  bottom: 10px;
  border-radius: 50%;
  height: 40px;
  width: 40px;
  background: #9e9e9e;
  .icon{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: white;
  }
}
</style>
