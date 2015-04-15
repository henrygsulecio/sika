module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    compass: {
      dist: {
        options: {
          config: 'sass.config.rb'
        }
      }
    },
    uglify: {
      options: {
        mangle: false
      },
      modernizr: {
        src: 'public/packages/modernizr/modernizr.js',
        dest: 'public/js/modernizr.min.js'
      },
      jquery: {
        src: 'public/packages/jquery/dist/jquery.js',
        dest: 'public/js/jquery.min.js'
      },
      bootstrap: {
        src: [
          'public/js/plugins.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/affix.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/button.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/carousel.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/collapse.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/dropdown.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/transition.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/scrollspy.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js',
          'public/packages/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js'
        ],
        dest: 'public/js/libs.min.js'
      },
      chart: {
        src: 'public/js/chart.js',
        dest: 'public/js/chart.min.js'
      },
      dashboard: {
        src: ['public/js/chart.js', 'public/js/dashboard.js'],
        dest: 'public/js/dashboard.min.js'
      }
    },
    watch: {
      css: {
        files: ['public/scss/*.scss'],
        tasks: ['compass']
      },
      dashboard: {
        files: ['public/js/dashboard.js'],
        tasks: ['uglify:dashboard']
      }
    }
  });

  // Loading the plugins
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['compass', 'uglify', 'watch']);

};
