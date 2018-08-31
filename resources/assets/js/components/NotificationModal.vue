<template>
  <div class="modal fade" ref="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Notifications</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <div class="list-group" v-if="notifications.length > 0">
                <router-link data-dismiss="modal" :to="returnNotificationRoute(notification)" v-for="(notification, index) in notifications" v-bind:key="index" class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{notification.title}}</h5>
                    <small>{{notification.submitted}}</small>
                  </div>
                  <div v-if="notification.type == 'application'">
                    <p class="mb-1">{{notification.applicant.name}}</p>
                    <small>{{notification.opening.title}}</small>
                    <footer class="blockquote-footer">{{notification.company.name}}</footer>
                  </div>
                  <div v-if="notification.type == 'new_opening'">
                    <p class="mb-1">{{notification.company.name}} posted a new opening</p>
                    <small>{{notification.opening.title}}</small>
                  </div>
                </router-link>
              </div>
              <div v-else>
                <p class="text-center text-muted"> Nothing to show </p>
              </div>
              <div class="clearfix"></div>
              <form @submit.prevent="fetchMore" class="text-center" v-if="!loaded_all">
                <br>
                <v-button :loading="loading" type="success">Load More</v-button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
  name: 'NotificationModal',
  computed: mapGetters({
    user: 'auth/user'
  }),
  data : () =>({
    notifications: [],
    oldest_notification:{},
    loading: false,
    loaded_all: false,
  }),
  methods: {
    async show(){
      jQuery(this.$refs.modal).modal('show');

      // don't trigger initial fetch if loaded already
      if(this.notifications.length == 0){
        this.loading = true;
        const {data} = await axios({
          method: 'get',
          url: '/api/notification/fetch',
        })

        this.loading = false;
        this.notifications = data.notifications
        this.oldest_notification = data.notifications[data.notifications.length - 1];
        this.loaded_all = !data.left_to_load;
      }
    },
    async fetchMore(){
      this.loading = true;
      const {data} = await axios({
        method: 'get',
        url: '/api/notification/fetch/more',
        params: { date : this.oldest_notification.created_at.date }
      });

      this.loading = false;
      this.notifications = this.notifications.concat(data.notifications)
      this.oldest_notification = data.notifications[data.notifications.length - 1];
      this.loaded_all = !data.left_to_load;
    },
    returnNotificationRoute(notification){
      switch(notification.type){
        case 'application':
        return { name: 'hiringApplication.application', params:{application_id: notification.application.id} };
        break;
        case 'new_opening':
        return { name: 'opening.profile', params:{id: notification.opening.id} }
        break;
      }
    }
  },
  created: function(){
    // 
  }
}
</script>
