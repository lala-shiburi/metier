<template>
<!-- Footer -->
<footer class="page-footer font-small indigo">

    <!-- Footer Links -->
    <div class="container">

      <!-- Grid row-->
      <div class="row text-center d-flex justify-content-center pt-5 mb-3">

        <!-- Grid column -->
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="#!">About us</a>
          </h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="#!">Products</a>
          </h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="#!">Awards</a>
          </h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="http://docs.jobseed.net/" target="technical-documentation">
               Documentation
            </a>
          </h6>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 mb-3">
          <h6 class="text-uppercase font-weight-bold">
            <a href="#!">Contact</a>
          </h6>
        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->
      <hr class="rgba-white-light" style="margin: 0 15%;">

      <!-- Grid row-->
      <div class="row d-flex text-center justify-content-center mb-md-0 mb-4">

        <!-- Grid column -->
        <div class="col-md-8 col-12 mt-5">
          <p style="line-height: 1.7rem">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem
            aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur.</p>
        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->
      <hr class="clearfix d-md-none rgba-white-light" style="margin: 10% 15% 5%;">

      <!-- Grid row-->
      <div class="row pb-3">

        <!-- Grid column -->
        <div class="col-md-12">

          <div class="mb-5 flex-center">

            <!-- Facebook -->
            <a class="fb-ic">
              <i class="fa fa-facebook fa-lg white-text mr-4"> </i>
            </a>
            <!-- Twitter -->
            <a class="tw-ic">
              <i class="fa fa-twitter fa-lg white-text mr-4"> </i>
            </a>
            <!-- Google +-->
            <a class="gplus-ic">
              <i class="fa fa-google-plus fa-lg white-text mr-4"> </i>
            </a>
            <!--Linkedin -->
            <a class="li-ic">
              <i class="fa fa-linkedin fa-lg white-text mr-4"> </i>
            </a>
            <!--Instagram-->
            <a class="ins-ic">
              <i class="fa fa-instagram fa-lg white-text mr-4"> </i>
            </a>
            <!--Pinterest-->
            <a class="pin-ic">
              <i class="fa fa-pinterest fa-lg white-text"> </i>
            </a>

          </div>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row-->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2018 Copyright:
      <a href="https://mdbootstrap.com/education/bootstrap/"> MDBootstrap.com</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
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

