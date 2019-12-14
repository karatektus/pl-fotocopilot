module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        clean: {
            app: {
                src: [
                    '../public/asset/*'
                ],
                options: {
                    force: true
                }
            }
        },
        sass: {
            options: {
                sourceMap: true
            },
            app: {
                files: {
                    '../public/asset/css/app.css': [
                        '../assets/scss/app.scss'
                    ],
                }
            }
        },
        googlefonts: {
            app: {
                options: {
                    fontPath: '../public/asset/fonts/',
                    cssFile: '../public/asset/css/fonts_app.css',
                    httpPath: '../fonts/',
                    formats: {
                        eot: true,
                        woff: true,
                        svg: true
                    },
                    fonts: [
                        {
                            family: 'Roboto',
                            styles: [
                                100, 300, 400, 500, 700, 900
                            ]
                        }
                    ]
                }
            }
        },
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1,
                keepSpecialComments: 0
            },
            app: {
                files: [
                    {
                        '../public/asset/css/app.min.css': [
                            '../public/asset/css/fonts_app.css',
                            'node_modules/bootstrap/dist/css/bootstrap.css',
                            'node_modules/toastr/build/toastr.css',
                            '../public/asset/css/app.css'
                        ]
                    }
                ]
            }
        },
        uglify: {
            options: {
                compress: true
            },
            app: {
                src: [
                    'node_modules/popper.js/dist/umd/popper.js',
                    'node_modules/block-ui/jquery.blockUI.js',
                    '../assets/js/pages/*',
                    '../assets/js/utils/*',
                    '../assets/js/app.js'
                ],
                dest: '../public/asset/js/app.dist.js'
            }
        },
        concat: {
            app: {
                src: [
                    'node_modules/jquery/dist/jquery.min.js',
                    'node_modules/toastr/build/toastr.min.js',
                    '../public/asset/js/app.dist.js'
                ],
                dest: '../public/asset/js/app.min.js'
            }
        },
        comments: {
            app: {
                options: {
                    singleline: true,
                    multiline: true,
                    keepSpecialComments: false
                },
                src: '../public/asset/js/app.min.js'
            }
        },
        copy: {
            app: {
                files: [
                    {
                        expand: true,
                        cwd: '../assets/img',
                        src: [
                            '*',
                            'favicon/*'
                        ],
                        dest: '../public/asset/img',
                        filter: 'isFile'
                    },
                    {
                        expand: true,
                        cwd: '../assets/font',
                        src: [
                            '*'
                        ],
                        dest: '../public/asset/font',
                        filter: 'isFile'
                    }
                ]
            }
        },
        uncss: {
            dist: {
                options: {
                    ignore: [
                        'opacity',
                        'slide',
                        'slideMs',
                        'slideUp',
                    ],
                },
                files: [{
                    nonull: true,
                    src: [
                        'http://fotocopilot.local.pluetzner.de',
                        'http://fotocopilot.local.pluetzner.de/imprint'
                    ],
                    dest: '../public/asset/css/app.tidy.min.css'
                }]
            }
        },
        watch: {
            app_style: {
                files: [
                    '../assets/*.scss',
                    '../assets/scss/components/*.scss',
                    '../assets/scss/pages/*.scss',
                    '../assets/scss/utils/*.scss',
                    '../assets/scss/widgets/*.scss',
                    '../assets/scss/*.scss'
                ],
                tasks: [
                    'style_app'
                ]
            },
            app_script: {
                files: [
                    '../assets/js/pages/*.js',
                    '../assets/js/utils/*.js',
                    '../assets/js/*.js'
                ],
                tasks: [
                    'script_app'
                ]
            },
            app_img: {
                files: [
                    '../assets/img/*'
                ],
                tasks: [
                    'copy'
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-google-fonts');
    grunt.loadNpmTasks('grunt-uncss');
    grunt.loadNpmTasks('grunt-stripcomments');


    grunt.registerTask('style_app', ['sass:app', 'cssmin:app']);
    grunt.registerTask('style', ['style_app']);

    grunt.registerTask('script_app', ['uglify:app', 'concat:app', 'comments:app']);
    grunt.registerTask('script_landing', ['uglify:landing']);
    grunt.registerTask('script', ['script_app']);

    grunt.registerTask('default', ['googlefonts', 'style', 'script', 'copy']);
    grunt.registerTask('prod', ['clean', 'default', 'uncss']);

};