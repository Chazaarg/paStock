var Encore = require("@symfony/webpack-encore");

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")
  .autoProvidejQuery()

  .addEntry("app", ["babel-polyfill", "./assets/js/app.js"])
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .configureBabel(function(babelConfig) {
    babelConfig.presets.push("env");
  })
  .enableReactPreset();

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you're having problems with a jQuery plugin

module.exports = Encore.getWebpackConfig();
