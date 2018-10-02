<template>
  <div>
    <div class="text-center simple-card">
      <div class="card-body">
        <div v-if="loaded" class="h1">{{count}}</div>
        <unick-loader v-else class="loader" />

        <p class="card-text">Openings</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: 'OpeningCount',
  data : () =>({
    count: 0,
    loaded: false
  }),
  methods: {
    async fetchCount(){
       const {data} = await axios({
         url: '/api/reporting/recruiter/opening/count',
         method: 'get',
       })

       this.count = data.count
       this.loaded = true
    }
  },
  created(){
    this.fetchCount();
  }
}
</script>
<style lang="scss" scoped></style>