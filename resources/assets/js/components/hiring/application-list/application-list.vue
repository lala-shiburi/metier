<template>
  <div>
    <div class="list-group list-group-flush">
      <current-user-application v-for="application in applications" v-bind:key="application.id" :application="application" />
    </div>
  </div>
</template>

<script>
import CurrentUserApplication from './items/current-user-application'
import axios from 'axios'
export default {
  name: 'ApplicationList',
  props:{
    applications: {
      type: Array,
      required: true
    }
  },
  data : () =>({}),
  components: {
    CurrentUserApplication
  }
}
</script>