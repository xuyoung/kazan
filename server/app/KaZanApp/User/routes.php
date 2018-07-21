<?php

$routeConfig = [
    // 用户管理--获取用户列表数据
    ['user', 'getUserListAndTotal'],
    ['user/users', 'getUserListAndTotal', 'post'],
    // 用户管理--获取用户信息
    ['user/{user_id}', 'getUserAllData'],
    // 用户管理--新建用户
    ['user', 'addUser', 'post'],
    // 用户管理--编辑用户
    ['user/{user_id}', 'editUser', 'post'],
    // 用户管理--删除用户
    ['user/{user_id}', 'deleteUser', 'delete'],
    // 用户管理--修改密码
    ['user/modify-password/{user_id}', 'modifyUserPassword'],
];
