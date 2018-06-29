<template>
  <card class="opening-card">
    <div class="row">
      <div class="col-md-3">
        <div class="photo-preview-container opening-photo">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
            <div class="company-logo">
              <div class="photo-preview-container">
                <div class="scaffold-div">
                  <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                  <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
                </div>
              </div>          
            </div>
            <div class="company-name">
              <ellipsis-text>
                  Nexseed Inc.
              </ellipsis-text>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <h5><a href="#">Web Developer</a></h5>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/opening-description.png'" alt="">
          </template>
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </ellipsis-text>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/salary.png'" alt="">
          </template>
          Php 20,000 ~ Php 30,000
        </ellipsis-text>
        <ellipsis-text class="job-des">
          <template slot="icon">
            <img class="job-des-icon" :src="public_path+'/images/code.png'" alt="">
          </template>
          <span> 
            <skill-icon size="x-small-icon" icon="php"></skill-icon>
            <skill-icon size="x-small-icon" icon="ruby"></skill-icon>
            <skill-icon size="x-small-icon" icon="angular"></skill-icon>
          </span>
        </ellipsis-text>
        <div style="margin-top:10px;">
          <v-button>
            Apply
          </v-button>
        </div>
      </div>
    </div>
  </card>
</template>

<script>
export default {
  name: 'OpeningCard',

  props: {
    // icon: { type: String, required: true },
    // size: { type: String, default: null },
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
