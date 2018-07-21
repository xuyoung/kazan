<?php

$routeConfig = [
    // 快递费管理--获取快递费列表数据
    ['express-fee', 'getExpressFeeList'],
    ['express-fee/express-fees', 'getExpressFeeList', 'post'],
    // 快递费管理--获取快递费信息
    ['express-fee/{express_fee_id}', 'getExpressFeeInfo'],
    // 快递费管理--新建快递费
    ['express-fee', 'addExpressFee', 'post'],
    // 快递费管理--编辑快递费
    ['express-fee/{express_fee_id}', 'editExpressFee', 'post'],
    // 快递费管理--删除快递费
    ['express-fee/{express_fee_id}', 'deleteExpressFee', 'delete'],
];
