module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    concat: {
      js: {
        src: ['app/js/highlight.pack.js'],
        dest: 'app/tmp/scripts.js'
      }
    },

    uglify: {
      build: {
        src: 'app/tmp/scripts.js',
        dest: 'public/static/js/scripts.js'
      }
    },

    cssmin: {
      target: {
        files: {
          'public/static/css/styles.css': ['app/css/styles.css', 'app/css/highlight/github.css']
        }
      }
    },

    clean: ['app/tmp/']
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-clean');

  grunt.registerTask('default', ['concat', 'uglify', 'cssmin', 'clean']);

}