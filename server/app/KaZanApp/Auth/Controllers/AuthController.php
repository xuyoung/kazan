<?php

namespace App\KaZanApp\Auth\Controllers;

use App\KaZanApp\Auth\Requests\AuthRequest;
use App\KaZanApp\Auth\Services\AuthService;
use App\KaZanApp\Base\Controller;
use Illuminate\Http\Request;

/**
 *     登录验证控制器
 *     @author 李志军
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
    public function quickLogin()
    {
        return $this->returnResult($this->authService->quickLogin($this->request->all()));
    }
    public function generalLoginQRCode()
    {
        return $this->returnResult($this->authService->generalLoginQRCode());
    }
    public function qrcodeSignOn()
    {
        return $this->returnResult($this->authService->qrcodeSignOn($this->request->all()));
    }
    /**
     *
     * @return type
     */
    public function singleSignOn()
    {
        return $this->returnResult($this->authService->singleSignOn($this->request->all()));
    }
    public function ssoRegisterInfo()
    {
        return $this->returnResult($this->authService->ssoRegisterInfo($this->request->input('token')));
    }
    /**
     * 验证apiToken是否过期，是否有效，是否合法
     * @return boolean
     */
    public function check()
    {
        return $this->returnResult($this->authService->check());
    }

    public function refresh()
    {
        return $this->returnResult($this->authService->refresh());
    }
    /**
     * @用户账号注销
     *
     * @param \App\Http\Requests\StoreTokenRequest $request
     *
     * @return json 注销成功失败信息
     */
    public function logout()
    {
        return $this->returnResult($this->authService->logout());
    }
    /**
     * 设置登录页主题
     *
     * @return boolean
     */
    public function setLoginTheme()
    {
        return $this->returnResult($this->authService->setLoginTheme($this->request->all()));
    }
    /**
     * 获取登录页主题
     *
     * @return 登录页主题
     */
    public function getLoginTheme()
    {
        return $this->returnResult($this->authService->getLoginTheme());
    }
    public function getLoginTemplateInfo()
    {
        return $this->returnResult($this->authService->getLoginTemplateInfo());
    }
    /**
     * 获取登录页logo
     *
     * @return 登录页logo
     */
    public function getLogo()
    {
        return $this->returnResult($this->authService->getLogo());
    }
    /**
     * 上传主题图片
     *
     * @return 主题图片缩略图
     */
    public function uploadThemeImage()
    {
        return $this->returnResult($this->authService->uploadThemeImage($this->request->all()));
    }

    public function setLogo()
    {
        return $this->returnResult($this->authService->setLogo($this->request->all()));
    }
    /**
     * 获取登录页主题图片
     *
     * @success array data 登录页主题图片数组
     * @successExample 成功返回示例:
     * [
     *  "123.jpg",
     *  "234.jpg"
     * ]
     */
    public function getLoginThemeImages()
    {
        return $this->returnResult($this->authService->getLoginThemeImages());
    }
    /**
     * 删除登录页主题图片
     *
     * @param string thumb 删除图片的缩略图名称
     *
     * @success int data 是否删除成功状态 1成功，0不成功
     * @successExample 成功返回示例:
     * {
     *    "status":1,
     *    "data":1
     * }
     * @errorExample 失败返回示例:
     * {
     *    "status":1,
     *    "data":0
     * }
     */
    public function deleteThemeImage()
    {
        return $this->returnResult($this->authService->deleteThemeImage($this->request->all()));
    }

    public function getLoginTemplate()
    {
        return $this->returnResult($this->authService->getLoginTemplate());
    }
    /**
     * 设置登录页模板
     *
     * @param string login_btn_color 按钮颜色
     */
    public function setLoginTemplate()
    {
        return $this->returnResult($this->authService->setLoginTemplate($this->request->all()));
    }
    public function getLoginBtnColor()
    {
        return $this->returnResult($this->authService->getLoginBtnColor());
    }
    /**
     * 设置登录按钮颜色
     *
     * @param string login_btn_color 按钮颜色
     * @paramExample 参数示例
     * {"login_btn_color": "rgba(66,140,213,0.5)"}
     */
    public function setLoginBtnColor()
    {
        return $this->returnResult($this->authService->setLoginBtnColor($this->request->all()));
    }
    public function modifyPassword()
    {
        return $this->returnResult($this->authService->modifyPassword($this->request->all()));
    }

    public function getWelcomeWord()
    {
        return $this->returnResult($this->authService->getWelcomeWord());
    }

    public function setWelcomeWord()
    {
        return $this->returnResult($this->authService->setWelcomeWord($this->request->all()));
    }
    public function allowMobile()
    {
        return $this->returnResult($this->authService->allowMobile());
    }
    //移动端返回基本信息
    public function appLoginInfo()
    {

        return $this->returnResult($this->authService->appLoginInfo());
    }
    /**
     * 验证手机用户是否授权
     *
     * @param string user_id 用户ID
     * @paramExample 参数示例
     * api/login/mobile-empower/admin
     *
     * @success string empowerName 授权名称
     * @success string expireDdate 授权过期日期
     * @success string machineCode 授权机器码
     * @success string mobileUserNumber 授权用户数
     * @success string version 授权版本
     *
     * @successExample 成功返回示例
     * {
     *  "empowerName":"研发",
     *  "machineCode":"05713D05C73D2927331F5B721A199EC0",
     *  "mobileUserNumber":"5000",
     *  "expireDdate":"2020-10-01",
     *  "version":"10.0WAP"
     * }
     */
    public function checkMobileEmpowerAndWapAllow($userId)
    {
        return $this->returnResult($this->authService->checkMobileEmpowerAndWapAllow($userId));
    }
    public function getUserDynamicCodeAuthStatus($userAccount)
    {
        return $this->returnResult($this->authService->getUserDynamicCodeAuthStatus($userAccount));
    }
    public function dynamicCodeSync()
    {
        return $this->returnResult($this->authService->dynamicCodeSync($this->request->all()));
    }
    public function getDynamicCodeSystemParamStatus()
    {
        return $this->returnResult($this->authService->getDynamicCodeSystemParamStatus());
    }
    public function getCaptcha($temp)
    {
        return $this->authService->getCaptcha($temp);
    }
    public function getSmsVerifyCode($phoneNumber)
    {
        return $this->returnResult($this->authService->getSmsVerifyCode($phoneNumber));
    }

    // 获取登录验证方式
    public function getLoginAuthType()
    {
        return $this->returnResult($this->authService->getLoginAuthType());
    }
    // CAS认证登出
    public function casLoginOut($loginUserId)
    {
        return $this->returnResult($this->authService->casLoginOut($loginUserId));
    }
}
