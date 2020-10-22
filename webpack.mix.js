const mix = require('laravel-mix');
let webpack = require('webpack')
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

let dotenvplugin = new webpack.DefinePlugin({
    'process.env': {
        SESSION_HOSTNAME: JSON.stringify(process.env.SESSION_HOSTNAME || null),
        NODE_ENV: JSON.stringify(process.env.NODE_ENV || null)
    }
})

mix.webpackConfig({
	plugins: [
        dotenvplugin,
    ]
})

mix.js([
	"resources/js/changepassword.js",
	"resources/js/confirmpassword.js",
	"resources/js/login.js",
	"resources/js/nuevoTramite/ElementFactory.js",
	"resources/js/nuevoTramite/FormularioBuilder.js",
	"resources/js/nuevoTramite/JsonGeneraReferenciaBuilder.js",
	"resources/js/nuevoTramite/metodoPagoFactory.js",
	"resources/js/nuevoTramite/shoppingCarModule/shoppingCarBuilder.js",
	"resources/js/nuevoTramite/TiposElements/checkboxClass.js",
	"resources/js/nuevoTramite/TiposElements/inputClass.js",
	"resources/js/nuevoTramite/TiposElements/optionClass.js",
	"resources/js/nuevoTramite/TiposElements/selectClass.js",
	"resources/js/nuevoTramite/TiposElements/TextBoxClass.js",
	"resources/js/nuevoTramite/tramiteModulo/templateMetodoPagoBuilder.js",
	"resources/js/nuevoTramite/tramiteModulo/tramiteBuilder.js",
	"resources/js/recovery.js",
], 'public/js/bundle.js')
.sass('resources/sass/app.scss', 'public/css');

mix.copyDirectory('resources/images', 'public/images');
mix.copyDirectory('resources/js/pages', 'public/js/pages');
mix.copyDirectory('resources/js/plugins', 'public/plugins');
mix.copy('resources/js/scripts.bundle.min.js', 'public/js/scripts.bundle.min.js');
mix.copy('resources/js/scripts.bundle.js', 'public/js/scripts.bundle.js');
