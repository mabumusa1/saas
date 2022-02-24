const glob = require('glob');

// Keenthemes' plugins
var componentJs = glob.sync(`resources/assets/core/js/components/*.js`) || [];
var coreLayoutJs = glob.sync(`resources/assets/core/js/layout/*.js`) || [];

// Layout base js
var layoutJs = glob.sync(`resources/assets/demo1/js/layout/*.js`) || [];

module.exports = [
    ...componentJs,
    ...coreLayoutJs,
    ...layoutJs,

    // Extended
    'resources/assets/extended/search.js',
    'resources/assets/extended/button-ajax.js'
];
