<template>
  <div>
    <div class="row">
      <div class="col-md-3" @click="displayPending">
        <pending-applications/>
      </div>
      <div class="col-md-3" @click="displayInProgress">
        <in-progress-applications/>
      </div>
      <div class="col-md-3" @click="displayFinished">
        <finished-applications/>
      </div>
      <div class="col-md-3" @click="displayInactive">
        <inactive-applications/>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3">
        <opening-count/>
        <company-logos/>
      </div>
      <div class="col-md-9">
        <application-count-line/>
      </div>
    </div>
    <application-modal ref="application-modal"/>
  </div>
</template>

<script>
import {OpeningCount, 
PendingApplications, 
InProgressApplications, 
FinishedApplications,
InactiveApplications,
CompanyLogos,
ApplicationModal,
ApplicationCountLine,
} from '~/components/reporting/recruiter'
import applicationCountMixin from '~/pages/mixins/application-count-mixin'
export default {
  middleware: 'auth',
  mixins: [applicationCountMixin],
  components: {
    OpeningCount,
    PendingApplications,
    InProgressApplications,
    FinishedApplications,
    InactiveApplications,
    CompanyLogos,
    ApplicationModal,
    ApplicationCountLine
    },
}
</script>
