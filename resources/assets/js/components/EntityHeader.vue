<template>
  <div class="dominant-label" :title="title">
    <div class="label">
      <slot name="icon"/>
    </div>
    <div class="submissive">
      <div class="text">
        <slot name="text"/>
      </div>
    </div>
    <div class="label">
      <slot name="buttons"/>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EntityHeader',
  data: ()=> ({
    title: ''
  }),
  mounted() {
    // 
  }
}
</script>
