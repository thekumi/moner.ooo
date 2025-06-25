'use strict'

const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { PurgeCSSPlugin } = require("purgecss-webpack-plugin");
const glob = require('glob-all');

module.exports = {
  mode: 'development',
  entry: './src/js/main.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'js'),
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader'
        ]
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../css/main.css'
    }),
    new PurgeCSSPlugin({
      paths: glob.sync([
        path.join(__dirname, 'templates', 'index.php')
      ]),
      safelist: ['tooltip', 'fade', 'show', 'bs-tooltip-top', 'tooltip-inner', 'tooltip-arrow', 'btn-equals', 'btn-arrow', 'alert', 'alert-warning']
    })
  ]
};