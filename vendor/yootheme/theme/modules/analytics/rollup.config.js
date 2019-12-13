/* eslint-env node */

module.exports = {

    path: __dirname,

    input: 'app/analytics.js',

    output: {
        file: 'app/analytics.min.js',
        format: 'iife'
    }

};
