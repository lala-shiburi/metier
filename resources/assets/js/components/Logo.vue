<template>
  <div class="nexseed-icon bg-white">
    <img style="width: 100%" class="pl-2 pr-2" :class="showImage ? 'animate-opacity':''" @load="showImage = true" :src="public_path+'/images/logo_brand.png'">
  </div>
</template>

<script>
export default {
  name: 'Logo',
  data: () => ({
    public_path: location.origin,
    showImage: false
  })
}
</script>
<style lang="scss" scoped>
.nexseed-icon{
  display: inline-block;
  position: relative;
  padding-right: 20px;
  height: 35px;
  overflow:hidden;
  width: 150px;
  animation-name: nexseed-icon-animation;
  animation-duration: 1s;
  &::after{
    content: '';
    position: absolute;
    height: 100%;
    width: 10px;
    background:#1878a5;
    right: 0px;
    z-index: 1;
  }
  &::before{
    content: '';
    position: absolute;
    height: 100%;
    width: 10px;
    right: 10px;
    background:#feca18;
    z-index: 1;
  }
}

.animate-opacity{
  animation-name: opacity-animation;
  animation-duration: 1s;
}


@keyframes opacity-animation{
  from{
    opacity: 0;
  }
  to{
    opacity: 1;
  }
}
@keyframes nexseed-icon-animation{
  0%{
    width: 0px;
  }
  50%  {
    width: 170px;
  }
  100% {
    width: 150px;
  }
}
</style>

