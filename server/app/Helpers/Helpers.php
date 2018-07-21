<?php

use App\Utils\Utils;
use Illuminate\Support\Facades\Lang;

if (!function_exists('success_response')) {
    function success_response($data = false)
    {
        return Utils::successResponse($data);
    }
}

if (!function_exists('warning_response')) {
    function warning_response($code, $langName = '', $dynamic = '')
    {
        return Utils::warningResponse($code, $langName, $dynamic);
    }
}

if (!function_exists('error_response')) {
    function error_response($code, $langName = '', $dynamic = '')
    {
        return Utils::errorResponse($code, $langName, $dynamic);
    }
}

/**
 * 翻译语言包
 */
if (!function_exists('trans')) {
    function trans($name, $replace = [], $local = null)
    {
        return Lang::get($name, $replace, $local);
    }
}

/**
 * 读取配置文件
 */
if (!function_exists("env_config")) {
    function env_config($key, $default = null)
    {
        return Utils::envConfig($key, $default);
    }
}

/**
 * 读取配置文件路由
 */
if (!function_exists('get_config_routes')) {
    function get_config_routes()
    {
        return Utils::getConfigRoutes();
    }
}

/**
 * 添加路由
 */
if (!function_exists('add_routes')) {
    function add_routes($app, $moduleDir, $modules, $parentDir = '')
    {
        return Utils::addRoutes($app, $moduleDir, $modules, $parentDir = '');
    }
}

/**
 * 字符串转全拼和简拼
 */
if (!function_exists('convert_pinyin')) {
    function convert_pinyin($str)
    {
        return Utils::convertPy($str);
    }
}

if (!function_exists("readLinesFromFile")) {
    function readLinesFromFile($filePath)
    {
        return Utils::readLinesFromFile($filePath);
    }
}