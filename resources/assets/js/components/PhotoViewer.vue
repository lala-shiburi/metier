<template>
  <div class="photo-previewer row">
    <div v-if="images.length > 0">
      <div class="col-12 photo-item photo-preview-container photo-item">
        <div class="scaffold-div" v-on:click="popup(0)">
          <img class="bg-holder" :src="public_path+'/images/default-opening.png'">
          <img class="absolute-center" :src="main_photo.src">
        </div>
      </div>
      <div class="col-12">
        <div class="row">
          <photo-frame v-if="index < 4 && index != 0" @click.native="popup(index)" :image="image.src" v-for="(image, index) in images" v-bind:key="index" class="col-4">
            <div class="over-photo" v-if="index == 3 && images.length > 4">
              <div class="background"></div>
              <div class="text">+ {{images.length-(index + 1)}}</div>
            </div>
          </photo-frame>
        </div>
      </div>
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
    images: {
      type: Array,
      required: true,
    }
  },
  data : () =>({
    public_path: location.origin,
  }),
  computed: {
    main_photo(){
      return this.images[0]
    }
  },
  methods: {
    upperCaseFirst: function(string){
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    popup: function(index){
      var photo_modal = new Photo_Modal({
        propsData: {
          currentIndex: index,
          images: this.images.map( p => p.src )
        }
      });
      photo_modal.$mount()
      jQuery(photo_modal.$el).css('z-index', 1000000)
      jQuery('body').append(photo_modal.$el)
    }
  },
}
</script>
