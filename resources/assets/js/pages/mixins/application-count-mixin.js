import { mapGetters } from 'vuex'
export default {
  computed: mapGetters({
    companies: 'auth/companies'
  }),
  methods: {
    displayPending(){
      this.showModalOrRedirect(0)
    },
    displayInProgress(){
      this.showModalOrRedirect(1)
    },
    displayFinished(){
      this.showModalOrRedirect(2)
    },
    displayInactive(){
      this.showModalOrRedirect(3)
    },
    showModalOrRedirect(status){
      if(this.companies.length > 1){
        this.$refs['application-modal'].fetch(status)
      }
      else{
        this.$refs['application-modal'].status = status
        this.$refs['application-modal'].redirectToApplications(this.companies[0].id)
      }
    }
  }
}