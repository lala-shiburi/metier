<template>
  <div class="dominant-label" :title="title">
    <div class="label">
      <slot name="icon"/>
      <span v-if="label">{{label}} :</span>&nbsp;
    </div>
    <div class="submissive">
      <div class="text text-ellipsis">
        <slot/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EllipsisText',
  data: ()=> ({
    title: ''
  }),
  props: {
    label: { type: String, default: null },
  },
  mounted() {
    this.title = this.$slots.default[0].text;
  }
}
</script>
