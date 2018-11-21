<template>
  <div class="card opening-card">
    <div class="photo-preview-container p-0">
      <div class="scaffold-div">
        <img class="bg-holder" :src="public_path+'/images/bg-cover.png'">
        <img class="absolute-center" :src="opening.company.cover">
        <div class="company-name">
          <!-- <ellipsis-text>
              {{opening.company.name}}
          </ellipsis-text> -->
        </div>
      </div>
    </div>
    <div class="ml-2 d-inline-block photo-preview-container opening-photo">
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
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h5 class="text-truncate">
            <router-link :to="{ name: 'opening.profile', params: { id: opening.id} }">
              {{opening.title}}
            </router-link>
          </h5>
          <div class="text-truncate mb-3">
            <router-link class="text-muted" :to="{ name: 'company.profile', params: { id: opening.company.id} }">
              <div class="company-logo">
                <div class="photo-preview-container">
                  <div class="scaffold-div">
                    <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                    <img class="absolute-center" :src="opening.company.photo">
                  </div>
                </div>
              </div>
              {{opening.company.name}}
            </router-link>
          </div>
          <ellipsis-text class="job-des" v-if="opening.salary_range">
            <template slot="icon">
              <div class="prop-icon bg-info">
                <i class="fa fa-usd" aria-hidden="true"></i>
              </div>
            </template>
            {{opening.salary_range}}
          </ellipsis-text>
          <ellipsis-text class="job-des" v-if="opening.experience">
            <template slot="icon">
              <div class="prop-icon bg-info">
                <i class="fa fa-usd" aria-hidden="true"></i>
              </div>
            </template>
            {{opening.experience}}
          </ellipsis-text>
          <ellipsis-text class="job-des" v-if="opening.programming_languages.length > 0 || opening.technologies.length > 0">
            <template slot="icon">
              <div class="prop-icon bg-info">
                <i class="fa fa-code" aria-hidden="true"></i>
              </div>
            </template>
            <span class="skills"> 
              <span>
                <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" size="x-small-icon" :icon="lang.tag_name"></skill-icon>
              </span>
              <span>
                <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" size="x-small-icon" :icon="tech.tag_name"></skill-icon>
              </span>
            </span>
          </ellipsis-text>
          <ellipsis-text class="job-des">
            <template slot="icon">
              <div class="prop-icon bg-info">
                <i class="fa fa-calendar-o" aria-hidden="true"></i>
              </div>
            </template>
            {{opening.posted_at}}
          </ellipsis-text>
          <div style="margin-top:10px;" v-if="!noApply">
            <router-link class="btn btn-sm btn-primary btn-block" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
              Apply
            </router-link>
            <template v-if="user">
              <button @click="saveOpening" v-if="opening.saved" class="btn btn-sm btn-outline-warning btn-block">
                Un-save
              </button>
              <button @click="saveOpening" v-else class="btn btn-sm btn-outline-secondary btn-block">
                Save
              </button>
            </template>
            <div v-if="opening.authorize_edit" class="dropdown btn-block">
              <button type="button" class="btn btn-sm btn-outline-info btn-block" data-toggle="dropdown">Edit</button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="javaScript:void(0)" @click="prepDelete"> Delete</a>
                <router-link class="dropdown-item" :to="{ name: 'opening.edit', params:{id:opening.id} }"> Edit </router-link>
              </div>
            </div>
          </div>
          <div>
            <slot/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2'
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  name: 'OpeningCard',
  computed: mapGetters({
    user: 'auth/user'
  }),
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
  data : () =>({
    public_path: location.origin
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    prepDelete(){
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
            params: {opening_id: this.opening.id},
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
    },
    async saveOpening(){
      var save = this.opening.saved == 1 ? 0 : 1
      this.opening.saved = save
      const {data} = await axios({
        method: 'patch',
        url: '/api/user/update/opening/save',
        params:{opening_id:this.opening.id, save: save}
      });
    }
  },
  mounted(){
    jQuery(this.$el).find('[data-toggle="tooltip"]').tooltip()
  }
}
</script>
<style lang="scss" scoped>
.opening-card{
  .options{
    // 

    .button{
      color: #828181;
    }

    .button:hover{
      color: #212529;
    }
  }

  .opening-photo{
    margin-top: -20px;
    max-width: 100px;
  }

  .job-des{
    margin-bottom: 5px;
  }

  .prop-icon{
    position: relative;
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    color: white;
    .fa{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translateX(-50%) translateY(-50%);
      font-size: 10px;
    }
  }
}
</style>

