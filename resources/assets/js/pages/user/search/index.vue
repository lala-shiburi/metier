<template>
  <div class="row">
    <div class="col-lg-12">
      <search-bar @update="update"/>
      <br>
    </div>
    <div class="col-lg-12">
      <div class="list-group">
        <user-item :user="user" :companies="companies" v-for="user in users" v-bind:key="user.id"/>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import SearchBar from './search-bar'
import { mapGetters } from 'vuex'
import UserItem from './user-item'

export default {
  components: {
    SearchBar,
    UserItem
  },
  data : () =>({
    public_path: location.origin,
    users: [],
    provinces: window.config.provinces,
    companies: []
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  methods: {
    update: function(data){
      this.users = data;
    },
    async fetchCompanies(){
      const {data} = await axios({
        method: 'get',
        url: "/api/user/fetch/companies/managed"
      })

      this.companies = data.companies
    },
  },
  mounted(){
    this.fetchCompanies()
  }
}
</script>