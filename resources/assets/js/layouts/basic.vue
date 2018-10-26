<template>
  <div>
    <child/>
    <unick-footer class="footer"/>
  </div>
</template>

<script>
import UnickFooter from '~/footer/index'
export default {
  name: 'BasicLayout',
  components: {
    UnickFooter
  }
}
</script>
