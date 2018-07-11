<template>
  <div class="row">
    <div class="col-md-12">
      <company-search-table></company-search-table>
    </div>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
  metaInfo () {
    return { title: 'Company List' }
  },

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  },
  data : () =>({
    public_path: location.origin
  })
}
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
