<?php

namespace App\Utils;

use App\Utils\Blogger;
use Cache;
use DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Redis;
use Request;
use Schema;


class Utils
{

    public static function envConfig($key, $default = null)
    {
        $documentRoot = dirname(getenv('DOCUMENT_ROOT'));
        if (empty($documentRoot)) {
            $documentRoot = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
        }

        $filePath = $documentRoot . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'config.ini';

        if (!file_exists($filePath)) {
            return env($key, $default);
        }

        $data = readLinesFromFile($filePath);

        $envFile = base_path('.env');
        if (is_file($envFile)) {
            $dataEnv = readLinesFromFile($envFile);
            $data    = array_merge($data, $dataEnv);
        }

        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }

    public static function readLinesFromFile($filePath)
    {
        static $data;

        $key = md5($filePath);
        if (isset($data[$key])) {
            return $data[$key];
        }

        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);

        $data       = [];
        $data[$key] = [];
        foreach ($lines as $line) {
            if (strpos($line, '=') === false) {
                continue;
            }

            if (strpos(ltrim($line), '#') === 0) {
                continue;
            }

            if (strpos(ltrim($line), '//') === 0) {
                continue;
            }

            list($k, $v)          = explode('=', $line);
            $data[$key][trim($k)] = trim($v);
        }

        return $data[$key];
    }

    public static function getConfigRoutes()
    {
        $apiSegment = Request::createFromGlobals()->segment(2);

        if ($apiSegment == 'user') {
            return ['User', 'Task', 'Portal'];
        }
        $routes = config('route');
        if (!isset($routes[$apiSegment])) {
            return [];
        }

        $module = $routes[$apiSegment];
        $modules = [$module];

        return $modules;
    }

    public static function addRoutes($app, $moduleDir, $modules, $parentDir = '')
    {
        if (empty($modules)) {
            return;
        }

        foreach ($modules as $key => $module) {
            if (is_array($module)) {
                addRoutes($app, $moduleDir, $module, $key);
                continue;
            }

            if (!empty($parentDir)) {
                $file       = $moduleDir . '/' . $parentDir . '/' . $module . '/routes.php';
                $controller = $parentDir . '\\' . $module . '\Controllers\\' . $module . 'Controller';
            } else {
                $file       = $moduleDir . '/' . $module . '/routes.php';
                $controller = $module . '\Controllers\\' . $module . 'Controller';
            }

            if (is_file($file)) {
                require $file;

                foreach ($routeConfig as $routeIndex => $routeInfo) {
                    $method = isset($routeInfo[2]) && is_string($routeInfo[2]) ? $routeInfo[2] : 'get';
                    $app->$method($routeInfo[0], $controller . '@' . $routeInfo[1]);
                }
            }
        }
    }

    public static function own($key)
    {
        $token = Request::input('api_token');
        if (empty($token)) {
            $token = Request::bearerToken();
        }

        if (empty($token)) {
            $token = Request::getPassword();
        }

        $authInfo = $token ? Cache::get($token) : [];
        if (!$authInfo) {
            return false;
        }
        $own = [
            'user_id'                => $authInfo['user_id'],
            'user_name'              => $authInfo['user_name'],
            'user_account'           => $authInfo['user_account'],
            'dept_id'                => $authInfo['dept_id'],
            'role_id'                => $authInfo['role_id'],
            'role_name'              => $authInfo['role_name'],

        ];

        return $key ? (isset($own[$key]) ? $own[$key] : '') : $own;
    }

    /**
     * @进行拼音的转换
     * @param string $str 需要进行拼音转换的字段
     */
    public static function convertPy($str)
    {
        $splitStr  = static::strSplitUtf8($str);
        $pinYinStr = "";
        $ZiMuStr   = "";

        for ($j = 0; $j < count($splitStr); $j++) {
            if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $splitStr[$j])) {
                //对新增加的字段的拼音进行处理的地方
                $pinyin = DB::table('pinyin')->where('hz', $splitStr[$j])->get();
                if ($pinyin) {
                    if (isset($pinyin[0])) {
                        $pinYinObj = $pinyin[0];
                        $pinYinStr .= $pinYinObj->py;
                        $ZiMuStr .= $pinYinObj->zm;
                    }
                }
            } else {
                $pinYinStr .= $splitStr[$j];
                $ZiMuStr .= $splitStr[$j];
            }
        }
        $pinYinarr = array($pinYinStr, $ZiMuStr);
        return $pinYinarr;
    }

    /**
     * @拆分字符串(处理字母、汉字、数字混合字符)
     * @param string $str 需拆分的字符串
     */
    public static function strSplitUtf8($str)
    {
        $split = 1;
        $array = array();

        for ($i = 0; $i < strlen($str);) {
            $value = ord($str[$i]);
            if ($value > 127) {
                if ($value >= 192 && $value <= 223) {
                    $split = 2;
                } elseif ($value >= 224 && $value <= 239) {
                    $split = 3;
                } elseif ($value >= 240 && $value <= 247) {
                    $split = 4;
                }

            } else {
                $split = 1;
            }

            $key = null;
            for ($j = 0; $j < $split; $j++, $i++) {
                $key .= $str[$i];
            }
            array_push($array, $key);
        }
        return $array;
    }

    /**
     * @获取系统参数
     * @param type $key
     * @param type $default
     * @return array|string 系统参数
     */
    public static function getSystemParam($key = null, $default = '')
    {
        if (is_null($key)) {
            return DB::table('system_params')->get();
        }
        $paramValue = '';
        $param      = DB::table('system_params')->where('param_key', $key)->get();
        if (count($param)) {
            $_param     = $param[0];
            $paramValue = $_param->param_value;
        }
        if ($paramValue == '') {
            return $default;
        }
        if (is_numeric($default)) {
            $paramValue = intval($paramValue);
        }
        return $paramValue;
    }

    public static function setSystemParam($key = null, $value = '')
    {
        if (is_null($key)) {
            return false;
        }

        if (DB::table('system_params')->where('param_key', $key)->count() == 0) {
            DB::table('system_params')->insert(['param_key' => $key, 'param_value' => $value]);
        } else {
            DB::table('system_params')->where('param_key', $key)->update(['param_value' => $value]);
        }

        return true;
    }

    /**
     * @返回成功响应信息
     * @param type $data 响应数据,data不传默认只返回状态
     * @return array 成功响应信息
     */
    public static function successResponse($data = false)
    {
        return static::handleResponse($data, 1, 'data');
    }

    /**
     * @返回警告响应信息
     * @param type $code 错误编码，为字符串或数组
     * @param type $langName 对应的语言包文件名
     * @param type $dynamic 动态错误信息，优先语言包使用 ；为字符串或数组(与错误编码数组元素对应写入)
     * @return array 警告响应信息
     */
    public static function warningResponse($code, $langName = '', $dynamic = '')
    {
        return static::handleResponse(static::handleErrorCode($code, $langName, $dynamic), 1);
    }

    /**
     * @返回错误响应信息
     * @param type $code 错误编码，为字符串或数组
     * @param type $langName 对应的语言包文件名
     * @param type $dynamic 动态错误信息，优先语言包使用 ；为字符串或数组(与错误编码数组元素对应写入)
     * @return array 错误响应信息
     */
    public static function errorResponse($code, $langName = '', $dynamic = '')
    {
        return static::handleResponse(static::handleErrorCode($code, $langName, $dynamic));
    }

    /**
     * @处理错误信息
     * @param type $code
     * @param type $langName
     * @param type $dynamic
     * @return array 错误信息
     */
    public static function handleErrorCode($code, $langName, $dynamic)
    {
        if (is_string($dynamic)) {
            $dynamic = [$dynamic];
        }
        if (is_string($code)) {
            return [[
                'code'    => $code,
                'message' => (isset($dynamic[0]) && $dynamic[0]) ? $dynamic[0] : trans($langName . '.' . $code),
            ]];
        }
        $errors = [];
        foreach ($code as $k => $v) {
            if (is_array($langName)) {
                $langCode = $langName[$k] . '.' . $v;
            } else {
                $langCode = $langName . '.' . $v;
            }
            $errors[] = [
                'code'    => $v,
                'message' => (isset($dynamic[$k]) && $dynamic[$k]) ? $dynamic[$k] : trans($langCode),
            ];
        }
        return $errors;
    }

    /**
     * @处理响应信息
     * @param type $messages
     * @param type $status
     * @param type $messageStatus
     * @return array 响应信息
     */
    public static function handleResponse($messages, $status = 0, $messageStatus = 'errors')
    {
        $result = ['status' => $status];
        if ($messages !== false) {
            $result[$messageStatus] = $messages;
        }
        if (defined('LUMEN_START')) {
            $result['runtime'] = round(microtime(true) - LUMEN_START, 3);
        }
        try {
            $user_id = isset($_COOKIE["loginUserId"]) ? $_COOKIE["loginUserId"] : "";

            $tempRegisterUserInfo = 'registerUserInfo_' . $user_id;
            if (Cache::has($tempRegisterUserInfo)) {
                $result['registerUserInfo'] = Cache::get($tempRegisterUserInfo);
            }
        } catch (\Exception $e) {
            //已有报错，不做处理
        }
        if (isset($result['runtime'])) {
            Blogger::longApiLog(Request::path(), $result['runtime']); //记录api执行时间
        }
        return $result;
    }

    //检查自定义路径的权限 并指定777
    public static function createCustomDir($path)
    {

        $uploadDir = getAttachmentDir();
        $path      = str_replace('\\', '/', $path);
        $pathes    = explode('/', $path);
        $dir       = $uploadDir;
        foreach ($pathes as $k => $v) {
            if ($v) {
                $dir .= $v . '/';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                    chmod($dir, 0777);
                }
            }
        }

        return $dir;
    }

    //等比例缩放图片
    public static function scaleImage($pic, $maxx = 80, $maxy = 60, $prefix = 'thumb_')
    {

        $info = getimageSize($pic); //获取图片的基本信息

        $w = $info[0]; //获取宽度
        $h = $info[1]; //获取高度
        //获取图片的类型并为此创建对应图片资源
        switch ($info[2]) {
            case 1: //gif
                $im = imagecreatefromgif($pic);
                break;
            case 2: //jpg
                $im = imagecreatefromjpeg($pic);
                break;
            case 3: //png
                $im = imagecreatefrompng($pic);
                break;
            default:
                die("图片类型错误！");
        }

        //计算缩放比例
        if (($maxx / $w) > ($maxy / $h)) {
            $b = $maxy / $h;
        } else {
            $b = $maxx / $w;
        }

        //计算出缩放后的尺寸
        $nw = floor($w * $b);
        $nh = floor($h * $b);

        //创建一个新的图像源(目标图像)
        $des = imagecreatetruecolor($nw, $nh);

        //执行等比缩放
        imagecopyresampled($des, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);

        //输出图像（根据源图像的类型，输出为对应的类型）
        $picinfo    = pathinfo($pic); //解析源图像的名字和路径信息
        $newpicname = $picinfo["dirname"] . DIRECTORY_SEPARATOR . $prefix . $picinfo["basename"];
        $newpic     = $prefix . $picinfo["basename"];
        switch ($info[2]) {
            case 1:
                imagegif($des, $newpicname);
                break;
            case 2:
                imagejpeg($des, $newpicname);
                break;
            case 3:
                imagepng($des, $newpicname);
                break;
        }
        //释放图片资源
        imagedestroy($im);
        imagedestroy($des);
        //返回结果
        return $newpic;
    }

    //64位base
    public static function imageToBase64($file)
    {
        $encoding = mb_detect_encoding($file, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        $file     = iconv($encoding, 'GBK', $file);
        if (!is_file($file)) {
            return '';
        }

        $type         = getimagesize($file); //取得图片的大小，类型等
        $fp           = fopen($file, "r") or die("Can't open file");
        $file_content = chunk_split(base64_encode(fread($fp, filesize($file)))); //base64编码
        switch ($type[2]) {
            //判读图片类型
            case 1:$img_type = "gif";
                break;
            case 2:$img_type = "jpg";
                break;
            case 3:$img_type = "png";
                break;
            case 6:$img_type = "bmp";
                break;
        }
        $img = 'data:image/' . $img_type . ';base64,' . $file_content; //合成图片的base64编码
        fclose($fp);
        return $img;
    }
    //日期类型分组字段x坐标
    public static function getDatexAxis($dateType, $dateValue)
    {
        $reportData = [];
        switch ($dateType) {
            //按年
            case 'year':
                $split = explode("-", $dateValue);
                if (count($split) == 2) {
                    for ($i = $split[0]; $i <= $split[1]; $i++) {
                        $reportData[$i] = array(
                            "name" => (string) $i,
                            "y"    => 0,
                        );
                    }
                }
                break;
            //按季度
            case 'quarter':
                $reportData[1] = array(
                    "name" => trans("report.report_firstQuarter"),
                    "y"    => 0,
                );
                $reportData[2] = array(
                    "name" => trans("report.report_secondQuarter"),
                    "y"    => 0,
                );
                $reportData[3] = array(
                    "name" => trans("report.report_thirdQuarter"),
                    "y"    => 0,
                );
                $reportData[4] = array(
                    "name" => trans("report.report_fourthQuarter"),
                    "y"    => 0,
                );
                break;
            //按月
            case 'month':
                for ($i = 1; $i <= 12; $i++) {
                    $reportData[$i] = array(
                        "name" => $i,
                        "y"    => 0,
                    );
                }
                break;
            //按天
            case 'day':
                //获取指定月的最后一天
                $lastDay = date('t', strtotime($dateValue));
                for ($i = 1; $i <= $lastDay; $i++) {
                    $reportData[$i] = array(
                        "name" => $i,
                        "y"    => 0,
                    );
                }
                break;
            default:
                break;
        }
        return $reportData;
    }
    //日期类型分组字段获取数据语句
    public static function getDateQuery($dateType, $dateValue, $dateFieldName)
    {
        $selectStr = "";
        $whereStr  = "";
        switch ($dateType) {
            //按年
            case 'year':
                $selectStr = " DATE_FORMAT(" . $dateFieldName . ", '%Y')  ";
                $whereStr  = "";
                break;
            //按季度
            case 'quarter':
                $selectStr = " quarter(" . $dateFieldName . ") ";
                $whereStr  = "  DATE_FORMAT(" . $dateFieldName . ", '%Y') = '" . $dateValue . "'  ";
                break;
            //按月
            case 'month':
                $selectStr = " DATE_FORMAT(" . $dateFieldName . ",'%c') ";
                $whereStr  = "  DATE_FORMAT(" . $dateFieldName . ", '%Y') = '" . $dateValue . "'  ";
                break;
            //按天
            case 'day':
                $selectStr = " DATE_FORMAT(" . $dateFieldName . ",'%e') ";
                $whereStr  = "  DATE_FORMAT(" . $dateFieldName . ", '%Y-%c') = '" . $dateValue . "'  ";
                break;
            default:
                break;
        }
        return array($selectStr, $whereStr);
    }
    //分析数据返回结果
    public static function parseDbRes(&$db_res, &$array)
    {
        if (is_array($db_res)) {
            // 0 和 null处理
            $new_arr = $result_arr = [];
            foreach ($db_res as $key => $item) {
                $item             = (array) $item;
                $item['group_by'] = isset($item['group_by']) && !empty($item['group_by']) ? $item['group_by'] : 0;
                if (isset($new_arr[$item['group_by']])) {
                    $temp_item = array_keys($item);
                    $temp_key  = isset($temp_item[0]) ? $temp_item[0] : '';
                    if ($temp_key) {
                        $new_arr[$item['group_by']][$temp_key] += intval($item[$temp_key]);
                    }
                } else {
                    $new_arr[$item['group_by']] = $item;
                }
            }
            $db_res = $new_arr;
            foreach ($db_res as &$v) {
                if (is_object($v)) {
                    $v = get_object_vars($v);
                }

                //多个数据分析字段
                foreach ($array as $k => &$item) {
                    if (isset($v[$k])) {
                        if (isset($v['group_by']) && isset($item[$v['group_by']])) {
                            $item[$v['group_by']]['y'] = (float) $v[$k];
                        } else {
                            if (isset($item['else'])) {
                                $item['else']['y'] = (float) $v[$k];
                            }

                        }
                    }
                }
            }
        }
    }
    //获取指定的目录 最后带斜杠的 F:/xxxx/attachment/
    public static function getAttachmentDir()
    {
        $attachBase = config('eoffice.attachmentDir');
        if (!$attachBase) {
            $attachBase = "attachment";
        }
        if (isset($_SERVER["DOCUMENT_ROOT"]) && !empty($_SERVER["DOCUMENT_ROOT"])) {
            $docPath = str_replace('\\', '/', $_SERVER["DOCUMENT_ROOT"]);
        } else {
            $docPath = str_replace('\\', '/', dirname(dirname(dirname(dirname(__DIR__)))));
        }
        $docPathTemp  = rtrim($docPath, "/");
        $docNum       = strripos($docPathTemp, "/");
        $docFinalPath = substr($docPathTemp, 0, $docNum);

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            //winos系统
            if (strripos($attachBase, ":/") || strripos($attachBase, ":\\")) {
                $uploadDir = rtrim(str_replace('\\', '/', $attachBase), "/") . DIRECTORY_SEPARATOR;
            } else {
                $attachBase = str_replace('\\', '/', $attachBase);
                $uploadDir  = rtrim($docFinalPath, "/") . "/" . ltrim($attachBase, "/");
            }
        } else {
            if (substr($attachBase, 0, 1) == DIRECTORY_SEPARATOR) {
                $uploadDir = rtrim(str_replace('\\', '/', $attachBase), "/") . DIRECTORY_SEPARATOR;
            } else {
                $attachBase = str_replace('\\', '/', $attachBase);
                $uploadDir  = rtrim($docFinalPath, "/") . "/" . ltrim($attachBase, "/");
            }
        }

        $uploadDir = str_replace('\\', '/', $uploadDir);
        return rtrim($uploadDir, "/") . "/";
    }

    /**
     * 内容转换为utf-8
     * @param  string $content 需要转换编码的内容
     * @return string          转化后的内容
     */
    public static function convertToUtf8($content)
    {

        //检测内容的编码
        $encode = mb_detect_encoding($content, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));

        return mb_convert_encoding($content, 'UTF-8', $encode);
    }

}
