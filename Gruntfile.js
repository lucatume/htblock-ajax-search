module.exports = function(grunt) {

    // Project configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concat: {
            options: {
                stripBanners: true
            },
            { %= js_safe_name %
            }: {
                src: [
                    'assets/js/src/headway_block_ajax_search.js'
                ],
                dest: 'assets/js/headway_block_ajax_search.js'
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
                    'assets/js/headway_block_ajax_search.min.js': ['assets/js/headway_block_ajax_search.js']
                },
                options: {
                    mangle: {
                        except: ['jQuery']
                    },
                    sourceMap: true
                }
            }
        },
        test: {
            files: ['assets/js/test/**/*.js']
        },
        { %
            if ('sass' === css_type) { %
            }
            sass: {
                all: {
                    options: {
                        sourcemap: true
                    },
                    files: {
                        'assets/css/headway_block_ajax_search.css': 'assets/css/sass/headway_block_ajax_search.scss'
                    }
                }
            },
            { %
            } else if ('less' === css_type) { %
            }
            less: {
                all: {
                    files: {
                        'assets/css/headway_block_ajax_search.css': 'assets/css/less/headway_block_ajax_search.less'
                    }
                }
            },
            { %
            } %
        }
        cssmin: {
            options: {
                banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
                    ' * <%= pkg.homepage %>\n' +
                    ' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
                    ' * Licensed GPLv2+' +
                    ' */\n'
            },
            minify: {
                expand: true,
                { %
                    if ('sass' === css_type || 'less' === css_type) { %
                    }
                    cwd: 'assets/css/',
                    src: ['headway_block_ajax_search.css'],
                    { %
                    } else { %
                    }
                    cwd: 'assets/css/src/',
                    src: ['headway_block_ajax_search.css'],
                    { %
                    } %
                }
                dest: 'assets/css/',
                ext: '.min.css'
            }
        },
        autoprefixer: {
            all: {
                options: {
                    browsers: ['last 2 versions']
                },
                src: 'assets/css/headway_block_ajax_search.css',
                dest: 'assets/css/headway_block_ajax_search.css'
            }
        },
        watch: {
            { %
                if ('sass' === css_type) { %
                }
                sass: {
                    files: ['assets/css/sass/*.scss'],
                    tasks: ['sass', 'autoprefixer:all', 'cssmin'],
                    options: {
                        debounceDelay: 500
                    }
                },
                { %
                } else if ('less' === css_type) { %
                }
                less: {
                    files: ['assets/css/less/*.less'],
                    tasks: ['sass', 'autoprefixer:all', 'cssmin'],
                    options: {
                        debounceDelay: 500
                    }
                },
                { %
                } else { %
                }
                styles: {
                    files: ['assets/css/src/*.css'],
                    tasks: ['autoprefixer:all', 'cssmin'],
                    options: {
                        debounceDelay: 500
                    }
                },
                { %
                } %
            }
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
                    archive: './release/headway_block_ajax_search.<%= pkg.version %>.zip'
                },
                expand: true,
                cwd: 'release/<%= pkg.version %>/',
                src: ['**/*'],
                dest: 'headway_block_ajax_search/'
            }
        }
    });

    // Load other tasks
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin'); { %
        if ('sass' === css_type) { %
        }
        grunt.loadNpmTasks('grunt-contrib-sass'); { %
        } else if ('less' === css_type) { %
        }
        grunt.loadNpmTasks('grunt-contrib-less'); { %
        } %
    }
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-autoprefixer');

    // Default task.
    { %
        if ('sass' === css_type) { %
        }
        grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'sass', 'autoprefixer', 'cssmin']); { %
        } else if ('less' === css_type) { %
        }
        grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'less', 'autoprefixer', 'cssmin']); { %
        } else { %
        }
        grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'autoprefixer', 'cssmin']); { %
        } %
    }

    grunt.registerTask('build', ['default', 'clean', 'copy', 'compress']);

    grunt.util.linefeed = '\n';
};