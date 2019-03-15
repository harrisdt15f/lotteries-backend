require('./bootstrap');

// window.Vue = require('vue');
//
// //Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

window.io = require('socket.io-client');

import Echo from "laravel-echo"

window.Echo = new Echo({
    authEndpoint : process.env.MIX_ECHO_VERIFY_HOST + process.env.MIX_ECHO_VERIFY_ENDPOINT,
    broadcaster: 'socket.io',
    host: process.env.MIX_ECHO_SERVER_HOST +":"+ process.env.MIX_ECHO_SERVER_PORT,
    namespace: 'App.Events',
    auth: {
        headers: {
            Authorization: 'Bearer ' + window.auth_token,
            'X-Auth-Token': window.auth_token,
            'X-CSRF-TOKEN': window.csrf_token,
        },
    }
});

window.Echo.private('User.' + window.hash_id)
    .listen('.userInfo', function(info) {
        //设置更新金额
        if (info.balance != null) {
            $("#balance").text(info.balance);
        }
    });

window.Echo.private('User.' + window.hash_id)
    .notification(function(notification) {
        //设置更新金额
    });
