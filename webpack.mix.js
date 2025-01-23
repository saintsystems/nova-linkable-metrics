let mix = require('laravel-mix')
let path = require('path')

mix.extend('nova', new require('laravel-nova-devtool'))

mix
  .setPublicPath('dist')
  .js('resources/js/card.js', 'js')
  .vue({ version: 3 })
  .css('resources/css/card.css', 'css')
  .alias({ '@': path.join(__dirname, 'resources/js/') })
  .nova('saintsystems/nova-linkable-metrics')
