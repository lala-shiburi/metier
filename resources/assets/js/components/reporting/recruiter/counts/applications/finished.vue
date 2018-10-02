<template>
  <div class="simple-card green flex">
    <div class="logo">
      <i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
    </div>
    <div class="content">
      <div class="p-1">
        <div class="text-truncate">Finished Applications</div>
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
  name: 'FinishedApplications',
  data : () =>({}),
  methods: {},
  created(){
    this.fetchCount(2)
  }
}
</script>
<style lang="scss" scoped>
.loader{
  transform: translateY(-15px) scale(0.5);
}
</style>