<template>
  <div class="photo-previewer row">
    <div class="col-12 photo-item photo-preview-container photo-item">
      <div class="scaffold-div" v-on:click="popup(0)">
        <img class="bg-holder" :src="public_path+'/images/default-opening.png'">
        <img class="absolute-center" :src="public_path+'/images/Group 244.png'">
      </div>
    </div>
    <div class="col-12">
      <div class="row">
        <div v-if="index < 4 && index != 0" v-on:click="popup(index)" v-for="(image, index) in images" v-bind:key="index" class="col-4 photo-preview-container photo-item">
          <div class="scaffold-div">
            <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
            <img class="absolute-center" :src="image">
            <div class="over-photo" v-if="index == 3">
              <div class="background"></div>
              <div class="text">+ {{images.length-(index + 1)}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div ref="images" style="display:none;">
      <slot/>
    </div>
  </div>
</template>

<script>
import PhotoModal from '~/components/PhotoModal'
import Vue from 'vue'
var Photo_Modal = Vue.extend(PhotoModal)
export default {
  name: 'PhotoViewer',

  props: {
    // icon: { type: String, required: true },
    // size: { type: String, default: null },
  },
  data : () =>({
    public_path: location.origin,
    images: []
  }),
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    popup: function(index){
      console.log(index)
      var photo_modal = new Photo_Modal({
        propsData: {
          currentIndex: index,
          images: this.images
        }
      });
      photo_modal.$mount()
      jQuery('body').append(photo_modal.$el)
    }
  },
  mounted(){
    jQuery(function () {
      jQuery('[data-toggle="tooltip"]').tooltip()
    })

    if(this.$refs.images.children.length > 1){
      for(var i = 0; i < this.$refs.images.children.length; i++){
        this.images.push(this.$refs.images.children[i].src);
      }
    }
  }
}
</script>
