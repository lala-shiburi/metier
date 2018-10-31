<template>
  <div>
    <div class="h1 text-center">Coming Soon!</div>
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
  metaInfo () {
    return { title: "Openings" }
  },
}
</script>
