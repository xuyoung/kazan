<?php
namespace App\KaZanApp\Role\Entities;

use App\KaZanApp\Base\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 角色实体
 *
 * @author
 *
 * @since
 */
class RoleEntity extends BaseEntity
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 角色数据表
     *
     * @var string
     */
    public $table = 'role';

    /**
     * 主键
     *
     * @var string
     */
    public $primaryKey   = 'role_id';

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
}
