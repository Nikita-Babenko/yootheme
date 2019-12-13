/* eslint-env node */

module.exports = {

    path: __dirname,

    input: 'app/map.js',

    output: {
        file: 'app/map.min.js',
        format: 'iife',
        globals: {
            'uikit': 'UIkit',
            'uikit-util': 'UIkit.util'
        }
    },

    external: ['uikit', 'uikit-util']

};
