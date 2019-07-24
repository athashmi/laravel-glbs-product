const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
	.combine([
      /*'public/revox/assets/plugins/jquery/jquery-3.2.1.min.js',*/
		 'public/revox/assets/plugins/modernizr.custom.js',
		 'public/revox/assets/plugins/jquery-ui/jquery-ui.min.js',
     'public/js/Chart.min.js',
     'public/js/moment.min.js',
		 /*'public/revox/assets/plugins/popper/umd/popper.min.js',*/
		 /*'public/revox/assets/plugins/bootstrap/js/bootstrap.min.js',*/
		 'public/revox/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js',
     'public/revox/assets/plugins/jquery-validation/js/jquery.validate.min.js',
		 'public/revox/pages/js/pages.js',

       
       ],'public/js/all.js')
	.combine([
      'public/revox/assets/plugins/pace/pace-theme-flash.css',
      'public/revox/assets/plugins/bootstrap/css/bootstrap.min.css',
      'public/revox/assets/plugins/jquery-scrollbar/jquery.scrollbar.css',
      'public/revox/assets/plugins/nvd3/nv.d3.min.css',
      'public/revox/assets/plugins/mapplic/css/mapplic.css',
      'public/revox/assets/plugins/rickshaw/rickshaw.min.css',
      'public/revox/assets/plugins/bootstrap-datepicker/css/datepicker3.css',
      'public/revox/assets/plugins/jquery-metrojs/MetroJs.css',
      /*'public/revox/pages/css/pages.css',*/
    ], 'public/css/all.css');
   //.sass('resources/sass/app.scss', 'public/css');
