/* eslint-env node */

module.exports = {

    path: __dirname,

    input: 'app/newsletter.js',

    output: {
        file: 'app/newsletter.min.js',
        format: 'iife',
        globals: {
            'uikit': 'UIkit',
            'uikit-util': 'UIkit.util'
        }
    },

    external: ['uikit', 'uikit-util']

};
