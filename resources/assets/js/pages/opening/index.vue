<template>
  <div class="row" style="background-color: #e5e5e5">
    <div class="col-md-12" id="opening-cover-fluid" v-if="opening">
      <div class="profile-tile-view">
        <div class="profile-cover" style="height: 300px;">
          <img class="absolute-center" :src="opening.company.cover">
        </div>
        <div class="row" style="margin-top: -10%; background-color: #e5e5e5;">
          <div class="col-md-6 offset-md-3">
            <card class="opening-card" v-if="opening" :opening="opening" :noApply="true">
              <div class="row">
                <div class="col-md-4 col-5">
                  <div class="photo-preview-container opening-photo">
                    <div class="scaffold-div">
                        <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                        <!-- <img class="absolute-center" :src="opening.picture"> -->
                        <img class="absolute-center" :src="public_path + '/images/opening-logo.png'">
                        <div class="company-name">
                          <!-- <ellipsis-text>
                            {{opening.company.name}}
                          </ellipsis-text> -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-8 col-7 text-white">
                  <div class="mt-4">
                    <h5 class="opening-index-title">
                      {{opening.title}}
                    </h5>
                    <ellipsis-text class="job-des job-des-add">
                      <span>
                        {{opening.company.address}}
                      </span>
                    </ellipsis-text>
                    <ellipsis-text class="job-des job-des-date" v-if="opening.salary_range">
                      <div>
                        Posted 2 day ago
                      </div>
                    </ellipsis-text>

                    <div style="margin-top:10px;margin-left: .5rem;" v-if="!noApply">

                      <router-link class="btn btn-primary" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
                        Apply
                      </router-link>

                      <router-link v-if="authorizeEdit" class="btn btn-success" :to="{ name: 'opening.edit', params: { id: opening.id} }">
                        Edit
                      </router-link>

                      <router-link class="btn btn-light" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
                        Bookmark
                      </router-link>

                    </div>
                    <div>
                      <slot />
                    </div>
                  </div>
                </div>
              </div>
            </card>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <card class="m-tb-10">
        <div>
          <h5>Description</h5>
          {{opening.details}}
          We are seeking an experienced engineer with a can-do attitude to hit ground running when they join our web
          development team. The successful applicant's primary role will be to build and maintain our Powerful
          ecommerce site.
        </div>
        <br>
      </card>
      <div class="row" v-if="opening">
        <div class="col-md-4">
          <card class="opening-card" title="Company">
            <div class="row">
              <div class="col-md-4">
                <div class="photo-preview-container opening-photo">
                  <div class="scaffold-div">
                    <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                    <img class="absolute-center" :src="opening.company.photo">
                    <div class="company-name">
                      <!-- <ellipsis-text>
                          {{opening.company.name}}
                      </ellipsis-text> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <h5>
                  <router-link :to="{ name: 'company.profile', params: { id: opening.company.id} }">
                    {{opening.company.name}}
                  </router-link>
                </h5>
                <ellipsis-text class="job-des" v-if="opening.company.employee_count">
                  <template slot="icon">
                    <img class="job-des-icon" :src="public_path+'/images/employees.png'" alt="">
                  </template>
                  {{opening.company.employee_count}}
                </ellipsis-text>
                <ellipsis-text class="job-des">
                  <template slot="icon">
                    <img class="job-des-icon" :src="public_path+'/images/location.png'" alt="">
                  </template>
                  {{opening.company.address}}
                </ellipsis-text>
              </div>
            </div>
          </card>
        </div>
        <div class="col-md-8">
          <card title="Skills Requirements">
            <div v-if="opening.programming_languages.length > 0">
              <label>Programming Languages</label>
              <br>
              <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" :icon="lang.tag_name"></skill-icon>
            </div>
            <div v-if="opening.technologies.length > 0">
              <label>Frameworks</label>
              <br>
              <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" :icon="tech.tag_name"></skill-icon>
            </div>
            <div v-if="opening.programming_languages.length == 0 && opening.technologies.length == 0">
              <label> No Skill Requirements </label>
            </div>
          </card>
        </div>
      </div>
      <div class="container">
        <h4>Similar jobs</h4>
        <div class="row">
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    width="68px" alt="">
                </div>
                <div class="our-services-text">
                  <h4>Web designer</h4>
                  <p>Proin varius pellentesque nuncia tincidunt ante. In id lacus</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    width="68px" alt="">
                </div>
                <div class="our-services-text">
                  <h4>Ruby on Rails Developer</h4>
                  <p>Proin varius pellentesque nuncia tincidunt ante. In id lacus</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    width="68px" alt="">
                </div>
                <div class="our-services-text">
                  <h4>Backbone JS Developer</h4>
                  <p>Proin varius pellentesque nuncia tincidunt ante. In id lacus</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  export default {
    layout: 'profile',
    middleware: 'auth',

    data: () => ({
      public_path: location.origin,
      opening: null,
      authorizeEdit: false
    }),
    methods: {
      fetch_opening: async function () {
        const {
          data
        } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: {
            opening_id: this.$route.params.id
          }
        })
        this.opening = data.data;
        this.authorizeEdit = data.meta.authorizeEdit;
      }
    },
    mounted() {
      this.fetch_opening();
    },
    watch: {
      $route() {
        this.fetch_opening();
      }
    }
  }

</script>

<style scoped>
  .settings-card .card-body {
    padding: 0;
  }

  #opening-cover-fluid {
    padding: 0;
  }

  .card {
    border: none;
  }

  .opening-card {
    background: linear-gradient(135deg, #f02fc2 0%, #6094ea 100%);
    box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.3);
  }

  .photo-preview-container .scaffold-div {
    overflow: hidden;
    position: relative;
    -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    border: none;
  }

  .opening-card .opening-photo {
    background: transparent;
  }

  .opening-index-title {
    margin-left: .5rem;
  }

  .job-des-date {
    color: #b9b9b9;
    margin-top: 5px;
  }

  .job-des-add span {
    color: #fff;
    font-size: 1rem;
    font-weight: 300;
    margin: 0;
    padding: 0;
  }

  .mb-60 {
    margin-bottom: 60px;
  }

  .services-inner {
    border: 2px solid #c74bcd;
    margin-left: 35px;
    transition: .3s;
  }

  .our-services-img {
    float: left;
    margin-left: -36px;
    margin-right: 22px;
    margin-top: 28px;
  }

  .our-services-text {
    padding-right: 10px;
  }

  .our-services-text {
    overflow: hidden;
    padding: 28px 0 25px;
  }

  .our-services-text h4 {
    color: #222222;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 8px;
    padding-bottom: 10px;
    position: relative;
    text-transform: uppercase;
  }

  .our-services-text h4::before {
    background: #ec6d48 none repeat scroll 0 0;
    bottom: 0;
    content: "";
    height: 1px;
    position: absolute;
    width: 35px;
  }

  .our-services-wrapper:hover .services-inner {
    background: #fff none repeat scroll 0 0;
    border: 2px solid transparent;
    box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.2);
  }

  .our-services-text p {
    margin-bottom: 0;
  }

  p {
    font-size: 14px;
    font-weight: 400;
    line-height: 26px;
    color: #666;
    margin-bottom: 15px;
  }

</style>
