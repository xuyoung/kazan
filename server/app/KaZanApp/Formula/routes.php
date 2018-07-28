<?php

$routeConfig = [
    // 公式管理--获取公式列表数据
    ['formula', 'getFormulaListAndTotal'],
    ['formula/formulas', 'getFormulaListAndTotal', 'post'],
    // 公式管理--获取公式信息
    ['formula/{formula_id}', 'getFormulaInfo'],
    // 公式管理--新建公式
    ['formula', 'addFormula', 'post'],
    // 公式管理--编辑公式
    ['formula/{formula_id}', 'editFormula', 'post'],
    // 公式管理--删除公式
    ['formula/{formula_id}', 'deleteFormula', 'delete'],
];
