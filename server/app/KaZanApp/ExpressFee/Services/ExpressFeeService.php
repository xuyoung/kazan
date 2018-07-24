<?php
namespace App\KaZanApp\ExpressFee\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\ExpressFee\Entities\ExpressFeeEntity;

/**
 * 快递费service类，用来调用所需资源，提供和快递费有关的服务。
 *
 * @author
 */
class ExpressFeeService extends BaseService
{

    public function __construct(ExpressFeeEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    /**
     * 快递费管理--获取快递费列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    快递费列表和数量
     */
    public function getExpressFeeListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getExpressFeeListTotal', 'getExpressFeeList', $params);
    }

    /**
     * 快递费管理--获取快递费列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    快递费列表
     */
    public function getExpressFeeList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['express_fee.express_fee_id' => 'ASC'],
            'return_type' => 'array',
        ];
        $params = array_merge($default, $params);

        $query = $this->entity->select($params['fields']);
        $query = $query->multiWheres($params['search'])->orders($params['order_by']);
        $query = $query->parsePage($params['page'], $params['limit']);
        if ($params['return_type'] == 'array') {
            return $query->get()->toArray();
        } else if ($params['return_type'] == 'count') {
            return $query->count();
        } else {
            return $query->get();
        }
    }

    /**
     * 快递费管理--获取快递费数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    快递费数量
     */
    public function getExpressFeeListTotal($params)
    {
        $params['page'] = 0;
        $params['return_type'] = 'count';
        return $this->getExpressFeeList($params);
    }

    public function addExpressFee($data)
    {
        if (isset($data['area']) && isset($data['first_weight']) && isset($data['first_fee'])) {
            $insertExpressFeeData = [
                'area'              => $data['area'],
                'first_weight'      => $data['first_weight'],
                'first_fee'         => $data['first_fee'],
                'additional_weight' => isset($data['additional_weight']) ? $data['additional_weight'] : 0,
                'additional_fee'    => isset($data['additional_fee']) ? $data['additional_fee'] : 0
            ];

            return $this->entity->insert($insertExpressFeeData);
        }
    }

    public function editExpressFee($data, $expressFeeId = '')
    {
        if (isset($data['express_fee_id']) || !empty($expressFeeId)) {
            $data['express_fee_id'] = isset($data['express_fee_id']) ? $data['express_fee_id'] : $expressFeeId;
            $editExpressFeeData                      = [];
            $editExpressFeeData['area']              = isset($data['area']) ? $data['area'] : '';
            $editExpressFeeData['first_weight']      = isset($data['first_weight']) ? $data['first_weight'] : '';
            $editExpressFeeData['first_fee']         = isset($data['first_fee']) ? $data['first_fee'] : '';
            $editExpressFeeData['additional_weight'] = isset($data['additional_weight']) ? $data['additional_weight'] : '';
            $editExpressFeeData['additional_fee']    = isset($data['additional_fee']) ? $data['additional_fee'] : '';

            return $this->entity->update($editExpressFeeData, ['express_fee_id' => $data['express_fee_id']]);
        }
    }

    public function deleteExpressFee($expressFeeId)
    {
        return $this->entity->where('express_fee__id', $expressFeeId)->delete();
    }

    public function getExpressFeeAllData($expressFeeId)
    {
        return $this->entity->where('express_fee__id', $expressFeeId)->first();
    }
}
