var Encore = require("@symfony/webpack-encore");

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")

  //React App
  .addEntry("assets/index", ["babel-polyfill", "./assets/js/index.js"])

  //Custom CSS style.
  .addStyleEntry("assets/app", "./assets/css/app.css")

  //Imported CSS style.
  .addStyleEntry("assets/global", "./assets/css/global.scss")

  //Config
  .cleanupOutputBeforeBuild()
  .enableBuildNotifications()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())

  //Babel config. So it compiles arrow function, spread, etc.
  .configureBabel(config => {
    config.presets.push("stage-1");
  })

  //sass/scss
  .enableSassLoader()

  //JQuery
  .autoProvidejQuery()

  //React
  .enableReactPreset()

  // uncomment if you use TypeScript
  //.enableTypeScriptLoader()

  .configureFilenames({
    images: "[path][name].[hash:8].[ext]"
  });

module.exports = Encore.getWebpackConfig();
