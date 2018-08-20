<template>
  <div>
    <div class="profile-cover" v-on:click="showPhotoEditor">
      <img class="absolute-center" :src="company.cover">
    </div>
    <vue-photo-editor title="Company Cover" ref="photo-editor" :resultImageDimension="{ width: 1125, height: 500 }" @update="updateLogo"></vue-photo-editor>
  </div>
</template>

<script>
import Form from 'vform'
import vuePhotoEditor from 'unick-vue-photo-editor';

export default {
  name:'logo',
  components: {
    vuePhotoEditor
  },
  props: {
    company:{
      type: Object,
      required: true
    },
    authorizeEdit:{
      type: Boolean,
      default: false
    }
  },
  data : () =>({
    public_path: location.origin,
  }),
  methods: {
    showPhotoEditor(){
      if(this.authorizeEdit){
        this.$refs['photo-editor'].show(this.company.cover);
      }
    },
    async updateLogo(photo_data){
      var form =  new Form({
        photo_data:photo_data,
        company_id:this.company.id
      });

      this.$refs['photo-editor'].loading(true);

      const {data} = await form.patch('/api/company/update/cover');

      this.$refs['photo-editor'].loading(false);
      this.$emit('update', data);
    },
  },
  created: function(){},
  mounted(){}
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
