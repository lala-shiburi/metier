<template>
  <div class="row item-row">
    <div class="col-md-4 part">
      <div class="info-layout">
        <router-link class="n" :to="{ name: 'user.profile', params: { id: application.user.id }}">
          <iconized-photo size="medium-icon logo" :photo="application.user.photo"/>
        </router-link>
        <div>
          <div class="text-truncate n"> 
            <router-link class="n" :to="{ name: 'user.profile', params: { id: application.user.id }}">
              {{application.user.name}}
            </router-link>
          </div>
          <div class="text-truncate sub-text">
            <router-link :to="{ name: 'opening.profile', params: { id: application.opening.id }}">
              <img :src="application.opening.picture">
              {{application.opening.title}}
            </router-link>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 part progress-line-container" v-if="application.opening.hiring_step_group_id">
      <application-progress-line :application="application" ref="progress-line" />
    </div>
    <div class="col-md-8 pl-0 pt-2" v-else>
      <b>No hiring procedure selected.</b>
      <p>
        You can <router-link :to="{name: 'opening.edit', params: {id : application.opening.id}}">update</router-link> the Job Opening that this application application was designated to proceed.
      </p>
    </div>
    <div class="col-md-12 part">
      <div style="margin-bottom: 5px; display:inline-block;" v-if="application.status < 2 && application.opening.hiring_step_group_id">
        <button v-if="application.status == 1" type="button" class="btn btn-primary btn-sm" v-on:click="prepUpdate">
          Proceed To Next Step
        </button>
        <button v-if="application.status == 0" type="button" class="btn btn-success btn-sm" v-on:click="prepUpdate">
          Start Hiring Procedure
        </button>
      </div>
      <div class="pull-right">
        <button type="button" v-if="application.status > 0" @click="show" target="_blank" data-toggle="tooltip" data-html="true" title="View Results" class="btn btn-light btn-sm"><i class="fa fa-expand" aria-hidden="true"></i></button>
        <button type="button" v-if="application.status != 3" @click="prepDismiss" target="_blank" data-toggle="tooltip" data-html="true" title="Dismiss Application" class="btn btn-light btn-sm"><i class="fa fa-window-close" aria-hidden="true"></i></button>
        <a :href="application.user.resume_file" v-if="application.user.resume_file" target="_blank" data-toggle="tooltip" data-html="true" title="Download Resume" class="btn btn-light btn-sm"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</template>

<script>
import ApplicationProgressLine from './../../../components/hiring/application-progress-line'
import axios from 'axios'
import swal from 'sweetalert2'
export default {
  name: "ApplicationItem",
  components:{
    ApplicationProgressLine,
  },
  props:{
    application:{
      type: Object,
      required: true
    }
  },
  data : () =>({}),
  methods: {
    prepUpdate(){
      this.$emit('prepUpdate', this.application);
    },
    show(){
      this.$emit('show', this.application);
    },
    refresh(){
      this.$refs['progress-line'].fetchApplication()
    },
    async prepDismiss(){
      swal({
        title: 'Are you sure?',
        text: "This application will be placed in the Inactive Applications Tab",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
          axios({
            url: '/api/application/update/dismiss',
            method: 'patch',
            params:{application_id:this.application.id}
          }).then( ({data}) => {
            if(data.status == 'success'){
              this.$emit('remove', this.application)
              swal(
                'Application Dismissed',
                'Application is now on the Inactive Applications Tab.',
                'success'
              )
            }
          });
        }
      });
    }
  },
  mounted(){
    jQuery(this.$el).find('[data-toggle="tooltip"]').tooltip({
      trigger: 'hover'
    })
  }
}
</script>
