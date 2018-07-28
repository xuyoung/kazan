<?php
namespace App\KaZanApp\Formula\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\Formula\Entities\FormulaEntity;

/**
 * 公式service类，用来调用所需资源，提供和公式有关的服务。
 *
 * @author
 */
class FormulaService extends BaseService
{

    public function __construct(FormulaEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    /**
     * 公式管理--获取公式列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    公式列表和数量
     */
    public function getFormulaListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getFormulaListTotal', 'getFormulaList', $params);
    }

    /**
     * 公式管理--获取公式列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    公式列表
     */
    public function getFormulaList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['formula.formula_id' => 'ASC'],
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
     * 公式管理--获取公式数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    公式数量
     */
    public function getFormulaListTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getFormulaList($params);
    }

    public function addFormula($data)
    {
        if (isset($data['product_id']) && isset($data['formula_json']) && isset($data['cloth_size'])) {
            $insertFormulaData = [
                'product_id'   => $data['product_id'],
                'cloth_size'   => isset($data['cloth_size']) ? $data['cloth_size'] : '',
                'formula_json' => json_encode($data['formula_json']),
            ];

            return $this->entity->insert($insertFormulaData);
        }
    }

    public function editFormula($data, $formulaId = '')
    {
        if (isset($data['formula_id']) || !empty($formulaId)) {
            $data['formula_id']                    = isset($data['formula_id']) ? $data['formula_id'] : $formulaId;
            $editFormulaData                       = [];
            $editFormulaData['product_id']       = isset($data['product_id']) ? $data['product_id'] : '';
            $editFormulaData['cloth_size']         = isset($data['cloth_size']) ? $data['cloth_size'] : '';
            $editFormulaData['formula_json'] = isset($data['formula_json']) ? json_encode($data['formula_json']) : '';

            return $this->entity->update($editFormulaData, ['formula_id' => $data['formula_id']]);
        }
    }

    public function deleteFormula($formulaId)
    {
        return $this->entity->where('formula_id', $formulaId)->delete();
    }

    public function getFormulaInfo($formulaId)
    {
        $formulaInfo = $this->entity->where('formula_id', $formulaId)->first();
        if (!empty($formulaInfo) && isset($formulaInfo->formula_json)) {
            $formulaInfo->formula_json = json_decode($formulaInfo->formula_json);
        }
        return $formulaInfo;
    }
}
