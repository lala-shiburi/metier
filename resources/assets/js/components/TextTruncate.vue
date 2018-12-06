<template>
  <span>
    <span v-html="truncated_text"></span>
    <a v-if="text.split(' ').length > max_text" href="javascript:void(0)" @click="show_all = !show_all"> {{!show_all ? 'show all' : 'show less'}} </a>
  </span>
</template>

<script>
export default {
  name: 'TextTruncate',
  props: {
    text: {
      type: String,
      required: true
    },
    max_text: {
      type: Number,
      default: 20
    }
  },
  data: () => ({
    show_all: false
  }),
  computed: {
    truncated_text(){
      if(!this.show_all){
        let str = this.text.split(' ').slice(0, this.max_text)
        return str.join(' ')+'...'
      }
      else{
        return this.text
      }
    }
  },
}
</script>
<style lang="scss" scoped>
// 
</style>

