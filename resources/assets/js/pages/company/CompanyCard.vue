<template>
  <div class="company-card">
    <div class="col-md-4 col-sm-6 company-photo">
      <div class="photo-preview-container">
        <div class="scaffold-div">
          <img :src="public_path+'/images/bg-img.png'" class="bg-holder"> 
          <img :src="company.photo" class="absolute-center">
        </div>
      </div>
      <div class="buttons" v-if="user">
        <button v-if="company.current_user_followed" v-on:click="followCompany" type="button" class="btn btn-outline-warning btn-sm">Unfollow</button>
        <button v-else type="button" v-on:click="followCompany" class="btn btn-outline-secondary btn-sm">Follow</button>
      </div>
    </div>
    <div class="col-md-8 col-sm-6 company-details">
      <h5 class="text-truncate">
        <router-link :to="{ name: 'company.profile', params: { id: company.id} }">
          {{company.name}}
        </router-link>
      </h5>
      <div class="text-justify company-description">
        {{company.description}}
      </div>
      <div v-if="company.employee_count" class="text-muted company-employees text-truncate">
        {{company.employee_count}}
      </div>
      <div v-if="company.opening_count" class="text-muted company-openings">
        {{company.opening_count}} openings
      </div>
      <div class="text-muted company-openings text-truncate">
        Created : {{_company.created_at}}
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
export default {
  name: 'CompanyCard',
  computed: {
    ...mapGetters({
    user: 'auth/user',
    }),
    _company(){
      return {
        created_at: moment(this.company.created_at.date, "YYYY-MM-DD HH:mm:ss").subtract().calendar()
      }
    }
  },
  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data : () =>({
    public_path: location.origin,
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    async followCompany(){
      this.company.current_user_followed = this.company.current_user_followed == 1 ? 0 : 1
      const {data} = await axios({
        method: 'post',
        url: '/api/userInfo/add/follow/company',
        params:{company_id:this.company.id, follow: this.company.current_user_followed ? 1 : 0}
      });
    }
  },
}
</script>
<style lang="scss" scoped>
.company-card{
  display: flex;
  background: white;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  border: 1px solid #e8eced;
  margin-bottom: 15px;
  .buttons{
    padding: 5px;
    & .follow-btn{
      cursor: pointer;
      &.active{
        color: goldenrod;
      }
    }
  }
  & .company-photo{
    padding: 0px;
  }
  & .company-details{
    padding: 5px;
    padding-right: 10px;
    .company-description{
      font-size: 12px;
    }
    .company-employees{
      font-size: 12px
    }
    .company-openings{
      font-size: 12px;
    }
  }
}
</style>
