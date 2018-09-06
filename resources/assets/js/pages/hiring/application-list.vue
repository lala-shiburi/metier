<template>
  <div class="simple-card">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" data-toggle="tab" href="#active-application" role="tab" aria-controls="nav-home" aria-selected="true">Active Applications</a>
        <a class="nav-item nav-link" data-toggle="tab" href="#inactive-application" role="tab" aria-controls="nav-profile" aria-selected="false">Inactive Applications</a>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="active-application" role="tabpanel" aria-labelledby="nav-home-tab">
        <active-applications/>
      </div>
      <div class="tab-pane fade show" id="inactive-application" role="tabpanel" aria-labelledby="nav-home-tab">
        <!--  -->
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ActiveApplications from './application-list-components/active-applications';

export default {
  middleware: 'auth',
  components: {
    ActiveApplications
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
    // 
  },
  created: function(){
    this.company_id = this.$route.params.id;
    jQuery(this.$el).find('[data-toggle="tooltip"]').tooltip();
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
