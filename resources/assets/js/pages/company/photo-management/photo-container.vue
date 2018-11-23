<template>
  <div class="photo-container">
    <img class="image-scaffold" :src="public_path+'/images/bg-img.png'">
    <unick-loader v-if="!photo" class="center"/>
    <div class="gray-scale-hover image-src">
      <transition name="fade">
        <img :style="'height:'+height+'; width:'+width" v-if="src" :src="src">
      </transition>
      <i @click="remove" class="center fa fa-times-circle fa-2x round-icon round-white"></i>
    </div>
  </div>
</template>

<script>
import PhotoUploader from '~/plugins/photo-uploader'
import swal from 'sweetalert2'
import axios from 'axios'

  export default {
    name: 'PhotoUploader',
    props: {
      file: {
        type: File,
      },
      company_id: {
        // required: true
      },
      photoObject: {
        type: Object,
        default: null
      },
      change_callback: {
        type: Function,
        default: null
      }
    },
    data: () => ({
      public_path: location.origin,
      height: null,
      width: null,
      photo: null,
      src: null
    }),
    methods: {
      async uploadFile(){
        var $this = this
        const data = await PhotoUploader.uploadPhoto(this.file, '/api/photo/upload/company', { company_id: this.company_id })
        this.setSrc(data.photo)
        this.photo = data.photo
      },
      remove(){
        swal({
          title: 'Are you sure?',
          text: '',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(async (result) => {
          if (result.value) {
            const {data} = await axios({
              url: '/api/photo/remove',
              method: 'delete',
              params: {
                photo_id: this.photo.id
              }
            })
            if(data.status == 'success'){
              this.$emit('remove', this.photo)
              jQuery(this.$el).parent().remove()
              this.change_callback()
            }
          }
        });
      },
      setSrc(photo){
        var image = new Image
        image.onload = () => {
          this.src = photo.src
          if(image.width > image.height){
            this.height = '100%'
          }
          else{
            this.width = '100%'
          }
        }
        image.src = photo.src
      }
    },
    mounted(){
      this.photo = this.photoObject
      if(this.photoObject){
        this.setSrc(this.photoObject)
      }

      if(!this.photo){
        this.uploadFile()
      }
    },
  }
</script>
<style lang="scss" scoped>
  .photo-container{
    margin-top: 15px;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
    background: #fbfbfb;
    .image-scaffold{
      width: 100%;
      visibility: hidden;
    }
    .image-src{
      height: 100%;
      width: 100%;
      img{
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        position: absolute;
      }
    }
    .center{
      display: block;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translateY(-50%) translateX(-50%);
    }
    .gray-scale-hover{
      img{
        transition: 200ms ease all;
      }
      & .fa-times-circle{
        display: none;
      }
      &:hover .fa-times-circle{
        display: block;
      }
      &:hover img{
        filter: grayscale(50%);
      }
    }
  }
</style>
