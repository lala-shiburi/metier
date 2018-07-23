const path = require('path')
const mix = require('laravel-mix')
const VueLoaderPlugin = require('vue-loader/lib/plugin')
// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

mix
  .js(['resources/assets/js/app.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'resources/assets/js/paper-kit.js',
    'node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'node_modules/nouislider/distribute/nouislider.js',
    'node_modules/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    'resources/assets/js/jquery-ui-1.12.1.custom.min.js'], 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')

  .sourceMaps()
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'popper.js',
    'vue-i18n',
    'vue-meta',
    'js-cookie',
    'bootstrap',
    'moment',
    'vue-router',
    'sweetalert2',
    'vuex-router-sync',
    '@fortawesome/fontawesome',
    '@fortawesome/vue-fontawesome'
  ])
}

mix.webpackConfig({
  plugins: [
    // make sure to include the plugin!
    new VueLoaderPlugin()
  ],
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/assets/js')
    }
  },
  output: {
    chunkFilename: 'js/[name].[chunkhash].js',
    publicPath: mix.config.hmr ? '//localhost:8080' : '/'
  }
})
