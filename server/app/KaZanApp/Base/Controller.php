<?php

namespace App\KaZanApp\Base;

use Cache;
use Illuminate\Validation\Validator;
use Lang;
use Laravel\Lumen\Routing\Controller as BaseController;
use Request;

class Controller extends BaseController
{
    protected $own;

    /** @var string 表单验证错误码*/
    private $formValidationCode;
    public $apiToken;
    public function __construct()
    {
        // $this->setGlobalInfo();
    }

    /**
     * 设置系统全局信息
     */
    private function setGlobalInfo()
    {
        $route      = Request::route();
        $routeArray = explode('@', $route[1]['uses']);

        $this->setLocale();

        if ($routeArray[0] != 'App\KaZanApp\Auth\Controllers\AuthController') {
            $this->registerOwnInfo();
            if (env_config('APP_DEBUG', false)) {
                //$this->middleware("routeVisitsRecord");
            }
        }
    }
    /**
     * 注册个人信息
     */
    private function registerOwnInfo()
    {
        if ($authInfo = $this->getAuthInfo()) {
            $this->own = [
                'user_id'                => $authInfo['user_id'],
                'user_name'              => $authInfo['user_name'],
                'user_accounts'          => $authInfo['user_accounts'],
                'user_job_number'        => $authInfo['user_job_number'],
                'list_number'            => $authInfo['listnumber'],
                'user_name_py'           => $authInfo['user_name_py'],
                'user_name_zm'           => $authInfo['user_name_zm'],
                'user_position_name'     => isset($authInfo['user_position_name']) ? $authInfo['user_position_name'] : '',
                'dept_id'                => $authInfo['userHasOneSystemInfo']['dept_id'],
                'max_role_no'            => $authInfo['userHasOneSystemInfo']['max_role_no'],
                'post_priv'              => $authInfo['userHasOneSystemInfo']['post_priv'],
                'post_dept'              => $authInfo['userHasOneSystemInfo']['post_dept'],
                'last_visit_time'        => $authInfo['userHasOneSystemInfo']['last_visit_time'],
                'last_pass_time'         => $authInfo['userHasOneSystemInfo']['last_pass_time'],
                'shortcut'               => $authInfo['userHasOneSystemInfo']['shortcut'],
                'sms_login'              => $authInfo['userHasOneSystemInfo']['sms_login'],
                'wap_allow'              => $authInfo['userHasOneSystemInfo']['wap_allow'],
                'login_usbkey'           => $authInfo['userHasOneSystemInfo']['login_usbkey'],
                'usbkey_pin'             => $authInfo['userHasOneSystemInfo']['usbkey_pin'],
                'user_status'            => $authInfo['userHasOneSystemInfo']['user_status'],
                'is_autohrms'            => $authInfo['userHasOneSystemInfo']['is_autohrms'],
                'dept_name'              => $authInfo['userHasOneSystemInfo']['userSystemInfoBelongsToDepartment']['dept_name'],
                'sex'                    => $authInfo['userHasOneInfo']['sex'],
                'birthday'               => $authInfo['userHasOneInfo']['birthday'],
                'dept_phone_number'      => $authInfo['userHasOneInfo']['dept_phone_number'],
                'faxes'                  => $authInfo['userHasOneInfo']['faxes'],
                'home_address'           => $authInfo['userHasOneInfo']['home_address'],
                'home_phone_number'      => $authInfo['userHasOneInfo']['home_phone_number'],
                'phone_number'           => $authInfo['userHasOneInfo']['phone_number'],
                'weixin'                 => $authInfo['userHasOneInfo']['weixin'],
                'email'                  => $authInfo['userHasOneInfo']['email'],
                'oicq_no'                => $authInfo['userHasOneInfo']['oicq_no'],
                'msn'                    => $authInfo['userHasOneInfo']['msn'],
                'notes'                  => $authInfo['userHasOneInfo']['notes'],
                'theme'                  => $authInfo['userHasOneInfo']['theme'],
                'avatar_type'            => $authInfo['userHasOneInfo']['avatar_type'],
                'signature_picture_type' => $authInfo['userHasOneInfo']['signature_picture_type'],
                'avatar_type'            => $authInfo['userHasOneInfo']['avatar_type'],
                'menu_hide'              => $authInfo['userHasOneInfo']['menu_hide'],
                'attendance_scheduling'  => $authInfo['user_has_one_attendance_scheduling_info']['scheduling_id'],
                'role_id'                => $this->parseRoles($authInfo['userHasManyRole'], 'role_id'),
                'role_name'              => $this->parseRoles($authInfo['userHasManyRole'], 'role_name'),
                'role_array'             => $this->parseRoles($authInfo['userHasManyRole'], 'role_array'),
                'menus'                  => $authInfo['menus'],
                'superior'               => $this->parseSuperiorSubordinate($authInfo['userHasManySuperior'], 'superior'),
                'subordinate'            => $this->parseSuperiorSubordinate($authInfo['userHasManySubordinate'], 'subordinate'),
                'userHasManySuperior'    => $authInfo['userHasManySuperior'],
                'userHasManySubordinate' => $authInfo['userHasManySubordinate'],
            ];
        }
    }
    private function parseRoles($roles, $type)
    {
        if (empty($roles)) {
            return [];
        }
        static $parseRole = array();

        if (!empty($parseRole)) {
            return $parseRole[$type];
        }
        $roleId = $roleName = $roleArray = [];

        foreach ($roles as $role) {
            $roleId[]   = $role['role_id'];
            $roleName[] = $roleArray[$role['role_id']] = $role['hasOneRole']['role_name'];
        }

        $parseRole = ['role_id' => $roleId, 'role_name' => $roleName, 'role_array' => $roleArray];

        return $parseRole[$type];
    }

    private function parseSuperiorSubordinate($dataObj, $type)
    {
        $data = $dataObj->toArray();

        if (empty($data)) {
            return [];
        }

        if ($type == 'superior') {
            $k = 'superior_user_id';
        } else if ($type == 'subordinate') {
            $k = 'user_id';
        }

        return array_column($data, $k);
    }

    /**
     * 获取权限信息
     * @return boolean
     */
    private function getAuthInfo()
    {
        $token          = $this->getApiToken();
        $this->apiToken = $token;
        if ($token) {
            return Cache::get($token);
        }

        return false;
    }
    private function getApiToken()
    {
        static $apiToken = null;

        if ($apiToken != null) {
            return $apiToken;
        } else {
            $token = Request::input('api_token');
            if (empty($token)) {
                $token = Request::bearerToken();
            }

            if (empty($token)) {
                $token = Request::getPassword();
            }
            if ($token) {
                return $apiToken = $token;
            }

            return $apiToken = false;
        }
    }
    /**
     * 批量处理返回值
     *
     * @param array|int $result 返回结果
     *
     * @return json json格式返回值
     *
     * @author qishaobo
     *
     * @since  2016-02-17 创建
     */
    protected function returnResult($result)
    {
        if (is_array($result)) {
            if (isset($result['code'])) {
                $dynamic = isset($result['dynamic']) ? $result['dynamic'] : '';

                return error_response($result['code'][0], $result['code'][1], $dynamic);
            }

            if (isset($result['error'])) {
                $dynamic = isset($result['dynamic']) ? $result['dynamic'] : '';

                return error_response($result['error'][0], $result['error'][1], $dynamic);
            }

            if (isset($result['warning'])) {
                $dynamic = isset($result['dynamic']) ? $result['dynamic'] : '';

                return warning_response($result['warning'][0], $result['warning'][1], $dynamic);
            }
        }
        return success_response($result === true ? false : $result);
    }

    /**
     * 设置本地化语言
     *
     * @return
     *
     * @author qishaobo
     *
     * @modify lizhijun
     *
     * @since  2016-02-17 创建
     */
    private function setLocale()
    {
        $token = $this->getApiToken();

        if ($token) {
            if (Cache::has($token . '_local')) {
                Lang::setLocale(Cache::get($token . '_local'));
            }
        } else {
            if (Request::has('local')) {
                Lang::setLocale(Request::input('local'));
            }
        }

        return true;
    }

    /**
     * 表单验证
     *
     * @param Illuminate\Http\Request $request 请求
     * @param App\Http\Requests\Request $formRequest 验证规则类
     *
     * @return
     *
     * @author qishaobo
     *
     * @since  2016-02-17 创建
     */
    protected function formFilter($request, $formRequest)
    {
        $method = $request->method();
        if ($method == 'POST' || $method == 'PUT') {
            $this->formValidationCode = $formRequest->errorCode ?: '0x000111';
            $this->rules              = $formRequest->rules($request);
            $this->validate($request, $this->rules);
        }
    }

    /**
     * 表单验证失败返回
     *
     * @return json 表单验证失败返回结果
     *
     * @author qishaobo
     *
     * @since  2016-02-17 创建
     */
    protected function formatValidationErrors(Validator $validator)
    {
        $error      = $validator->errors()->all();
        $rules      = array_keys($this->rules);
        $search     = $replace     = [];
        $class      = Request::route()[1]['uses'];
        $classNames = explode('\\', explode('@', $class)[0]);
        $className  = str_replace('controller', '', strtolower(array_pop($classNames)));

        foreach ($rules as $field) {
            $search[]  = str_replace('_', ' ', $field);
            $replace[] = trans($className . '.' . $field);
        }

        foreach ($error as $k => $v) {
            $error[$k] = str_replace($search, $replace, $v);
        }

        echo json_encode(error_response(array_fill(0, count($error), $this->formValidationCode), '', $error));
        exit;
        /*
    $errors = [
    array_fill(0, count($error), $this->formValidationCode),
    $error
    ];
    return $this->returnResult(['error' => $errors]);
     */
    }

}
