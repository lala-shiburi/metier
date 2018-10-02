<template>
  <sidebar-popup ref="modal">
    <h6 class="p-15">
      <i class="fa fa-bell-o" aria-hidden="true"></i>
      Notifications
    </h6>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <div class="list-group list-group-flush" v-if="notifications.length > 0">
      <router-link data-dismiss="modal" v-on:click.native="close" :to="returnNotificationRoute(notification)" v-for="(notification, index) in notifications" v-bind:key="index" class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
          <h5 class="mb-1">{{notification.title}}</h5>
          <small>{{notification.submitted}}</small>
        </div>
        <div v-if="notification.type == 'application'">
          <p class="mb-1">{{notification.applicant.name}}</p>
          <small v-if="notification.opening">{{notification.opening.title}}</small>
          <small v-else>Opening was deleted</small>
          <footer class="blockquote-footer">{{notification.company.name}}</footer>
        </div>
        <div v-if="notification.type == 'new_opening'">
          <p class="mb-1">{{notification.company.name}} posted a new opening</p>
          <small v-if="notification.opening">{{notification.opening.title}}</small>
          <small v-else>Opening was deleted</small>
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
    <br>
  </sidebar-popup>
</template>

<script>
import { mapGetters } from 'vuex'
import SidebarPopup from '~/components/SidebarPopup'
import axios from 'axios'
export default {
  name: 'NotificationModal',
  components: {
    SidebarPopup
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  data : () =>({
    notifications: [],
    loading: false,
    loaded_all: false,
  }),
  methods: {
    async show(){
      this.$refs.modal.show()

      // don't trigger initial fetch if loaded already
      if(this.notifications.length == 0){
        this.loading = true;
        const {data} = await axios({
          method: 'get',
          url: '/api/notification/fetch',
        })

        this.loading = false;
        this.notifications = data.notifications
        this.loaded_all = !data.left_to_load;
      }
    },
    async fetchMore(){
      this.loading = true;
      const {data} = await axios({
        method: 'get',
        url: '/api/notification/fetch/more',
        params: { date : this.notifications[this.notifications.length - 1].created_at.date }
      });

      this.loading = false;
      this.notifications = this.notifications.concat(data.notifications)
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
    },
    close(){
      this.$refs.modal.hide()
    }
  },
  created: function(){
    // 
  }
}
</script>
