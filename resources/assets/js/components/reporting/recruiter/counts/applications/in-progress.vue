<template>
  <div class="simple-card flex skyblue">
    <div class="logo">
      <i class="fa fa-exchange fa-2x" aria-hidden="true"></i>
    </div>
    <div class="content">
      <div class="p-1">
        <div class="text-truncate">In-progress Applications</div>
        <p class="font-weight-bold text-truncate">
          <span v-if="loaded">{{count}}</span>
          <unick-loader v-else class="loader" />
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {mixin} from './mixin'
import Vue from 'vue'
export default {
  mixins: [mixin],
  name: 'InProgressApplications',
  data : () =>({}),
  methods: {},
  created(){
    this.fetchCount(1)
  }
}
</script>
<style lang="scss" scoped>
.loader{
  transform: translateY(-15px) scale(0.5);
}
</style>