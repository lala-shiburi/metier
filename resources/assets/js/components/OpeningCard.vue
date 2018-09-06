<template>
  <card class="opening-card">

    <header class="search-result-record-box__job_header">
    </header>
    <div class="row">
      <div class="col-lg-2">
        <img class="job-des-icon" :src="public_path+'/images/amazon.jpg'" alt="" style="max-width:100px;height: auto;">
      </div>
      <div class="col-lg-10 ">
        <h5>
          <router-link :to="{ name: 'opening.profile', params: { id: opening.id} }">
            {{opening.title}}
          </router-link>
        </h5>
        <div v-if="opening.authorize_edit" class="options dropdown">
          <i class="button fa-ellipsis-h fa" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="javaScript:void(0)" @click="prepDelete"> Delete</a>
            <router-link class="dropdown-item" :to="{ name: 'opening.edit', params:{id:opening.id} }"> Edit
            </router-link>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-5">
            <div class="photo-preview-container opening-photo">
              <div class="scaffold-div">
                <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                <img class="absolute-center" :src="opening.picture">
                <div class="company-name">
                      <!-- <ellipsis-text>
                      {{opening.company.name}}
                  </ellipsis-text> -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8 col-7">
            <h5>
              <router-link :to="{ name: 'opening.profile', params: { id: opening.id} }">
                {{opening.title}}
              </router-link>
            </h5>
            <ellipsis-text class="job-des">
              <template slot="icon">
                <img class="job-des-icon" :src="public_path+'/images/company.png'" alt="">
              </template>
              <router-link :to="{ name: 'company.profile', params: { id: opening.company.id} }">
                <div class="company-logo">
                  <div class="photo-preview-container">
                    <div class="scaffold-div">
                      <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                      <img class="absolute-center" :src="opening.company.photo">hell
                    </div>
                  </div>
                </div>
                {{opening.company.name}}
              </router-link>
            </ellipsis-text>
            <ellipsis-text class="job-des">
              <template slot="icon">
                <img class="job-des-icon" :src="public_path+'/images/opening-description.png'" alt="">
              </template>
              {{opening.details}}
            </ellipsis-text>
            <ellipsis-text class="job-des" v-if="opening.salary_range">
              <template slot="icon">
                <img class="job-des-icon" :src="public_path+'/images/salary.png'" alt="">
              </template>
              {{opening.salary_range}}
            </ellipsis-text>
            <ellipsis-text class="job-des" v-if="opening.programming_languages.length > 0 || opening.technologies.length > 0">
              <template slot="icon">
                <img class="job-des-icon" :src="public_path+'/images/code.png'" alt="">
              </template>
              <span class="skills">
                <span>
                  <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" size="x-small-icon"
                    :icon="lang.tag_name"></skill-icon>
                </span>
                <span>
                  <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" size="x-small-icon" :icon="tech.tag_name"></skill-icon>
                </span>
              </span>
            </ellipsis-text>
            <ellipsis-text class="job-des">
              <template slot="icon">
                <img class="job-des-icon" :src="public_path+'/images/calendar.png'" alt="">
              </template>
              {{opening.posted_at}}
            </ellipsis-text>
            <div style="margin-top:10px;" v-if="!noApply">
              <router-link class="btn btn-primary" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
                Apply
              </router-link>
            </div>
            <div>
              <slot />
            </div>
          </div>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
  import swal from 'sweetalert2'
  import axios from 'axios'
  export default {
    name: 'OpeningCard',

    props: {
      opening: {
        type: Object,
        required: true
      },
      noApply: {
        type: Boolean,
        default: false
      },
      editable: {
        type: Boolean,
        default: false
      }
    },
    data: () => ({
      public_path: location.origin
    }),
    methods: {
      upperCaseFirst: function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
      },
      prepDelete() {
        swal({
          title: 'Are you sure?',
          text: "There could be applicants to this opening.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            axios({
              method: 'delete',
              url: '/api/opening/delete/soft',
              params: {
                opening_id: this.opening.id
              },
            }).then(data => {
              this.$emit('delete', this.opening);
              swal(
                'Deleted!',
                'Step has been deleted.',
                'success'
              )
            })
          }
        })
      }
    },
    mounted() {
      jQuery(function () {
        jQuery('[data-toggle="tooltip"]').tooltip()
      })
    }
  }

</script>
<style lang="scss" scoped>
  .opening-card {
    .options {
      position: absolute;
      top: 0px;
      right: 5px;

      .button {
        color: #828181;
      }

      .button:hover {
        color: #212529;
      }
    }
  }

</style>
