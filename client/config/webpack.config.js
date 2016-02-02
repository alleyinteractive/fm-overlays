'use strict';

// Webpack dependencies
var path = require('path');
var webpack = require('webpack');
var ExtractTextPlugin = require('extract-text-webpack-plugin');
var LiveReloadPlugin = require('webpack-livereload-plugin');

// Path definitions
var buildRoot = path.resolve(__dirname, '../../');
var appRoot = path.join(buildRoot, 'client/js/app');

// Plugin namespace
var pluginName = path.join(__dirname, '../../').match(/([^\/]*)\/*$/)[1];

module.exports = {
  // Two discrete module entry points
  entry: {
    global: 'client/js/global.js',
    admin: 'client/js/admin.js'
  },

  // Define module outputs
  output: {
    path: 'static',
    publicPath: '/wp-content/plugins/' + pluginName + '/static/',
    filename: 'js/fm-overlays-[name].js'
  },

  // So we can put config files in config/
  eslint: {
    configFile: path.join(__dirname, '.eslintrc')
  },

  // Where webpack resolves modules
  resolve: {
    root: buildRoot,
    modulesDirectories: [
      'node_modules'
    ]
  },

  // Enable require('jquery') where jquery is already a global
  externals: {
    'jQuery': 'jQuery'
  },

  plugins: [
    new ExtractTextPlugin('css/fm-overlays-[name].css'),
    new LiveReloadPlugin({ appendScriptTag: true }),
    new webpack.NoErrorsPlugin()
  ],

  module: {
    preLoaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'eslint'
      }
    ],
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel'
      },
      {
        test: /\.scss$/,
        loader: ExtractTextPlugin.extract('style-loader',
          'css?sourceMap!autoprefixer?{browsers:["last 3 version"]}' +
          '!sass?outputStyle=compact&sourceMap=true&sourceMapContents=true'
        )
      },
      {
        test: /\.png(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url'
      },
      {
        test: /\.svg(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url?limit=10000&minetype=image/svg+xml'
      },
      {
        test: /\.woff(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url?limit=10000&minetype=application/font-woff'
      },
      {
        test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'url?limit=10000&minetype=application/octet-stream'
      },
      {
        test: /\.eot(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'file'
      },
    ]
  }
}