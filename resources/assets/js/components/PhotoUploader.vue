<template>
  <sidebar-popup ref="popup">
    <p class="h6 border-bottom p-15">h6. Bootstrap heading</p>
    <div class="p-15">
      <input type="file" ref="input">
    </div>
  </sidebar-popup>
</template>

<script>
import SidebarPopup from './SidebarPopup'
import PhotoUploader from '~/plugins/photo-uploader'

export default {
  name: 'PhotoUploader',
  components: {
    SidebarPopup
  },

  props: {
    // 
  },
  data: () => ({
    // 
  }),
  methods: {
    show(){
      this.$refs.popup.show()
    },
    hide(){
      // 
    }
  },
  mounted(){
    jQuery(this.$refs.input).change(async function(){
      PhotoUploader.uploadPhoto(this.files[0])
    });
  }
}
</script>