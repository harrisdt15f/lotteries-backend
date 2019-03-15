
<template>

    <div class = "loginFrame">
        <el-form ref = "AccountForm" :model = "account"   rules = "rules" label-position = "left" label-width = "0px" class = "demo-ruleForm login-container">
            <!--tab标签-->
            <el-tabs v-model = "activeName" @tab-click = "handleClick" class = "users">
                <el-tab-pane label = "学生" name = "students">学生</el-tab-pane>
                <el-tab-pane label = "教师" name = "teacher">老师</el-tab-pane>
                <el-tab-pane label = "教务老师" name = "eduTeacher">教务老师</el-tab-pane>
            </el-tabs>

            <el-form-item prop = "username">
                <el-input type = "text" v-model = "account_username" auto-complete = "off" placeholder = "请输入您的账号"></el-input></el-form-item>
            <el-form-item prop = "password"
            <el-input type = "password" v-model = "account_password" auto-complete = "off" placeholder = "请输入密码"></el-input></el-form-item>
            <el-checkbox v-model = "checked" checked class = "remember">记住密码</el-checkbox>
            <h3 class = "forgetpwd">忘记密码</h3>
            <el-form-item style = "width:100%;">
                <el-button type = "primary" style = "width:100%;" >登录</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script>
    export default {
        name: '登录',
        data() {
            return {
                logining : false,
                account : {
                    username:'',
                    password:'',
                },
                rules: {
                    username :[
                        {required: true, message: '请输入账号',trigger: 'blur'},
                        //{ validator: validaePass }
                    ],
                    password: [
                        {required: true,message: '请输入密码', trigger: 'blur'},
                        //{ validator: validaePass2 }
                    ]
                },
                checked: true

            };

        }
    }</script>

<style>
    body {
        background-image: url("./assets/zhongda.jpg");
        background-size:100%;
        background-repeat:no-repeat;
    }

    .login-container {
        width: 350px;
        margin-left: 35%
    }
</style>