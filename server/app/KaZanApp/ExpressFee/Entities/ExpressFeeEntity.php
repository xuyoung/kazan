<?php
namespace App\KaZanApp\ExpressFee\Entities;

use App\KaZanApp\Base\BaseEntity;

/**
 * 快递费实体
 *
 * @author
 *
 * @since
 */
class ExpressFeeEntity extends BaseEntity
{
    /**
     * 快递费数据表
     *
     * @var string
     */
    public $table = 'express_fee';

    /**
     * 主键
     *
     * @var string
     */
    public $primaryKey   = 'express_fee_id';

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
