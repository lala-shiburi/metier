<template>
  <form @submit.prevent="search">
    <div class="search-box">
      <i class="fa fa-search" aria-hidden="true" style="
        font-size: 30px;
        vertical-align: middle;
    "></i> 
      <div class="placeholder" v-if="!keyword">
        Find your dream Job
      </div>
      <input type="text" v-model="keyword">
    </div>
  </form>
</template>

<script>
export default {
  data : () =>({
    keyword: null,
  }),
  methods: {
    search(){
      if(this.keyword)
      this.$router.push({ name: 'opening.search', params: {keyword: this.keyword} })
    }
  },
}
</script>
<style lang="scss" scoped>
.search-box{
  position: relative;
  border-bottom: 2px solid #e4e4e4;
  border-radius: 10px;
  background: beige;
  .fa-search{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
  }
  .placeholder{
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 45px;
  }
  input[type=text]{
    position: relative;
    padding: 10px;
    border: none;
    display: block;
    width: 100%;
    left: 0px;
    top: 0px;
    height: 50px;
    border: none;
    background: transparent;
    outline: none;
    padding-left: 45px;
  }
}
</style>

