<?php

$routeConfig = [
    // 角色管理--获取角色列表数据
    ['role', 'getRoleListAndTotal'],
    ['role/roles', 'getRoleListAndTotal', 'post'],
    // 角色管理--获取角色信息
    ['role/{role_id}', 'getRoleInfo'],
    // 角色管理--新建角色
    ['role', 'addRole', 'post'],
    // 角色管理--编辑角色
    ['role/{role_id}', 'editRole', 'post'],
    // 角色管理--删除角色
    ['role/{role_id}', 'deleteRole', 'delete'],
];
