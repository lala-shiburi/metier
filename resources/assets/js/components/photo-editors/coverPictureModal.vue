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
      <vue-photo-editor ref="photo-editor" :resultImageDimension="{ width: 1125, height: 500 }"/>
      <div class="modal-footer">
        <button class="btn btn-success" @click="savePhoto">Save</button>
      </div>
    </div>
  </sidebar-popup>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import Form from 'vform'
import vuePhotoEditor from '~/components/vue-photo-editor'
import SidebarPopup from '~/components/SidebarPopup'
export default {
  name:'cover',
  components:{
    vuePhotoEditor,
    SidebarPopup
  },
  props:{
    // 
  },
  data : () =>({
    // 
  }),
  methods: {
    async update(photo_data){
      var form = new Form({
        photo_data: photo_data
      });

      this.$refs['photo-editor'].loading(true);

      const {data} = await form.patch('/api/userInfo/update/cover');
      this.$refs['photo-editor'].loading(false);
      this.$emit('update',data);
    },
    showPhotoEditor(){
      if(this.authorizeEdit())
      this.$refs['photo-editor'].show(this.user.cover_photo);
    },
    authorizeEdit(){
      return this.user.id == this.$store.getters['auth/user'].id
    },
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
  computed: {
  },
  mounted(){
    // 
  },
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
