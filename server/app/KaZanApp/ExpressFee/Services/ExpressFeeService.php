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

    public function editExpressFee($data)
    {
        if (isset($data['express_fee_id'])) {
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
