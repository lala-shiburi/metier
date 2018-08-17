<template>
  <div>
    <div class="profile-cover">
      <img class="absolute-center" :src="user.cover_photo" v-on:click="showPhotoEditor">
    </div>
    <vue-photo-editor title="Profile Cover" ref="photo-editor" :resultImageDimension="{ width: 1125, height: 500 }" @update="update"></vue-photo-editor>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import Form from 'vform'
import vuePhotoEditor from 'unick-vue-photo-editor';

export default {
  name:'cover',
  components:{
    vuePhotoEditor
  },
  props:{
    user: {
      type: Object,
      required: true,
    },
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
    }
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
