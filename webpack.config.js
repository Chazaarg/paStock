var Encore = require("@symfony/webpack-encore");

Encore.setOutputPath("public/build/")
  .setPublicPath("/build")

  //React App
  .addEntry("index", ["babel-polyfill", "./assets/js/index.js"])

  //Custom CSS style.
  .addStyleEntry("app", "./assets/css/app.css")

  //Imported CSS style.
  .addStyleEntry("global", "./assets/css/global.scss")

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
  .enableReactPreset();

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

module.exports = Encore.getWebpackConfig();
