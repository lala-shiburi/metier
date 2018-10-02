<template>
  <sidebar-popup ref="modal">
    <div class="border-bottom">
      <h6 class="p-15">
        Edit Profile Picture
      </h6>
    </div>
    <template slot="options">
      <button type="button" v-on:click="close" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <div class="modal-body">
      <vue-photo-editor ref="photo-editor"/>
      <div class="modal-footer">
        <button class="btn btn-success" @click="savePhoto">Save</button>
      </div>
    </div>
  </sidebar-popup>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import vuePhotoEditor from '~/components/vue-photo-editor'
import SidebarPopup from '~/components/SidebarPopup'
export default {
  name: 'SkillsModal',
  components:{
    SidebarPopup,
    vuePhotoEditor
  },
  data: () => ({
    // 
  }),
  methods: {
    prepUpdate(photo_url){
      this.$refs.modal.show()
      this.$refs['photo-editor'].show(photo_url)
    },
    savePhoto(){
      var $this = this
      this.$refs['photo-editor'].saveImage(function(canvasDataURL){
        $this.$emit('update', canvasDataURL)
        $this.close()
      })
    },
    close(){
      this.$refs['modal'].hide()
    },
  },
}
</script>
