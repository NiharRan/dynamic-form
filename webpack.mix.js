let mix = require("laravel-mix");
mix
  .js("src/main.js", "assets/")
  .postCss("src/app.css", "assets/", [require("tailwindcss")])
  .vue({ version: 3 })
  .alias("@vue/runtime-dom");
