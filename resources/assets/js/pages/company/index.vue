<template>
  <div class="row">
    <div class="col-md-12">
      <div class="profile-tile-view">
        <div class="profile-cover">
          <img class="absolute-center" :src="company.cover">
        </div>
        <div class="row">
          <div class="col-md-2 col-5">
            <div class="profile-photo">
              <div class="scaffold-div" style="background: #e5e5e5;">
                <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
                <img class="absolute-center" :src="company.photo">
              </div>
            </div>
          </div>
          <div class="col-md-10 col-7">
            <h3>{{company.name}}</h3>
            <!-- <label>Software Developer</label> -->
          </div>
        </div>
      </div>
      <card class="m-tb-10">
        <div>
          <h5>Description</h5>
          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
        </div>
        <br>
      </card>
      
      <div class="row">
        <div class="col-md-4">
          <card class="m-tb-10" title="Basic Info">
            <ul class="simple-list">
              <li>
                <ellipsis-text label="Email">
                  uelmarortega@gmail.com
                </ellipsis-text>
              </li>
              <li>
                <ellipsis-text label="Address">
                  Business Park Mabolo Cebu City Cebu
                </ellipsis-text>
                <ellipsis-text label="Contact #">
                  09123123212
                </ellipsis-text>
              </li>
            </ul>
          </card>
          <card class="m-tb-10" title="Photo">
            <photo-viewer>
              <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
              <img class="absolute-center" :src="public_path+'/images/register-background.png'">
              <img class="absolute-center" :src="public_path+'/images/bg-img.png'">
              <img class="absolute-center" :src="public_path+'/images/angular.png'">
              <img class="absolute-center" :src="public_path+'/images/register-background.png'">
              <img class="absolute-center" :src="public_path+'/images/register-background.png'">
            </photo-viewer>
          </card>
          <card class="m-tb-10" title="Website">
            <ul class="simple-list">
              <li>
                <ellipsis-text>
                  <a href="http://job-seed.com" target="blank">http://job-seed.com</a>
                </ellipsis-text>
              </li>
            </ul>
          </card>
        </div>
        <div class="col-md-8">
          <card class="m-tb-10" title="Skills">
            <div>
              <label>Programming Languages</label>
              <br>
              <skill-icon icon="php"></skill-icon>
              <skill-icon icon="ruby"></skill-icon>
              <skill-icon icon="go"></skill-icon>
            </div>
            <div>
              <label>Frameworks</label>
              <br>
              <skill-icon icon="angular"></skill-icon>
            </div>
          </card>
          <opening-card></opening-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  },
  data : () =>({
    public_path: location.origin,
    company_id: null,
    company: {}
  }),
  methods: {
    fetch_company: async function(){
      this.company_id = this.$route.params.id;
      const { data } = await axios({
          method: 'get',
          url: '/api/company/fetch',
          params: { company_id: this.company_id }
        })
      this.company = data.data;
      console.log(data);
    }
  },
  mounted(){
    this.fetch_company();
  }
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
