<template>
  <div class="info-preview row">
    <div class="col-md-2 col-5">
      <div class="photo">
        <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
        <img class="absolute-center" :src="icons[icon].img">
      </div>
    </div>
    <div class="col-md-10 col-7">
      <div class="border-bottom">
        <h5 class="card-title">{{title}}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{subtitle}}</h6>
        <div>
          <slot/>
        </div>
      </div>
    </div>
    <div class="options">
      <slot name="options"/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InfoPreview',

  props: {
    size: { type: String, default: null },
    icon: { 
      type: String,
      required: true
    },
    title: { 
      type: String,
      required: true
    },
    subtitle: { 
      type: String,
      required: true
    },
  },

  data: () => ({
    public_path: location.origin,
    icons: {
      school: { img: window.config.public_location + "images/school.png"},
      company: { img: window.config.public_location + "images/company.png"},
    }
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    }
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })
  }
}
</script>
