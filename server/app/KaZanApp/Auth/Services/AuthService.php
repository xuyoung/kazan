<?php

namespace App\KaZanApp\Auth\Services;

use App\KaZanApp\Base\BaseService;
use Cache;
use Illuminate\Http\Request;
use Lang;

/**
 * @权限验证服务类，用于系统登录验证，注销。
 *
 * @author
 */
class AuthService extends BaseService
{
    private $errors;

    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->userService = app('App\KaZanApp\User\Services\UserService');
    }

    /**
     * 系统登录
     *
     * @param type $data
     *
     * @return
     */
    public function login($data)
    {
        if (isset($data['user_account'])) {
            $password = isset($data['password']) ? $data['password'] : '';
            $user     = $this->checkAccount($data['user_account'], $password);
            return $this->errors ? $this->errors : $this->generateInitInfo($user, $data);
        }
    }

    public function loginOut()
    {
        if (!$token = $this->getTokenForRequest()) {
            return ['code' => ['0x001001', 'auth']];
        }
        Cache::forget($token);
        Cache::forget($token . '_last_login_time');
        return true;
    }

    /**
     * 注册系统初始信息
     *
     * @param array $user
     *
     * @return
     */
    public function generateInitInfo($user)
    {
        $token = $this->generateToken($user->user_id);
        return $this->combineUser($token, $user, function ($token, $user) {
            Cache::forever($token, $user);
            Cache::forever($token . '_last_login_time', time());
            return $user;
        });
    }

    /**
     * 生成token
     *
     * @param int $userId
     *
     * @return
     */
    private function generateToken($userId)
    {
        $tokenSecret = config('auth.token_secret');
        $tokenAlgo = config('auth.token_algo');
        return hash($tokenAlgo, $userId . time() . $tokenSecret, false);
    }

    /**
     * 合法性验证
     *
     * @param int $userId
     *
     * @return
     */
    public function check()
    {
        if (!$token = $this->getTokenForRequest()) {
            return ['code' => ['0x001001', 'auth']];
        }

        if (!Cache::has($token)) {
            return ['code' => ['0x001003', 'auth']];
        }

        $lastVisitTime = Cache::get($token . '_last_login_time');
        $tokenTtl = config('auth.token_ttl');

        if ((time() - $lastVisitTime) > ($tokenTtl * 60)) {
            return ['code' => ['0x001008', 'auth']];
        }

        Cache::forever($token . '_last_login_time', time());

        return true;
    }

    /**
     * appLoginInfo
     *
     * @param int $userId
     *
     * @return
     */
    public function appLoginInfo()
    {
        if (!$token = $this->getTokenForRequest()) {
            return ['code' => ['0x001001', 'auth']];
        }

        if (!$user = Cache::get($token)) {
            return false;
        }

        return $this->combineUser($token, $user, function ($token, $user) {
            return $user;
        });
    }

    /**
     * 获取token
     *
     * @param
     *
     * @return
     */
    private function getTokenForRequest()
    {
        $token = $this->request->input('api_token');

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    /**
     * 验证账号，密码
     *
     * @param string $userAccount
     * @param string $password
     *
     * @return array 用户信息
     */
    private function checkAccount($userAccount, $password)
    {
        //验证账号
        $user = $this->userService->getUserByAccount($userAccount);

        if (empty($user)) {
            return $this->errors = ['code' => ['0x001004', 'auth']];
        }

        //验证密码
        if ($user->password != crypt($password, $user->password)) {
            if (strlen($password) > 5) {
                $pattern     = '/(\w{2})(\w{0,})(\w{2})/i';
                $replacement = '$1***$3';
                $resStr      = preg_replace($pattern, $replacement, $password);
            } else {
                $resStr = $password;
            }

            return $this->errors = ['code' => ['0x001005', 'auth']];
        }

        return $user;
    }

    /**
     * 组装用户初始化信息
     *
     * @param string $token
     * @param object $user
     * @param Closure $terminal
     *
     * @return array
     */
    private function combineUser($token, $user, $terminal)
    {
        $user = $terminal($token, $user);

        $lastLoginTime = date('Y-m-d H:i:s');

        return [
            'token'           => $token,
            'current_user'    => $user,
            'last_login_time' => $lastLoginTime,
            'im_config'       => [
                'IM_PORT'        => env_config('IM_PORT'),
                'IM_HOST'        => env_config('IM_HOST'),
                'IM_ENCRYPT_KEY' => env_config('IM_ENCRYPT_KEY'),
            ],
        ];
    }

}
