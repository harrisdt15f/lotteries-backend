import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../component/Login.vue'
import Login from '../component/Bet.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [{
        path: '/login',
        component: Login
    }, {
        path: '/bet',
        component: Bet
    }]
});

var app = new Vue({
    data: {},
    el: '#app',
    render: h => h(App),
    router,
    store,
    created() {
        this.checkLogin();
    },
    methods:{
        checkLogin(){
            if(!this.getCookie('session')) {
                //如果没有登录状态则跳转到登录页
                this.$router.push('/login');
            }else{
                // 否则跳转到登录后的页面
                this.$router.push('/bet');
            }
        }
    }
});
