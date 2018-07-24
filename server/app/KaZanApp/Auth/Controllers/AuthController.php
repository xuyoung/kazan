<?php

namespace App\KaZanApp\Auth\Controllers;

use App\KaZanApp\Auth\Requests\AuthRequest;
use App\KaZanApp\Auth\Services\AuthService;
use App\KaZanApp\Base\Controller;
use Illuminate\Http\Request;

/**
 * 登录验证控制器
 * @author
 */
class AuthController extends Controller
{

    private $authService; //AuthService 对象

    /**
     * @构造函数用于注册AuthService 对象
     * @param \App\KaZanApp\Services\AuthService $authService
     */

    public function __construct(AuthService $authService, Request $request, AuthRequest $authRequest)
    {
        parent::__construct();
        $this->request = $request;
        $this->authService = $authService;
        $this->formFilter($request, $authRequest);
    }
    /**
     * 系统登录，获取登录信息
     *
     * @param string user_account 登录账户
     * @param string password 登录密码
     * @param string terminal 登录平台【pc或mobile】
     * @paramExample {json} 参数示例
     * {
     *  "user_account":"admin",
     *  "password":"123456",
     *  "terminal":"PC"
     * }
     *
     * @success {object} current_user 当前用户的信息
     * @success {object} im_config 及时通讯配置信息
     * @success {string} last_login_time 最后登录时间
     * @success {string} token 访问api的验证令牌
     * @successExample {json} 成功返回值示例
     * {
     *   "current_user":{
     *      "menus":{...},//菜单
     *      "system_info":{...},//系统配置信息
     *      "user_id":"admin",//用户ID
     *      "user_name":"系统管理员",//用户名称
     *      "user_has_many_role":[...],//用户角色数组
     *      ...//其他信息
     *   },
     *   "im_config":{
     *      "IM_ENCRYPT_KEY":"@#$%",
     *      "IM_HOST":"192.168.12.12",
     *      "IM_PORT":"4986"
     *   },
     *   "last_login_time":"2017-11-27 17:19:39",
     *   "token":"a23baebafd1e5b8f2ed40536a2e8d3903c5dadc786bbeadf37bd0c69a8145dc62f5a294d1a71d327e55a7c892ceae4fb30a0aec518c4ab5d550d256d1179150e"
     * }
     */
    public function login()
    {
        return $this->returnResult($this->authService->login($this->request->all()));
    }

    /**
     * 验证apiToken是否过期，是否有效，是否合法
     * @return boolean
     */
    public function check()
    {
        return $this->returnResult($this->authService->check());
    }

    /**
     * @用户账号注销
     *
     * @param \App\Http\Requests\StoreTokenRequest $request
     *
     * @return json 注销成功失败信息
     */
    public function loginOut()
    {
        return $this->returnResult($this->authService->loginOut());
    }

    //移动端返回基本信息
    public function appLoginInfo()
    {
        return $this->returnResult($this->authService->appLoginInfo());
    }
}
