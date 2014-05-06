module.exports = function(grunt) {

    // Project configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                stripBanners: true
            },
            main: {
                src: [
                    'assets/js/src/ajax_search.js'
                ],
                dest: 'assets/js/ajax_search.js'
            }
        },
        jshint: {
            all: [
                'Gruntfile.js',
                'assets/js/src/**/*.js',
                'assets/js/test/**/*.js'
            ],
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                boss: true,
                eqnull: true,
                globals: {
                    exports: true,
                    module: false
                }
            }
        },
        uglify: {
            all: {
                files: {
                    'assets/js/ajax_search.min.js': ['assets/js/ajax_search.js']
                },
                options: {
                    mangle: {
                        except: ['jQuery']
                    },
                    preserveComments: 'some'
                }
            }
        },
        test: {
            files: ['assets/js/test/**/*.js']
        },

        sass: {
            all: {
                files: {
                    'assets/css/ajax_search.css': 'assets/css/sass/ajax_search.scss'
                }
            }
        },

        cssmin: {
            options: {
                banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
                    ' * <%= pkg.homepage %>\n' +
                    ' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
                    ' * Licensed GPLv2+' + ' */\n'
            },
            minify: {
                expand: true,

                cwd: 'assets/css/',
                src: ['ajax_search.css'],

                dest: 'assets/css/',
                ext: '.min.css'
            }
        },
        autoprefixer: {
            all: {
                options: {
                    browsers: ['last 2 versions']
                },
                src: 'assets/css/ajax_search.css',
                dest: 'assets/css/ajax_search.css'
            }
        },
        watch: {

            sass: {
                files: ['assets/css/sass/*.scss'],
                tasks: ['sass', 'autoprefixer:all', 'cssmin'],
                options: {
                    debounceDelay: 500
                }
            },

            scripts: {
                files: ['assets/js/src/**/*.js', 'assets/js/vendor/**/*.js'],
                tasks: ['jshint', 'concat', 'uglify'],
                options: {
                    debounceDelay: 500
                }
            }
        },
        clean: {
            main: ['release/<%= pkg.version %>']
        },
        copy: {
            // Copy the plugin to a versioned release directory
            main: {
                src: [
                    '**',
                    '!node_modules/**',
                    '!release/**',
                    '!.git/**',
                    '!.sass-cache/**',
                    '!css/src/**',
                    '!js/src/**',
                    '!img/src/**',
                    '!Gruntfile.js',
                    '!package.json',
                    '!.gitignore',
                    '!.gitmodules'
                ],
                dest: 'release/<%= pkg.version %>/'
            }
        },
        compress: {
            main: {
                options: {
                    mode: 'zip',
                    archive: './release/ajax_search.<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'release/<%= pkg.version %>/',
                src: ['**/*'],
                dest: 'ajax_search/'
            }
        }
    });

    // Load other tasks
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-autoprefixer');

    // Default task.

    grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'sass', 'autoprefixer', 'cssmin']);
    grunt.registerTask('build', ['default', 'clean', 'copy', 'compress']);

    grunt.util.linefeed = '\n';
};