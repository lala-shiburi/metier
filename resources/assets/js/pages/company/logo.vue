<template>
  <div>
    <div class="profile-photo">
      <div class="scaffold-div" v-on:click="showPhotoEditor" style="background: #e5e5e5;">
        <img class="bg-holder" :src="public_path+'/images/bg-img.png'">
        <img class="absolute-center" :src="company.photo">
      </div>
    </div>
    <vue-photo-editor title="Company Logo" ref="photo-editor" @update="updateLogo"/>
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
        this.$refs['photo-editor'].show(this.company.photo);
      }
    },
    async updateLogo(photo_data){
      var form =  new Form({
        photo_data:photo_data,
        company_id:this.company.id
      });
      this.$refs['photo-editor'].loading(true);

      const {data} = await form.patch('/api/company/update/photo');

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
