export default {
  methods: {
    displayPending(){
      this.$refs['application-modal'].fetch(0)
    },
    displayInProgress(){
      this.$refs['application-modal'].fetch(1)
    },
    displayFinished(){
      this.$refs['application-modal'].fetch(2)
    },
    displayInactive(){
      this.$refs['application-modal'].fetch(3)
    }
  }
}