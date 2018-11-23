<template>
  <sidebar-popup ref="popup" @hide="emitHide">
    <p class="h6 border-bottom p-15">Company Photos</p>
    <template slot="options">
      <button type="button" v-on:click="hide" class="btn btn-light">
        <i class="fa fa-close" aria-hidden="true"></i>
      </button>
    </template>
    <div class="p-15">
      <div style="display:none" ref="input-container">
        <!-- 
          Here is where file INPUT will be placed.
          It is dynamically rendered.
          Every time input is changed, it should be replaced with a new INPUT element to ensure input
          change event always triggers.
         -->
      </div>
      <center>
        <button type="button" class="btn btn-secondary" @click="showFileInput"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
      </center>
      <div class="row" ref="photo-list">
        <!-- 
          Here is where Photo Containers are rendered using Manual DOM manipulation.
          Manual DOM manipulation is need because of some inaccurate renders with Vue v-for directive
         -->
      </div>
    </div>
  </sidebar-popup>
</template>

<script>
import SidebarPopup from '~/components/SidebarPopup'
import photo_container from './photo-container'
import swal from 'sweetalert2'
import Vue from 'vue'
import axios from 'axios'
var PhotoContainer = Vue.extend(photo_container)

export default {
  name: 'PhotoUploader',
  components: {
    SidebarPopup,
  },

  props: {
    // 
  },
  data: () => ({
    photos: [],
    // used to emit update if any photo is removed or added
    photos_updated: false
  }),
  computed: {
    // 
  },
  methods: {
    show(){
      if(this.photos.length == 0){
        this.fetchCompanyPhotos()
      }
      this.$refs.popup.show()
    },
    hide(){
      this.$refs.popup.hide()
      this.emitHide()
    },
    emitHide(){
      if(this.photos_updated){
        this.photos_updated = false
        this.$emit('update')
      }
    },
    showFileInput(){
      jQuery(this.$refs['input-container']).find('input').trigger('click')
    },
    refreshInput(){
      jQuery(this.$refs['input-container']).html('<input type="file" style="display:none" multiple accept="image/x-png,image/gif,image/jpeg">')
      var $this = this
      jQuery(this.$refs['input-container']).find('input').change(async function(){
        if(this.files.length > 10){
          swal({
              type: 'error',
              title: 'Oops...',
              text: 'File number exceeded the acceptable quantity of 10.',
          })
        }
        else{
          $this.photos_updated = true
          for(var i = 0; i < this.files.length; i++){
            // to prevent render issues on v-for loop, we will render PhotoContainer independently
            // then after render successful
            // mount it using DOM manipulation with jQuery
            var component = new PhotoContainer({
              propsData:{
                file: this.files[i],
                company_id: $this.$route.params.id
              }
            })
            component.$mount()

            // Add needed container DOM
            var col = document.createElement('div')
            col.className = 'col-md-6'
            jQuery(col).append(component.$el)

            // prepend newly added DOM
            jQuery($this.$refs['photo-list']).prepend(col)
          }
        }
        $this.refreshInput()
      })
    },
    removePhoto(index){
      this.files.splice(index,1)
    },
    async fetchCompanyPhotos(){
      const { data } = await axios({
        url: '/api/photo/fetch/company',
        method: 'get',
        params: {company_id: this.$route.params.id}
      })
      this.photos = data.photos
      this.loadPhotos()
    },
    loadPhotos(){
      for(var i = 0; i < this.photos.length; i++){
        var component = new PhotoContainer({
          propsData:{
            photoObject: this.photos[i],
            upload: false,
            change_callback: this.changeCallback
          }
        })

        component.$mount()
        var col = document.createElement('div')
        col.className = 'col-md-6'
        jQuery(col).append(component.$el)
        jQuery(this.$refs['photo-list']).prepend(col)
      }
    },
    changeCallback(){
      this.photos_updated = true
    }
  },
  mounted(){
    this.refreshInput()
  }
}
</script>