let mix = require('laravel-mix');
require('laravel-mix-purgecss');
const tailwindcss = require('tailwindcss');

let vendor_js = [
    './resources/vendor/jquery-1.11.1.min.js',
    './resources/vendor/jquery-ui-1.11.2.custom/jquery-ui.min.170707.js',
    './resources/vendor/moment-with-locales.min.js',
    './resources/vendor/currency.min.js',
    './resources/vendor/apexcharts.js',
    './resources/vendor/jquery.maskedinput.min.js',
    './resources/vendor/jquery.price_format.2.0.min.js',
    './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    './resources/vendor/simple-color/jquery.simple-color.min.js',
    './resources/vendor/bootstrap-select-1.12.2/dist/js/bootstrap-select.js',
    './resources/vendor/bootstrap-select-1.12.2/dist/js/i18n/defaults-pt_BR.js',
    './resources/vendor/selectize/dist/js/standalone/selectize.min.js',
    './resources/vendor/medium-editor/medium-editor.min.js',
    './resources/vendor/angular-js-v1.7.5.js',
    './resources/vendor/angular-sanitize.min.js',
    './resources/vendor/jquery-stickytabs-master/jquery.stickytabs.js',
    './resources/vendor/angular-ui-tinymce/bower_components/tinymce/tinymce.js',
    './resources/vendor/angular-ui-tinymce/bower_components/tinymce/themes/modern/theme.min.js',
    './resources/vendor/angular-ui-tinymce/src/tinymce.js',
];

let app_js = [
    './resources/js/admin.js',
    './resources/js/protocols.js',
];

let angular_app_js = [
    './resources/js/app_angular.js',
    './resources/js/angular/FinanceiroFluxo.controller.js',
    './resources/js/angular/FinanceiroMovimentacao.controller.js',
    './resources/js/angular/FinanceiroPaciente.controller.js',
    './resources/js/angular/GuiaPaciente.controller.js',
    './resources/js/angular/GuiaEmpresa.controller.js',
    './resources/js/angular/Laudo.controller.js',
    './resources/js/angular/ProntuarioFormCreate.controller.js',
    './resources/js/angular/ProntuarioFormEdit.controller.js',
    './resources/js/angular/ProntuarioListagemPainel.controller.js',
    './resources/js/angular/ListRecursos.controller.js',
    './resources/js/angular/ProtocolJebsenForm.controller.js',
    './resources/js/angular/ProtocolJebsenGrid.controller.js',
    './resources/js/angular/TextosProntuarioForm.controller.js',
    './resources/js/angular/Results.controller.js',
];

let vendor_css = [
    './resources/vendor/jquery-ui-1.11.2.custom/jquery-ui.min.css',
    './resources/vendor/font-awesome-4.7.0/css/font-awesome.min.css',
    './resources/vendor/bootstrap-select-1.12.2/dist/css/bootstrap-select.min.css',
    './resources/vendor/selectize/dist/css/selectize.bootstrap3.css',
    './resources/vendor/medium-editor/medium-editor.min.css',
];

mix
    .combine(vendor_js, 'public/js/vendor.js')
    .js(app_js, 'public/js/app.js')
    .js(angular_app_js, 'public/js/app_angular.js');

mix
    .combine(vendor_css, 'public/css/vendor.css')
    .sass('resources/css/app.scss', 'public/css/app.css')
    .purgeCss();

mix
    .copyDirectory('resources/vendor/font-awesome-4.7.0/fonts', 'public/fonts')
    .copyDirectory('resources/vendor/jquery-ui-1.11.2.custom/images', 'public/css/images')
    .setPublicPath('public');

mix.options({
    processCssUrls: false, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
    postCss: [ tailwindcss('./tailwind.config.js') ]
});

// -----------------------------------------------------------

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
