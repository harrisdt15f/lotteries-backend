
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

//window.$ = window.jQuery = require('jquery');
try {
    window.$ = window.jQuery = require('jquery');
    global.$ = global.jQuery = require('jquery');
    //require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

try {
    let csrf_token = document.head.querySelector('meta[name="csrf-token"]');

    if (csrf_token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrf_token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    window.csrf_token= csrf_token.content;

    let auth_token = document.head.querySelector('meta[name="auth-token"]');
    if (auth_token) {
        window.axios.defaults.headers.common['X-Auth-Token'] = auth_token.content;
    }else{
        console.error('AUTH token not found!!!');
    }

    window.auth_token= auth_token.content;


    let hash_id = document.head.querySelector('meta[name="hash-id"]');
    if (hash_id) {
        window.hash_id= hash_id.content||'';
    }else{
        window.hash_id= '';
    }

} catch (e) {}

//引入公共库
require('./common/cookie');
require('./common/plugin');
