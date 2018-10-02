<template>
  <div class="simple-card">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <router-link active-class="active" :to="{ name: tab.route }" v-for="tab in tabs" :key="tab.route" class="nav-item nav-link">
          {{tab.name}}
        </router-link>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="active-application" role="tabpanel" aria-labelledby="nav-home-tab">
        <transition name="fade" mode="out-in">
          <router-view/>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import SubmittedApplications from './application-list-components/submitted-applications';
import InProgressApplications from './application-list-components/in-progress-applications';

export default {
  middleware: 'auth',
  components: {
    SubmittedApplications,
    InProgressApplications
  },
  data : () =>({
    public_path: location.origin,
    company_id: null,
    company: {},
    applications: [],
  }),
  methods: {
    // 
  },
  computed:{
    tabs() {
      return [
        {
          name: 'Pending Applications',
          route: 'company.applicants.submitted'
        },
        {
          name: 'In Progress',
          route: 'company.applicants.in_progress'
        },
        {
          name: 'Finished',
          route: 'company.applicants.finished'
        },
        {
          name: 'Inactive',
          route: 'company.applicants.inactive'
        }
      ]
    }
  },
  created: function(){
    this.company_id = this.$route.params.id;
  },
}
</script>
