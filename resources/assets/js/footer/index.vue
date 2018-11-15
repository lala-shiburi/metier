<template>
  <footer>
    <div class="container">
      <br>
      <p class="text-center">
        <ul class="list-unstyled">
          <li>
            <router-link :to="{ name: 'contact-us' }">
              Contact Us
            </router-link>
          </li>
          <li>
            <a href="https://www.facebook.com/Jobseed-473898096451976/" target="jobseed-on-facebook">
              Follow Us On Facebook
            </a>
          </li>
          <li>
            <a href="http://docs.jobseed.net/" target="technical-documentation">
              Technical Documentation
            </a>
          </li>
        </ul>
      </p>
      <p>
        <!-- <ul class="social_footer_ul">
          <li>
            <a href="#">
              <i class="fa fa-facebook-f"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-linkedin"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-instagram"></i>
            </a>
          </li>
        </ul> -->
      </p>
      <p class="text-center">Copyright @ 2018
        <a href="https://nexseed.net/" target="nexseed-website">Nexseed</a>
      </p>
    </div>
  </footer>
</template>

<script>
import Navbar from '~/components/navbar/admin'
import Collapsible from '~/components/Collapsible'
import { mapGetters } from 'vuex'
export default {
  name: 'MainLayout',
  data: () => ({
    public_path: location.origin,
  }),
  components: {
    Navbar,
    Collapsible
  },
  computed: mapGetters({
    user: 'auth/user',
    companies: 'auth/companies'
  }),
  methods:{
    showSidebar(){
      if(!jQuery(this.$refs.sidebar).hasClass('visible')){
        jQuery(this.$refs.sidebar).addClass('visible')
        jQuery(this.$refs['main-layout']).addClass('sidebar-visible')
      }
      else{
        jQuery(this.$refs.sidebar).removeClass('visible')
        jQuery(this.$refs['main-layout']).removeClass('sidebar-visible')
      }
      // trigger all events that should be triggered when sidebar is showed or hidden
      // e.g application progress line
      setTimeout(triggerLayoutEvents, 400)
    },
    hideUserOption(){
      this.$refs.navigation.hideUserOption()
    },
    async refresh(){
      await this.$store.dispatch('auth/fetchManagedCompanies')
    }
  },
  async created(){
    // fetch user companies
    await this.$store.dispatch('auth/fetchManagedCompanies')
  },
  mounted(){
    if(jQuery(document).width() > 768){
      this.showSidebar();
    }
    var $this = this;
    jQuery('.sidebar-nav').click(function(){
      if(jQuery(document).width() <= 768){
        $this.showSidebar();
      }
    })

    jQuery(function() {
        //The passed argument has to be at least a empty object or a object with your desired options
        jQuery($this.$refs['sidebar-menu']).overlayScrollbars({ 
          className       : "os-theme-dark",
          scrollbars: {
            autoHide : "leave"
          }
        });
    });
  }
}

function triggerLayoutEvents(){
  for(var i=0; i < window.layout_events.length; i++){
    try{
      layout_events[i]()
    }catch(e){}
  }
}
</script>
<style lang="scss" scoped>
$sidebar_width:300px;
$transition:300ms ease all;
.sidebar{
  visibility: hidden;
  position: fixed;
  height: 100%;
  background: white;
  z-index: 10;
  width: $sidebar_width;
  left: -$sidebar_width;
  box-shadow:  2px 0px 6px -4px rgba(150,150,150,1);
  transition: $transition;
  overflow: auto;
  .sidebar-menu{
    position: absolute;
    bottom: 0px;
    left: 0px;
    right: 0px;
    top: 56px;
  }
  &.visible{
    visibility: visible;
    left: 0px;
  }
  .sub-links{
    .sub-link{
      display: block;
      color: #c7ced4;
      padding: 10px 15px;

      &.active{
        color: white;
      }

      &:hover{
        text-decoration: none;
        background: #767f88;
      }
    }
  }
}
.main-layout{
  position: fixed;
  height: 100%;
  overflow-y: scroll;
  right: 0px;
  left: 0px;
  transition: $transition;
  &.sidebar-visible{
    left: $sidebar_width;
  }
}

.transparent-cover{
  position: absolute;
  left: 0px;
  top: 0px;
  height: 100%;
  left: 0px;
  width: 100%;
}
.sidebar-backdrop{
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
  background: black;
  z-index: 1;
  opacity: 0;
  visibility: hidden;
  transition: 300ms ease all;
}
.v-small{
  display: none;
}


@media (max-width: 768px) {
  .v-small{
    display: block;
  }
  .sidebar{
    width: 100%;
    right: 100%;
    left: initial!important;
    padding-left: 25px;
  }
  .main-layout{
    width: 100%;
    right: initial!important;
    left: 0px;
  }
  .sidebar.visible{
    right: 25px;
    .menu{
      padding-left: 25px;
    }
    &+.sidebar-backdrop{
      visibility: visible;
      opacity: 0.75;
    }
  }
  .main-layout.sidebar-visible{
    left: 100%;
    transform: translateX(-25px);
  }
}
</style>

