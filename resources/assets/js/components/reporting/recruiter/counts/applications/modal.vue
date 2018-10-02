<template>
  <sidebar-popup ref="modal">
    <h6 class="p-15 border-bottom">
      <span v-html="icon"></span>
      {{title}}
    </h6>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <div class="modal-body">
      <table v-if="loaded" class="table table-hover">
        <thead>
          <tr>
            <th style="border:none" scope="col">Application Count</th>
            <th style="border:none" scope="col">Company</th>
          </tr>
        </thead>
        <tbody>
          <tr @click="redirectToApplications(company.id)" v-for="company in companies" v-bind:key="company.id">
            <th>{{company.count}}</th>
            <td>
              {{company.name}}
            </td>
          </tr>
        </tbody>
      </table>
      <center v-else>
        <unick-loader class="loader" />
      </center>
    </div>
  </sidebar-popup>
</template>

<script>
import axios from 'axios'
import SidebarPopup from '~/components/SidebarPopup'
export default {
  name: 'ApplicationModal',
  components:{
    SidebarPopup
  },
  data : () =>({
    companies: [],
    status: 0,
    title: '',
    loaded: false,
    icon: ''
  }),
  methods: {
    async fetch(status){
      this.loaded = false
      this.$refs.modal.show()
      this.setTitle(status)
      const {data} = await axios({
        url: '/api/reporting/recruiter/application/count/per/company',
        method: 'get',
        params: {status:status}
      })

      this.loaded = true
      this.companies = data.companies
    },
    setTitle(status){
      this.status = status
      switch(status){
        case 0:
        this.title = 'Pending Applications'
        this.icon = '<i data-v-bc5483a4="" aria-hidden="true" class="fa fa-envelope-o" style="color:#f39c12;"></i>'
        break;
        case 1:
        this.title = 'In-progress Applications'
        this.icon = '<i data-v-bc5483a4="" aria-hidden="true" class="fa fa-exchange" style="color:#00c0ef;"></i>'
        break
        case 2:
        this.title = 'Finished Applications'
        this.icon = '<i data-v-bc5483a4="" aria-hidden="true" class="fa fa-check-circle-o" style="color:#00a65a;"></i>'
        break
        case 3:
        this.title = 'Inactive Applications'
        this.icon = '<i data-v-bc5483a4="" aria-hidden="true" class="fa fa-times-circle-o" style="color:#DD4A39;"></i>'
        break
      }
    },
    redirectToApplications(company_id){
      this.$refs.modal.hide()
      switch(this.status){
        case 0:
        this.$router.push({ name: 'company.applicants.submitted', params: { id: company_id} })
        break
        case 1:
        this.$router.push({ name: 'company.applicants.in_progress', params: { id: company_id} })
        break
        case 2:
        this.$router.push({ name: 'company.applicants.finished', params: { id: company_id} })
        break
        case 3:
        this.$router.push({ name: 'company.applicants.inactive', params: { id: company_id} })
        break
      }
    },
    close(){
      this.$refs.modal.hide()
    }
  },
}
</script>
<style lang="scss" scoped>
.header-part{
  padding: 15px;
  padding-right: 0px;
}
</style>