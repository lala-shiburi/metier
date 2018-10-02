<template>
  <div>
    <div class="profile-cover" v-on:click="showPhotoEditor">
      <img class="absolute-center" :src="company.cover">
    </div>
    <cover-picture-modal ref="photo-editor" @update="updateLogo"/>
  </div>
</template>

<script>
import Form from 'vform'
import CoverPictureModal from '~/components/photo-editors/coverPictureModal'
export default {
  name:'logo',
  components: {
    CoverPictureModal
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
        this.$refs['photo-editor'].prepUpdate(this.company.cover);
      }
    },
    async updateLogo(photo_data){
      var form =  new Form({
        photo_data:photo_data,
        company_id:this.company.id
      });

      const {data} = await form.patch('/api/company/update/cover');
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
