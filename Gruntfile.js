module.exports = function(grunt) {

	// Project config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		less: {
			dist: {
				options: {
					paths: ["less"]
				},
				files: {
					'css/theme.css': 'less/theme.less',
				}
			}
		},
		postcss: {
			options: {
				processors: [
					require('autoprefixer')({browsers: '> 5% in US'}),
					require('cssnano')()
				]
			},
			dist: {
				src: 'css/*.css'
			}
		},
		watch: {
			files: ['less/**/*.less'],
			tasks: [
				'less',
				'postcss'
			]
		}
	});

	// tasks
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['less', 'postcss']);

}