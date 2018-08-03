<template>
  <div class="company-card">
    <div class="col-md-4 col-sm-6 company-photo">
      <div class="photo-preview-container">
        <div class="scaffold-div">
          <img src="http://localhost:8000/images/bg-img.png" class="bg-holder"> 
          <img :src="company.photo" class="absolute-center">
        </div>
      </div>
      <div class="buttons">
        <i class="fa fa-bookmark-o" ref="bookmark" aria-hidden="true"></i>
      </div>
    </div>
    <div class="col-md-8 col-sm-6 company-details">
      <h5>
        <router-link :to="{ name: 'company.profile', params: { id: company.id} }">
          {{company.name}}
        </router-link>
      </h5>
      <div class="text-justify company-description">
        {{company.description}}
      </div>
      <div class="text-muted company-employees">
        1-50 employees
      </div>
      <div class="text-muted company-openings">
        3 openings
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CompanyCard',

  props: {
    company: {
      type: Object,
      required: true
    }
  },
  data : () =>({
    public_path: location.origin
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
<style lang="scss" scoped>
.company-card{
  display: flex;
  background: white;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
  border: 1px solid #e8eced;
  margin-bottom: 15px;
  .buttons{
    padding: 0px 10px;
  }
  & .company-photo{
    padding: 0px;
  }
  & .company-details{
    padding: 5px;
    padding-right: 10px;
    .company-description{
      font-size: 12px;
    }
    .company-employees{
      font-size: 12px
    }
    .company-openings{
      font-size: 12px;
    }
  }
}
</style>
