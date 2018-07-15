<?php

namespace App\KaZanApp\Auth\Services;

use App\KaZanApp\Base\BaseService;
use Cache;
use DB;

/**
 * @权限验证服务类，用于系统登录验证，注销。
 *
 * @author
 */
class AuthService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 系统登录
     *
     * @param type $data
     *
     * @return userInfo
     */
    public function login($data)
    {
        return 111;
    }
}
