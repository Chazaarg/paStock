var Encore = require("@symfony/webpack-encore");

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")
  .autoProvidejQuery()

  .addEntry("index", ["babel-polyfill", "./assets/js/index.js"])
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .enableReactPreset()
  .configureBabel(config => {
    config.presets.push("stage-1");
  });

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you're having problems with a jQuery plugin

module.exports = Encore.getWebpackConfig();
