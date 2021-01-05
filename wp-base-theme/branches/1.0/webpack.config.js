'use strict'

const fs = require('fs')
const path = require('path')
const url = require('url')
const env = process.env.NODE_ENV
const app_url = process.env.APP_URL || 'http://127.0.0.1:8000'
let pathname;
try {
  const uri = new url.URL(app_url)
  pathname = uri.pathname
} catch (e) {
  pathname = '/'
}
const public_dir = process.env.APP_PUBLIC || '/'
const public_path = path.normalize(pathname + '/' + public_dir)
const isDev = env !== 'production'
const styleConfig = fs.existsSync(__dirname + '/style.config.json') ?
    require(path.resolve(__dirname, 'style.config.json')) : {}

/** Constantes de dépendances */
const webpack = require('webpack')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const {CleanWebpackPlugin} = require('clean-webpack-plugin')
const CopyPlugin = require('copy-webpack-plugin')
const ImageminPlugin = require('imagemin-webpack-plugin').default
const { WebpackManifestPlugin } = require('webpack-manifest-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserPlugin = require('terser-webpack-plugin')

let config = {
  mode: env || 'development',
  context: path.resolve(__dirname),
  entry: {
    "admin": "./src/admin",
    "admin.options": "./src/admin.options",
    "admin.post-edit": "./src/admin.post-edit",
    "app": "./src/app",
    "app.404": "./src/app.404",
    "app.archive": "./src/app.archive",
    "app.authentication": "./src/app.authentication",
    "app.editor-styles": "./src/app.editor-styles",
    "app.front-page": "./src/app.front-page",
    "app.playground": "./src/app.playground",
    "app.singular": "./src/app.singular",
    "wp.block-editor": "./src/wp.block-editor",
    "wp.editor": "./src/wp.editor",
    "wp.login": "./src/wp.login"
  },
  output: {
    filename: isDev ? 'js/[name].js' : 'js/[name].[contenthash:8].js',
    path: path.resolve(__dirname, './dist/'),
    publicPath: public_dir + 'dist/'
  },

  /**
   * Utilisation du jQuery global de Wordpress
   * /
   externals: {
    jquery: 'jQuery'
  },
   /**/

  /** @todo * /
   devServer: {
      publicPath: './',
      contentBase: path.resolve(__dirname),
      open: true,
      compress: true,
      hot: true,
      //host: '0.0.0.0',
      //proxy: {
      //    '*': {
      //        target: app_url
      //    }
      //}
  },
   /**/
  devtool: isDev ? 'cheap-module-source-map' : false,
  resolve: {
    alias: {
      '@': path.resolve(__dirname, '../../../'),
      '~': path.resolve(__dirname, '../../../node_modules/'),
      'pollen-solutions': path.resolve(__dirname, '../../../vendor/pollen-solutions/'),
      'presstify-framework': path.resolve(__dirname, '../../../vendor/presstify/framework/assets/'),
      'presstify-plugins': path.resolve(__dirname, '../../../vendor/presstify-plugins/'),
      'wp-admin': path.resolve(__dirname, '../../../wp-admin/'),
      'wp-content': path.resolve(__dirname, '../../../wp-content/'),
      'wp-includes': path.resolve(__dirname, '../../../wp-includes/')
    },
    modules: [
      'node_modules'
    ]
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              esModule: true,
            }
          },
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2,
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  [
                    'postcss-preset-env'
                  ]
                ]
              }
            }
          },
          {
            loader: 'sass-loader'
          },
          {
            loader: "@epegzz/sass-vars-loader", options: {
              syntax: 'scss',
              vars: {config: styleConfig}
            }
          }
        ]
      },
      {
        test: /\.(png|jpe?g|gif|ico|svg)$/i,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 8192,
              name: '[hash].[ext]',
              publicPath: isDev ? public_path + 'dist/assets/' : '../assets',
              outputPath: 'assets'
            }
          }
        ]
      },
      {
        test: /\.(eot|ttf|woff(2)?)(\?v=\d+\.\d+\.\d+)?$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              limit: 8192,
              name: '[hash].[ext]',
              publicPath: isDev ? public_path + 'dist/fonts' : '../fonts',
              outputPath: 'fonts'
            }
          }
        ]
      },
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader'
        }
      },
      {
        test: /\.html$/,
        loader: 'html-loader'
      },
      {
        test: require.resolve('jquery'),
        rules: [
          {
            loader: 'expose-loader',
            options: {
              exposes: [
                {
                  globalName: 'jQuery',
                  override: true,
                },
                {
                  globalName: '$',
                  override: true,
                }
              ],
            },
          },
        ],
      },
    ]
  },
  stats: {
    children: false
  },
  optimization: {
    minimizer: [
      new TerserPlugin({
        parallel: true,
        terserOptions: {
          ecma: 6,
        },
      })
    ]
  },
  plugins: [
    new CleanWebpackPlugin({
      cleanStaleWebpackAssets: false
    }),
    new CopyPlugin({
      patterns: [
        {context: 'src/images/', from: '**/*', to: './images/[path][name].[ext]', toType: 'template'}
      ]
    }),
    new ImageminPlugin({
      disable: isDev,
      test: /\.(png|jpe?g|gif|svg|ico)$/i
    }),
    new WebpackManifestPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].[contenthash:8].css',
      chunkFilename: 'css/[id].[contenthash:8].css'
    })
  ]
}

if (isDev) {
  config.plugins.push(
      new BrowserSyncPlugin({
        files: [
          public_dir + '/*.php',
          public_dir + '/views/**/*.php'
        ],
        ghostMode: false,
        https: {
          key: '/home/mastermilk/.mkcert/localhost-key.pem',
          cert: '/home/mastermilk/.mkcert/localhost.pem',
        },
        notify: false,
        proxy: app_url
      }),
      new webpack.HotModuleReplacementPlugin()
  )
}
module.exports = config