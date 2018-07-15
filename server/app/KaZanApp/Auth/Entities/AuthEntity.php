<?php
namespace App\KaZanApp\Auth\Entities;

use App\KaZanApp\Base\BaseEntity;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * 用户实体
 *
 * @author lizhijun
 *
 * @since  2015-10-16 创建
 */
class AuthEntity extends BaseEntity implements Authenticatable
{
    /**
     * 用户数据表
     *
     * @var string
     */
    public $table = 'user';

    /**
     * 主键
     *
     * @var string
     */
    public $primaryKey = 'user_id';
    public $casts      = ['user_id' => 'string'];

    public function getAuthIdentifier()
    {

    }

    public function getAuthIdentifierName()
    {

    }

    public function getAuthPassword()
    {

    }

    public function getRememberToken()
    {

    }

    public function getRememberTokenName()
    {

    }

    public function setRememberToken($value)
    {

    }

}
