<template>
  <div class="row">
    <div class="col-md-12" v-if="opening">
      <div class="profile-tile-view">
        <div class="profile-cover" style="height: 300px;">
          <img class="absolute-center" :src="opening.company.cover">
        </div>
        <div class="p-15">
          <div class="d-inline-block align-top">
            <img :src="opening.picture" width="200" class="img-thumbnail">
          </div>
          <div class="d-inline-block p-1 align-top">
            <div class="h4 padding-bottom">{{opening.title}}</div>
            <p>
              <router-link class="text-muted" :to="{ name: 'company.profile', params: { id: opening.company.id} }">
                {{opening.company.name}}
              </router-link>
            </p>
            <div class="mb-3">
              <div class="text-truncate" v-if="parseInt(opening.salary_range)">
                <span class="badge badge-secondary prop-w"><i class="fa fa-usd" aria-hidden="true"></i></span> {{opening.salary_range}}
              </div>
              <div class="text-truncate" v-if="opening.salary_range">
                <span class="badge badge-secondary"><i class="fa fa-code" aria-hidden="true"></i></span>
                <skill-icon v-for="(lang,index) in opening.programming_languages" v-bind:key="index" size="x-small-icon" :icon="lang.tag_name"/>
                <skill-icon v-for="(tech,index) in opening.technologies" v-bind:key="index" size="x-small-icon" :icon="tech.tag_name"/>
              </div>
            </div>
            <div>
              <router-link class="btn btn-primary" :to="{ name: 'hiringApplication.create', params: { opening_id: opening.id} }">
                Apply
              </router-link>
              <router-link v-if="authorizeEdit" class="btn btn-success" :to="{ name: 'opening.edit', params: { id: opening.id} }">
                Edit  
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <card class="m-tb-10">
        <div>
          <h5>Description</h5>
          <p v-html="opening.details"></p>
        </div>
        <br>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data : () =>({
    public_path: location.origin,
    opening: null,
    authorizeEdit: false
  }),
  metaInfo () {
    return { title: "Opening Details" }
  },
  methods: {
    fetch_opening: async function(){
      const { data } = await axios({
          method: 'get',
          url: '/api/opening/fetch',
          params: { opening_id: this.$route.params.id }
        }).catch(error => {
            this.$router.push({name:'404'})
        })
      this.opening = data.data;
      this.authorizeEdit = data.meta.authorizeEdit;
    }
  },
  mounted(){
    this.fetch_opening();
  },
  watch: {
    $route(){
      this.fetch_opening();
    }
  }
}
</script>
<style lang="scss" scoped>
.prop-w{
  width: 23px;
}
</style>
