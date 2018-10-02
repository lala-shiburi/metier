<template>
  <div class="list-group-item list-group-item-action">
    <div class="row">
      <div class="col-md-5">
        <iconized-photo size="medium-icon" :photo="application.opening.picture"></iconized-photo>
        <span class="d-inline-block align-top">
          <router-link class="h6" :to="{ name: 'opening.profile', params: { id: application.opening.id} }">
            {{application.opening.title}}
          </router-link>
          <br>
          <small>
            <router-link class="text-muted" :to="{ name: 'company.profile', params: { id: application.opening.company.id} }">
              {{application.opening.company.name}}
            </router-link>
          </small>
        </span>
      </div>
      <div class="col-md-7">
        <application-progress-line :application="application" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ApplicationProgressLine from '~/components/hiring/application-progress-line'
export default {
  name: 'CurrentUserApplication',
  components: {
    ApplicationProgressLine
  },
  props:{
    application:{
      type: Object,
      required: true,
    }
  },
  data : () =>({
    // 
  }),
  methods: {
    // 
  },
}
</script>
