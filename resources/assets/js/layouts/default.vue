<template>
  <div class="main-layout">
    <navbar/>

    <div class="container mt-4">
      <child/>
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/navbar/default'

export default {
  name: 'MainLayout',

  components: {
    Navbar
  }
}
</script>
