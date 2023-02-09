const mix = require('laravel-mix')
const webpack = require('webpack')
const path = require('path')

class NovaExtension {
  name() {
    return 'saintsystems/nova-linkable-metrics'
  }

  register(name) {
    this.name = name
  }

  webpackConfig(webpackConfig) {

    webpackConfig.externals = {
        vue: 'Vue',
        'laravel-nova': 'LaravelNova',
        '@/mixins': 'LaravelNova'
    }

    // webpackConfig.resolve.alias = {
    //     vue: '@vue/compat'
    // }

    // webpackConfig.module.rules = [
    //     {
    //       test: /\.vue$/,
    //       loader: 'vue-loader',
    //       options: {
    //         compilerOptions: {
    //           compatConfig: {
    //             MODE: 2
    //           }
    //         }
    //       }
    //     }
    //   ]

    // webpackConfig.resolve.alias = {
    //   ...(webpackConfig.resolve.alias || {}),
    //   'laravel-nova': path.join(
    //     __dirname,
    //     'vendor/laravel/nova/resources/js/mixins/packages.js'
    //   ),
    // }

    webpackConfig.output = {
      uniqueName: this.name,
    }
  }
}

mix.extend('nova', new NovaExtension())
