<?php
namespace App\KaZanApp\Attribute\Entities;

use App\KaZanApp\Base\BaseEntity;

/**
 * 属性类别实体
 *
 * @author
 *
 * @since
 */
class AttributeTypeEntity extends BaseEntity
{
    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * 公式数据表
     *
     * @var string
     */
    public $table = 'attribute_type';

    /**
     * 主键
     *
     * @var string
     */
    public $primaryKey   = 'attribute_type_id';

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
