<?php
namespace App\KaZanApp\User\Entities;

use App\KaZanApp\Base\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 用户实体
 *
 * @author
 *
 * @since
 */
class UserEntity extends BaseEntity
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
    public $primaryKey   = 'user_id';
    // public $incrementing = false;

    /**
     * 默认排序
     *
     * @var string
     */
    public $sort = 'desc';

    /**
     * 默认每页条数
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * 和 Role 的对应关系
     *
     * @return object
     */
    public function userHasOneRole()
    {
        return $this->hasOne('App\KaZanApp\Role\Entities\RoleEntity', 'role_id', 'role_id');
    }
}
