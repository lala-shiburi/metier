<template>
  <div>
    <div class="row">
      <div class="col-md-4 col-lg-3">
        <application-count/>
        <followed-companies/>
      </div>
      <div class="col-md-8 col-lg-9">
        <recent-applications/>
      </div>
    </div>
  </div>
</template>

<script>
import {
ApplicationCount, 
FollowedCompanies,
RecentApplications
} from '~/components/reporting/applicant'
export default {
  middleware: 'auth',
  components: {
    ApplicationCount,
    FollowedCompanies,
    RecentApplications
    },
}
</script>
