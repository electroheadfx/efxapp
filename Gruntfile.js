/* Paths */

// Source
	// source editing assets (/themes/assets/) : css/less
		//# theme_path_src
	// source default theme
		//# theme_default_path_src

//prod
	// prod asset path : /public/themes/
		//# theme_path
	// prod default theme
		//# theme_default_path

// dev
	// dev asset path : /public/dev-themes/
		//# theme_path_dev
	// dev default theme
		//# theme_default_dev

/*

	fonts sont gérés directement dans /public/assets/fonts (dev et prod) PAS DE THEMING pour FONTS
	img est géré directement dans /public/themes/img (dev et prod)

	css/js/less est géré dans /themes/assets/ (dev)
	grunt s’occupe de tout copier/minimiser/optimisé dans /public/dev-themes (dev) et /public/themes (prod)

	Dans /themes/assets/ je m’occupe uniquement des LESS, et CSS/JS

 */

module.exports = function(grunt) {

	require('load-grunt-tasks')(grunt);

	/* setup variables */

		assets = grunt.file.readJSON('app/config/development/app-assets-grunt.json');
		themes_data = grunt.file.readJSON('app/config/development/app-themes.json');

		var themes = [];
		for (key in themes_data) {
			themes.push(key);
		}

		/**
		 * compile LESS and minify twitter bootstrap themes
		 */
		var less_packages = assets.less_packages;

		/**
		 * minify CSS files in default theme
		 */
		var css_to_minify = assets.css_to_minify;

		/**
		 * minify JS files in default theme
		 */
		var jsfiles_to_minify = assets.jsfiles_to_minify;

		/**
		 * Concat/minify JS files in default theme
		 */

		var js_to_concat = assets.js_to_concat;

		/**
		 * Concat/minify CSS files in default theme
		 */

		var css_to_concat = assets.css_to_concat;

	/* End Setup */


	/* Paths */
	var theme_path = assets.path_compilation;
	var theme_path_dev = assets.path_dev;
	var theme_path_src = assets.path_source;
	var theme_default_path = theme_path+'default/';
	var theme_default_dev = theme_path_dev+'default/';
	var theme_default_path_src = theme_path_src+'default/assets/';

	// create objects for pass data to grunt
	var less_tasks 				= new Object;
	var css_minify_data 		= new Object;
	var js_uglify_data 			= new Object;
	var copy_assets_data 		= new Object;
	var watch_data 				= new Object;
	var config_file_data		= new Object;

	var compile_less_all_datatask	= [];
	var minify_all_datatask			= [];
	var minify_datatask				= [];
	var uglify_datatask				= [];
	var copy_assets_all_datatask	= [];
	var all_datatask 				= [];
	var conc_datatask 				= [];
	var conc_css_datatask 			= [];
	var conc_js_datatask 			= [];

	// options for less dist
	var less_options_dist = {
		cleancss: true,
		compress: true,
		relativeUrls: true
	};

	// options for less dev
	var less_options_dev = {
		sourceMap: true,
        dumpLineNumbers: 'comments',
        relativeUrls: true
	};

	var tasks_memo='Grunt Memo Tasks\n\n\n';

	/* write main tasks memo */

		tasks_memo += 'Global Tasks\n';
		tasks_memo += '\t• grunt all \t\t: Does all tasks\n';
		tasks_memo += '\t• grunt min_less \t: Compile all less data\n';
		tasks_memo += '\t• grunt min_assets \t: Minify all Assets data\n';
		tasks_memo += '\t• grunt min_js \t\t: Minify all JS data\n';
		tasks_memo += '\t• grunt min_css \t: Minify all CSS data\n';
		tasks_memo += '\t• grunt conc_js \t: Concate all JS data\n';
		tasks_memo += '\t• grunt conc_css \t: Concate all CSS data\n';
		// tasks_memo += '\t• grunt copy_assets : Copy all assets (img/fonts) to public themes\n\n\n';

	/**
	 *
	 * copy with watch data setup for copy assets on every themes
	 *
	 */


	tasks_memo += 'Copy assets Tasks\n\n';

	for (var i = themes.length - 1; i >= 0; i--) {

		tasks_memo += '\n\tCopy Task on Theme '+themes[i]+'\n';

		// copy css to dev : /public/dev-themes/
		copy_assets_data['css_dev_'+themes[i]] = {
		    files: [
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/css/',
			        src: ['**/*.css'],
			        dest: theme_path_dev+themes[i]+'/css/',
			        filter:  'isFile',
					flatten: false
		    	},
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/css/',
			        src: ['**/*.css'],
			        dest: theme_path+themes[i]+'/css/',
			        filter:  'isFile',
					flatten: false
		    	}
		    ]
		}

		// copy js to dev : /public/dev-themes/
		copy_assets_data['js_dev_'+themes[i]] = {
		    files: [
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/js/',
			        src: ['**/*.js'],
			        dest: theme_path_dev+themes[i]+'/js/',
			        filter:  'isFile',
					flatten: false
		    	},
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/js/',
			        src: ['**/*.js'],
			        dest: theme_path+themes[i]+'/js/',
			        filter:  'isFile',
					flatten: false
		    	}
		    ]
		}

		// copy FONT dev (/public/dev-themes/) to prod (/themes/assets/)
		copy_assets_data['fonts_'+themes[i]] = {
		    files: [{
		        expand: true,
		        cwd: theme_path_src+themes[i]+'/assets/fonts/',
		        src: ['**/*.{eot,ttf,svg,woff,otf,html}'],
		        dest: theme_path+themes[i]+'/fonts/',
		        filter:  'isFile',
				flatten: false
		    }]
		}

		// copy css to dev : /public/dev-themes/
		copy_assets_data['img_'+themes[i]] = {
		    files: [
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/img/',
			        src: ['**/*.{img,jpg,svg,png,jpeg,gif}'],
			        dest: theme_path_dev+themes[i]+'/img/',
			        filter:  'isFile',
					flatten: false
		    	},
		    	{
			        expand: true,
			        cwd: theme_path_src+themes[i]+'/assets/img/',
			        src: ['**/*.{img,jpg,svg,png,jpeg,gif}'],
			        dest: theme_path+themes[i]+'/img/',
			        filter:  'isFile',
					flatten: false
		    	},
		    ]
		}

		tasks_memo += '\t\t'+'copy css to dev :';
		tasks_memo += '\t'+'grunt copy:css_dev_'+themes[i]+'\n';

		tasks_memo += '\t\t'+'copy js to dev  :';
		tasks_memo += '\t'+'grunt copy:js_dev_'+themes[i]+'\n';

		tasks_memo += '\t\t'+'copy FONT dev to prod  :';
		tasks_memo += '\t'+'grunt copy:fonts_'+themes[i]+'\n';

		tasks_memo += '\t\t'+'copy IMG dev to prod  :';
		tasks_memo += '\t'+'grunt copy:img_'+themes[i]+'\n';

		/**
		 * Watch setup
		 */
		// watch copy setup

			//  watch CSS from /themes/assets/ to public dev
			var watchFiles = theme_path_src+themes[i]+'/assets/css/**/*.css';
			var watchTasks = ["copy:css_dev_"+themes[i]];
			watch_data['copy_assets_css_'+themes[i]] = {
				files : watchFiles,
				tasks : watchTasks
			};

			//  watch JS from /themes/assets/ to public dev
			var watchFiles = theme_path_src+themes[i]+'/assets/js/**/*.js';
			var watchTasks = ["copy:js_dev_"+themes[i]];
			watch_data['copy_assets_js_'+themes[i]] = {
				files : watchFiles,
				tasks : watchTasks
			};

			//  watch FONT from dev to prod
			var watchFiles = theme_path_src+themes[i]+'/assets/fonts/*';
			var watchTasks = ["copy:fonts_"+themes[i]];
			watch_data['copy_assets_fonts_'+themes[i]] = {
				files : watchFiles,
				tasks : watchTasks
			};

			//  watch IMG from dev to prod
			var watchFiles = theme_path_src+themes[i]+'/assets/img/*';
			var watchTasks = ["copy:img_"+themes[i]];
			watch_data['copy_assets_img_'+themes[i]] = {
				files : watchFiles,
				tasks : watchTasks
			};

// console.log(theme_path_src+themes[i]+'/assets/fonts/*');
		all_datatask.push("copy:css_dev_"+themes[i]);
		all_datatask.push("copy:js_dev_"+themes[i]);
		all_datatask.push("copy:fonts_"+themes[i]);
		all_datatask.push("copy:img_"+themes[i]);
		copy_assets_all_datatask.push("copy:css_dev_"+themes[i]);
		copy_assets_all_datatask.push("copy:js_dev_"+themes[i]);
		copy_assets_all_datatask.push("copy:fonts_"+themes[i]);
		copy_assets_all_datatask.push("copy:img_"+themes[i]);

	} // endloop themes

	tasks_memo += '\n';

	/**
	 *
	 * less with watch data setup for themes on dev/dist configs
	 *
	 */

	tasks_memo += 'Less Tasks\n\n';

	for (var i = themes.length - 1; i >= 0; i--) {

		tasks_memo += '\n\tLess Task on Theme '+themes[i]+'\n';

		for (var j = less_packages.length - 1; j >= 0; j--) {
			var pkg 		= less_packages[j];
	 		var lessfile 	= theme_path_src+themes[i]+'/assets/less/custom/'+pkg+'.less';
			// console.log(lessfile);

			if (grunt.file.isFile(lessfile)) {

				// tasks_memo += '\t\t'+less_packages[j]+'\n';
				// var pkgName = pkg.substring(pkg.lastIndexOf("/")+1,pkg.lastIndexOf(""));
				// var pkgPath = pkgName.substring(0,pkgName.lastIndexOf(pkgName));

				/**
				 * Less setup
				 */
				// dist setup (prod)

					var minPath   		= theme_path+themes[i]+'/css/'+pkg+'.min.css';
					var lessPath  		= lessfile;
					var less_files 		= new Object;
					less_files[minPath] = lessPath;
					less_tasks['dist_'+themes[i]+'_'+pkg] = {
						options: less_options_dist,
						files: less_files
					};
				tasks_memo += '\n\t\t'+'Package '+pkg+' : \n';
				tasks_memo += '\t\t\t'+'grunt less:dist_'+themes[i]+'_'+pkg+'\n';

				// dev setup
					var minPath   		= theme_path_dev+themes[i]+'/css/'+pkg+'.css';
					var lessPath  		= lessfile;
					var less_files 		= new Object;
					less_files[minPath] = lessPath;
					less_tasks['dev_'+themes[i]+'_'+pkg] = {
						options: less_options_dev,
						files: less_files
					};
				tasks_memo += '\t\t\t' + 'grunt less:dev_'+themes[i]+'_'+pkg+'\n';
				/* End less	 setup */

				/**
				 * Watch setup
				 */
				// watch dist setup
					var watchFiles = lessfile;
					var watchTasks = ['less:dist_'+themes[i]+'_'+pkg];
					watch_data['less_dist_'+themes[i]+'_'+pkg] = {
						files : watchFiles,
						tasks : watchTasks
					};

					// watch dev setup
					var watchFiles = lessfile;
					var watchTasks = ['less:dev_'+themes[i]+'_'+pkg];
					watch_data['less_dev_'+themes[i]+'_'+pkg] = {
						files : watchFiles,
						tasks : watchTasks
					};
				/* end watch setup */

				/* register default task */

				compile_less_all_datatask.push("less:dist_"+themes[i]+"_"+pkg);
				all_datatask.push("less:dist_"+themes[i]+"_"+pkg);
				compile_less_all_datatask.push("less:dev_"+themes[i]+"_"+pkg);
				all_datatask.push("less:dev_"+themes[i]+"_"+pkg);

			}

		} /* end less packages loop */
		tasks_memo += '\n';

	};
	/* end loop initConfig data */

	// console.log(compile_less_all_datatask);

/**
 *
 *
 *  cssmin/uglify tasks with watch
 *
 *
 */

 	tasks_memo += '\n\nCSS minify Tasks\n';

 	for (var i = themes.length - 1; i >= 0; i--) {


	 	// Minify : css_to_minify array
	 	for (var j = css_to_minify.length - 1; j >= 0; j--) {

	 		var cssfile = theme_path_src+themes[i]+'/assets/css/'+css_to_minify[j]+'.css';

			if (grunt.file.isFile(cssfile)) {

		 		// create minify task
			 	css_minify_data['cssmin_'+themes[i]+'_'+css_to_minify[j]] = {
			 		expand: true,
			 		cwd: theme_path_src+themes[i]+'/assets/css/',
			 		src: [css_to_minify[j]+'.css'],
			 		dest: theme_path+themes[i]+'/css/',
		 	    	ext: '.min.css'
			 	};

			 	// watch files for minify task
			 	var watchFile = cssfile;
			 	var watchTask = ['cssmin:cssmin_'+themes[i]+'_'+css_to_minify[j]];
			 	watch_data['watch_cssmin_'+themes[i]+'_'+css_to_minify[j]] = {
			 		files : watchFile,
			 		tasks : watchTask
			 	};

			 	tasks_memo += '\t\t'+'grunt cssmin:cssmin_'+themes[i]+'_'+css_to_minify[j]+'\n';

			 	minify_all_datatask.push("cssmin:cssmin_"+themes[i]+'_'+css_to_minify[j]);
			 	minify_datatask.push("cssmin:cssmin_"+themes[i]+'_'+css_to_minify[j]);
			 	all_datatask.push("cssmin:cssmin_"+themes[i]+'_'+css_to_minify[j]);

		 	}
		}
	}

	tasks_memo += '\n\nJS Uglify Tasks\n';

	for (var i = themes.length - 1; i >= 0; i--) {

	 	// uglify : jsfiles_to_minify array
	 	for (var j = jsfiles_to_minify.length - 1; j >= 0; j--) {

		 	var jsfile = theme_path_src+themes[i]+'/assets/js/'+jsfiles_to_minify[j]+'.js';
		 	if (grunt.file.isFile(jsfile)) {
		 		// create uglify task
			 	js_uglify_data['uglify_'+themes[i]+'_'+jsfiles_to_minify[j]] = {
			 		files: [{
			 			expand: true,
			 			cwd: theme_path_src+themes[i]+'/assets/js/',
			 			src: jsfiles_to_minify[j]+'.js',
			 			dest: theme_path+themes[i]+'/js/',
			 			ext: '.min.js'
			 		}]
			 	};

			 	tasks_memo += '\t\t'+'grunt uglify:uglify_'+themes[i]+'_'+jsfiles_to_minify[j]+'\n';

			 	// watch files for uglify task
			 	var watchFile = jsfile;
			 	var watchTask = ['uglify:uglify_'+themes[i]+'_'+jsfiles_to_minify[j]];
			 	watch_data['watch_uglify_'+themes[i]+'_'+jsfiles_to_minify[j]] = {
			 		files : watchFile,
			 		tasks : watchTask
			 	};
			 	minify_all_datatask.push("uglify:uglify_"+themes[i]+'_'+jsfiles_to_minify[j]);
			 	uglify_datatask.push("uglify:uglify_"+themes[i]+'_'+jsfiles_to_minify[j]);
			 	all_datatask.push("uglify:uglify_"+themes[i]+'_'+jsfiles_to_minify[j]);

			 }
		}
	}

/**
 *
 * CONCAT ASSETS
 *
 */

	// concat JS
// debug efx
	tasks_memo += '\n\nConcat JS Tasks\n';

		for (var i = themes.length - 1; i >= 0; i--) {


		 	var uglify_concat = new Object;
		 	var uglify_files = [];

		 	for (key in js_to_concat) {

		 		var dirjspath = theme_path_src+themes[i]+'/assets/js/'+key;

				if (grunt.file.isDir(dirjspath)) {

			 		var data = js_to_concat[key];

			 		tasks_memo += '\t\t'+'grunt uglify:concatjs_'+themes[i]+key+' :\n';

			 		for (var j = 0; j < data.length - 1; j++) {
				 		uglify_files.push(dirjspath+'/'+data[j]+'.js');

				 		// console.log(theme_path_src+themes[i]+'/js/'+key+'/'+data[j]+'.js');
				 		// console.log('theme[i] = ' + themes[i]);

				 		tasks_memo += '\t\t\t+ ' + dirjspath+'/'+data[j]+'.js'+'\n';
					}

				 	tasks_memo += '\n';

				 	// console.log('dest : '+theme_path+themes[i]+'js/'+key+'.min.js');

				 	uglify_concat[theme_path+themes[i]+'/js/'+key+'/'+key+'.min.js'] = uglify_files;

				 	js_uglify_data['concatjs_'+themes[i]+'_'+key] = {
				 		options: {
					      mangle: true
					    },
				 		files: uglify_concat
				 	}

				 	all_datatask.push("uglify:concatjs_"+themes[i]+'_'+key);
				 	conc_datatask.push("uglify:concatjs_"+themes[i]+'_'+key);
				 	conc_js_datatask.push("uglify:concatjs_"+themes[i]+'_'+key);
				}
		 	}

		 }

	 // Concat CSS

		tasks_memo += '\n\nConcat CSS Tasks\n';

	 	var minify_concat = new Object;
	 	var minify_files = [];

	 	for (var i = themes.length - 1; i >= 0; i--) {

		 	for (key in css_to_concat) {

		 		var dircsspath = theme_path_src+themes[i]+'/assets/css/'+key;

				if (grunt.file.isDir(dircsspath)) {

			 		var data = css_to_concat[key];

			 		tasks_memo += '\t\t'+'grunt cssmin:concatcss_'+key+' :\n';

			 		for (var j = 0; j < data.length - 1; j++) {

					 		minify_files.push(dircsspath+'/'+data[j]+'.css');
					 		// console.log(dircsspath+'/'+data[j]+'.css');
					 		tasks_memo += '\t\t\t+ ' + dircsspath+'/'+data[j]+'.css'+'\n';
					}
				 	tasks_memo += '\n';

				 	// minify_concat[key+'.min.css'] = minify_files;
				 	minify_concat[theme_path+themes[i]+'/css/'+key+'/'+key+'.min.css'] = minify_files;

				 	css_minify_data['concatcss_'+themes[i]+'_'+key] = {
				 		options: {},
				 		files: minify_concat
				 	}

				 	all_datatask.push("cssmin:concatcss_"+themes[i]+'_'+key);
				 	conc_datatask.push("cssmin:concatcss_"+themes[i]+'_'+key);
				 	conc_css_datatask.push("cssmin:concatcss_"+themes[i]+'_'+key);
				}
		 	}

		}

	// setup initConfig with less, cssmin, uglify tasks and watch
	grunt.initConfig({
						"file-creator": config_file_data,
						less: less_tasks,
						cssmin: css_minify_data,
						uglify: js_uglify_data,
						copy: copy_assets_data,
						watch: watch_data
					});

	/*
	*
	*
	* setup default tasks
	*
	*
	*/

	// grunt.registerTask('default', writeMemo);

	// Done all
	grunt.registerTask('all', all_datatask);

	// compile and minify all LESS
	grunt.registerTask('min_less', compile_less_all_datatask);

	// Minify and uglify all assets
	grunt.registerTask('min_assets', minify_all_datatask);

	// Uglify All JS
	grunt.registerTask('min_js', uglify_datatask);

	// Minify all CSS
	grunt.registerTask('min_css', minify_datatask);

	// Concate all CSS/JS Stuff
	grunt.registerTask('conc', conc_datatask);

	// Concate all JS Stuff
	grunt.registerTask('conc_js', conc_js_datatask);

	// Concate all CSS Stuff
	grunt.registerTask('conc_css', conc_css_datatask);

	// Copy assets
	grunt.registerTask('copy_assets', copy_assets_all_datatask);

	grunt.file.write('app-grunt-tasks-memo.txt', tasks_memo);

}
