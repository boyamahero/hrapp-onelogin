// Configuration for your app
const
  path = require('path'),
  SymlinkWebpackPlugin = require('symlink-webpack-plugin'),
  CopyWebpackPlugin = require('copy-webpack-plugin')
const { env } = require('process')
const config = require('./onelogin.config')

module.exports = function (ctx) {
  return {
    preFetch: true,
    // app plugins (/src/plugins)
    plugins: [
      'keycloak',
      'AppExit',
      'i18n',
      'axios',
      'VueAuthImage',
      'VueLazyload'
    ],
    css: [
      'app.styl'
    ],
    extras: [
      ctx.theme.mat ? 'roboto-font' : null,
      'material-icons', // optional, you are not bound to it
      // 'ionicons',
      // 'mdi',
      'fontawesome'
    ],
    supportIE: false,
    build: {
      distDir: 'public',
      scopeHoisting: true,
      vueRouterMode: 'history',
      // vueCompiler: true,
      // gzip: true,
      // analyze: true,
      // extractCSS: false,
      extendWebpack (cfg) {
        cfg.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules|quasar)/
        })

        if (ctx.prod) {
          cfg.plugins.push(new CopyWebpackPlugin([{
            from: path.resolve(__dirname, 'public_files'),
            to: ''
          }]))

          cfg.plugins.push(new SymlinkWebpackPlugin({
            origin: '../storage/app/public',
            symlink: 'storage'
          }))
        }
      },
      env: ctx.dev
        ? { // so on dev we'll have
          api: JSON.stringify('/api'),
          SubDomain: JSON.stringify(config.development.sub_domain),
          ClientId: JSON.stringify(config.development.client_id),
          ClientSecret: JSON.stringify(config.development.client_secret),
        }
        : { // and on build (production):
          api: JSON.stringify("https://hrapp.egat.co.th/api"),
          SubDomain: JSON.stringify(config.production.sub_domain),
          ClientId: JSON.stringify(config.production.client_id),
          ClientSecret: JSON.stringify(config.production.client_secret),
      },
    },
    devServer: {
      // https: true,
      // port: 8080,
      watchOptions: { poll: true },
      open: false, // opens browser window automatically
      proxy: [{
        context: ['/api', '/storage'],
        target: 'http://127.0.0.1:8000' // laravel end-point
      }],
      historyApiFallback: true
    },
    // framework: 'all' --- includes everything; for dev only!
    framework: {
      components: [
        'QAlert',
        'QChip',
        'QDatetime',
        'QLayout',
        'QLayoutHeader',
        'QLayoutDrawer',
        'QPageContainer',
        'QPage',
        'QToolbar',
        'QToolbarTitle',
        'QTooltip',
        'QBtn',
        'QIcon',
        'QList',
        'QListHeader',
        'QItem',
        'QItemMain',
        'QItemTile',
        'QItemSide',
        'QItemSeparator',
        'QCard',
        'QCardTitle',
        'QCardMain',
        'QCardMedia',
        'QCardSeparator',
        'QCardActions',
        'QCarousel',
        'QCarouselSlide',
        'QCarouselControl',
        'QCollapsible',
        'QLayoutFooter',
        'QPopover',
        'QPagination',
        'QBreadcrumbs',
        'QBreadcrumbsEl',
        'QParallax',
        'QModal',
        'QRange',
        'QSearch',
        'QInfiniteScroll',
        'QSpinnerDots',
        'QSelect',
        'QToggle',
        'QInput'
      ],
      directives: [
        'Ripple',
        'CloseOverlay'
      ],
      // Quasar plugins
      plugins: [
        'Notify',
        'Dialog',
        'Loading'
      ],
      config: {
        cordova: {
          backButtonExit: false
        }
      }
      // iconSet: ctx.theme.mat ? 'material-icons' : 'ionicons'
      // i18n: 'de' // Quasar language
    },
    // animations: 'all' --- includes all animations
    animations: [],
    ssr: {
      pwa: false
    },
    pwa: {
      // workboxPluginMode: 'InjectManifest',
      // workboxOptions: {},
      manifest: {
        // name: 'Quasar App',
        // short_name: 'Quasar-PWA',
        // description: 'Best PWA App in town!',
        display: 'standalone',
        orientation: 'portrait',
        background_color: '#ffffff',
        theme_color: '#027be3',
        icons: [
          {
            'src': 'statics/icons/icon-128x128.png',
            'sizes': '128x128',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-192x192.png',
            'sizes': '192x192',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-256x256.png',
            'sizes': '256x256',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-384x384.png',
            'sizes': '384x384',
            'type': 'image/png'
          },
          {
            'src': 'statics/icons/icon-512x512.png',
            'sizes': '512x512',
            'type': 'image/png'
          }
        ]
      }
    },
    cordova: {
      // id: 'org.cordova.quasar.app'
    },
    electron: {
      // bundler: 'builder', // or 'packager'
      extendWebpack (cfg) {
        // do something with Electron process Webpack cfg
      },
      packager: {
        // https://github.com/electron-userland/electron-packager/blob/master/docs/api.md#options

        // OS X / Mac App Store
        // appBundleId: '',
        // appCategoryType: '',
        // osxSign: '',
        // protocol: 'myapp://path',

        // Window only
        // win32metadata: { ... }
      },
      builder: {
        // https://www.electron.build/configuration/configuration

        // appId: 'quasar-app'
      }
    }
  }
}
