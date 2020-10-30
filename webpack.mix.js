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
		APP_URL: JSON.stringify(process.env.APP_URL || null),
		SESSION_HOSTNAME: JSON.stringify(process.env.SESSION_HOSTNAME || null),
		PAYMENTS_HOSTNAME: JSON.stringify(process.env.PAYMENTS_HOSTNAME || null),
		PAYMENTS_KEY: JSON.stringify(process.env.PAYMENTS_KEY || null),
		NODE_ENV: JSON.stringify(process.env.NODE_ENV || null),
		TESORERIA_HOSTNAME: JSON.stringify(process.env.TESORERIA_HOSTNAME || null)
	}
})

mix.webpackConfig({
	plugins: [
		dotenvplugin,
	]
})

mix.js([
	"resources/js/app.js",
	"resources/js/changepassword.js",
	"resources/js/confirmpassword.js",
	"resources/js/login.js",
	"resources/js/recovery.js",
], 'public/js/bundle.js')
.sass('resources/sass/app.scss', 'public/css');

mix.copyDirectory('resources/images', 'public/images');
mix.copyDirectory('resources/js/pages', 'public/js/pages');
mix.copyDirectory('resources/js/plugins', 'public/plugins');
mix.copy('resources/js/scripts.bundle.min.js', 'public/js/scripts.bundle.min.js');
mix.copy('resources/js/scripts.bundle.js', 'public/js/scripts.bundle.js');
