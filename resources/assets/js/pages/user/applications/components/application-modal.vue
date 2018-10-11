<template>
  <sidebar-popup ref="modal">
    <h6 class="p-15 border-bottom">
      Your Application
    </h6>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <div v-if="application">
      <opening-card :noApply="true" class="m-auto" style="max-width: 300px;" :opening="application.opening"/>
      <br>
      <div class="p-3">
        <div class="text-muted text-center">Progress</div>
        <application-progress-line :application="application" ref="progress-line" />
      </div>
      <div style=" background: #f2f2f2; min-height: 300px; padding: 15px;">
        <div v-if="application.expected_salary">
          <b> Expected Salary </b>
          <br>
          <span v-html="application.expected_salary"></span>
        </div>
        <div>
          <b> Application Letter </b>
          <br>
          <span v-html="application.application_letter"></span>
        </div>
      </div>
    </div>
  </sidebar-popup>
</template>

<script>
import SidebarPopup from '~/components/SidebarPopup'
import ApplicationProgressLine from '~/components/hiring/application-progress-line'
export default {
  components:{
    SidebarPopup,
    ApplicationProgressLine
  },
  data : () =>({
    application: null,
  }),
  methods: {
    show(data){
      this.application = data;
      var $this = this
      Vue.nextTick(function () {
        $this.$refs['progress-line'].fetchApplication();
      })
      this.$refs.modal.show()
    },
    close(){
      this.$refs.modal.hide()
    }
  },
  mounted(){
    this.user = this.$store.getters['auth/user'];
  },
  computed :{}
}
</script>
