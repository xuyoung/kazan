<?php

$routeConfig = [
    // 属性类别管理--获取属性类别列表数据
    ['attribute-type', 'getAttributeTypeListAndTotal'],
    ['attribute-type/attribute-types', 'getAttributeTypeListAndTotal', 'post'],
    // 属性类别管理--获取属性类别信息
    ['attribute-type/{attribute_type_id}', 'getAttributeTypeInfo'],
    // 属性类别管理--新建属性类别
    ['attribute-type', 'addAttributeType', 'post'],
    // 属性类别管理--编辑属性类别
    ['attribute-type/{attribute_type_id}', 'editAttributeType', 'post'],
    // 属性类别管理--删除属性类别
    ['attribute-type/{attribute_type_id}', 'deleteAttributeType', 'delete'],

    // 属性值管理--获取属性值列表数据
    ['attribute-value', 'getAttributeValueListAndTotal'],
    ['attribute-value/attribute-values', 'getAttributeValueListAndTotal', 'post'],
    // 属性值管理--获取属性值信息
    ['attribute-value/{attribute_value_id}', 'getAttributeValueInfo'],
    // 属性值管理--新建属性值
    ['attribute-value', 'addAttributeValue', 'post'],
    // 属性值管理--编辑属性值
    ['attribute-value/{attribute_value_id}', 'editAttributeValue', 'post'],
    // 属性值管理--删除属性值
    ['attribute-value/{attribute_value_id}', 'deleteAttributeValue', 'delete'],
];
