import Navbar from '~/components/navbar/admin'
import Collapsible from '~/components/Collapsible'
import { mapGetters } from 'vuex'
import UnickFooter from '~/footer/index'
export default {
  name: 'MainLayout',
  data: () => ({
    public_path: location.origin,
  }),
  components: {
    Navbar,
    Collapsible,
    UnickFooter
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