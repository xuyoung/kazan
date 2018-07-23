<?php
namespace App\KaZanApp\ProductType\Entities;

use App\KaZanApp\Base\BaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 产品类别实体
 *
 * @author
 *
 * @since
 */
class ProductTypeEntity extends BaseEntity
{
    use SoftDeletes;

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 产品类别数据表
     *
     * @var string
     */
    public $table = 'product_type';

    /**
     * 主键
     *
     * @var string
     */
    public $primaryKey = 'product_type_id';

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
