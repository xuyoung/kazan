<?php

$routeConfig = [
    // 产品管理--获取产品列表数据
    ['product/product', 'getProductListAndTotal'],
    ['product/products', 'getProductListAndTotal', 'post'],
    // 产品管理--获取产品信息
    ['product/product/{product_id}', 'getProductInfo'],
    // 产品管理--新建产品
    ['product/product', 'addProduct', 'post'],
    // 产品管理--编辑产品
    ['product/product/{product_id}', 'editProduct', 'post'],
    // 产品管理--删除产品
    ['product/product/{product_id}', 'deleteProduct', 'delete'],

    // 产品管理--获取产品类别列表数据
    ['product/product-type', 'getProductTypeListAndTotal'],
    ['product/product-types', 'getProductTypeListAndTotal', 'post'],
    // 产品管理--获取产品类别信息
    ['product/product-type/{type_id}', 'getProductTypeInfo'],
    // 产品管理--新建产品类别
    ['product/product-type', 'addProductType', 'post'],
    // 产品管理--编辑产品类别
    ['product/product-type/{type_id}', 'editProductType', 'post'],
    // 产品管理--删除产品类别
    ['product/product-type/{type_id}', 'deleteProductType', 'delete'],
];
