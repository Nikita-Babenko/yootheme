/* eslint-env node */

module.exports = {

    path: __dirname,

    input: 'app/cookie.js',

    output: {
        file: 'app/cookie.min.js',
        format: 'iife',
        globals: {
            'uikit': 'UIkit',
            'uikit-util': 'UIkit.util'
        }
    },

    external: ['uikit', 'uikit-util']

};
