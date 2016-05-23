module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        less: {
            dist: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 2
                },
                files: {
                    "web/css/main.css": [
                        "bower_components/bootstrap/dist/css/bootstrap.css",
                    ]
                }
            }
        },
        uglify: {
            options: {
                mangle: false,
                sourceMap: true
            },
            dist: {
                files: {
                    'web/js/main.js': [
                        "bower_components/jquery/dist/jquery.min.js",
                        'web/bundles/fosjsrouting/js/router.js'
                    ],
                    'web/js/grid_creation.js': [
                        "src/MagicWordBundle/Resources/public/js/bologne.js",
                        "src/MagicWordBundle/Resources/public/js/grid_create.js"
                    ]

                }
            }
        }
    });

    grunt.registerTask('default', ["less", "uglify"]);
};
