require('./bootstrap');
require('./common/fileupload');

import {AppViewModel} from "./viewmodel/AppViewModel"

window.AppViewModel= AppViewModel;

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