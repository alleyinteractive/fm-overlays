const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const StylelintPlugin = require('stylelint-bare-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');

const exclude = [
  /node_modules/,
  /\.min\.js$/,
];

const config = {
  entry: {
    global: path.join(__dirname, '../js/global.js'),
    admin: path.join(__dirname, '../js/admin.js'),
  },
  output: {
    path: path.resolve(__dirname, '../../static'),
    publicPath: '/wp-content/plugins/fm-overlays/static/',
    filename: 'js/[name].min.js',
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  'postcss-preset-env',
                  'autoprefixer',
                ],
              },
            },
          },
          'sass-loader',
        ],
      },
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude,
      },
      {
        test: /\.svg$/,
        use: 'file-loader',
      },
    ],
  },
  plugins: [
    new StylelintPlugin(),
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: 'css/[name].min.css',
    }),
    new ESLintPlugin(),
  ],
};

module.exports = config;
