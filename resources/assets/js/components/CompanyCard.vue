<template>
  <card class="opening-card" :title="title">
    <div class="row">
      <div class="col-md-4">
        <div class="photo-preview-container opening-photo">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="company.photo">
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
          <router-link :to="{ name: 'company.profile', params: { id: company.id} }">
            {{company.name}}
          </router-link>
          </h5>
        <ellipsis-text class="job-des" v-if="company.employee_count">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/employees.png'" alt="">
          </template>
          {{company.employee_count}}
        </ellipsis-text>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/location.png'" alt="">
          </template>
          {{company.address}}
        </ellipsis-text>
      </div>
    </div>
  </card>
</template>

<script>
export default {
  name: 'CompanyCard',

  props: {
    company: {
      type: Object,
      required: true
    },
    title: {
      type: String,
      default: null
    }
  },
  data : () =>({
    public_path: location.origin
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
