<template>
  <div class="main-layout">
    <navbar/>

    <div class="container-fluid">
      <child/>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'

export default {
  name: 'ProfileLayout',

  components: {
    Navbar
  }
}
</script>
<style>
  .main-layout{
    overflow: hidden;    
  }
</style>

