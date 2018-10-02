<template>
  <div>
    <div class="text-center simple-card">
      <div class="card-body">
        <div v-if="finished" class="h1">{{count}}</div>
        <unick-loader v-else class="loader" />

        <p class="card-text">Applications</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: 'ApplicationCount',
  data : () =>({
    public_path: location.origin,
    finished: false,
    count: 0,
  }),
  methods: {
    async fetch(){
      const {data} = await axios({
        url: '/api/reporting/applicant/application/count',
        method: 'get',
      })
      this.finished = true;
      this.count = data.count;
    }
  },
  created(){
    this.fetch();
  }
}
</script>

