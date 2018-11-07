<template>
  <div class="main-layout">
    <navbar/>

    <div class="container mt-4" style="min-height: 100vh;">
      <child/>
    </div>
    <unick-footer class="footer"/>
  </div>
</template>

<script>
import Navbar from '~/components/navbar/default'
import UnickFooter from '~/footer/index'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    UnickFooter
  }
}
</script>
