"use strict";

var gulp = require("gulp");
var becklyn = require("becklyn-gulp");

var sassTask = becklyn.scss("src/**/Resources/assets/scss/**/*.scss");
var jsTask = becklyn.js("src/**/Resources/assets/js/*.js");

gulp.task("css",
    function ()
    {
        sassTask(false);
    }
);

gulp.task("js",
    function ()
    {
        jsTask(false);
    }
);


gulp.task("dev",
    function ()
    {
        sassTask(true);
        jsTask(true);
    }
);

gulp.task("release", ["default"]);
gulp.task("default", ["css", "js"]);
