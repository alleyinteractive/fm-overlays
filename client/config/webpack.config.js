const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const config = {
  entry: {
    global: path.join(__dirname, '../js/global.js'),
    admin: path.join(__dirname, '../js/admin.js'),
  },
  output: {
		path: path.resolve(__dirname, '../../static'),
		publicPath: '/wp-content/plugins/fm-overlays/static/',
    filename: 'js/[name].min.js'
	},
  module: {
    rules: [
			{
        test: /\.scss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: '../../',
            },
          },
					'css-loader',
					'sass-loader',
        ],
      },
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude: /node_modules/,
      },
      {
        test: /\.svg$/,
        use: 'file-loader',
      }
    ]
  },
  plugins: [
		new CleanWebpackPlugin(),
		new MiniCssExtractPlugin(),
  ]
};

module.exports = config;
