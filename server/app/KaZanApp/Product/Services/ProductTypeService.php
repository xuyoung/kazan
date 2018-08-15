<?php
namespace App\KaZanApp\Product\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\Product\Entities\ProductTypeEntity;

/**
 * 产品类别service类，用来调用所需资源，提供和产品类别有关的服务。
 *
 * @author
 */
class ProductTypeService extends BaseService
{

    public function __construct(ProductTypeEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    /**
     * 产品管理--获取产品类别列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    产品类别列表和数量
     */
    public function getProductTypeListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getProductTypeTotal', 'getProductTypeList', $params);
    }

    /**
     * 产品管理--获取产品类别列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    产品类别列表
     */
    public function getProductTypeList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['product_type.product_type_id' => 'ASC'],
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
     * 产品管理--获取产品类别数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    产品类别数量
     */
    public function getProductTypeTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getProductTypeList($params);
    }

    /**
     * 产品管理--添加产品类别
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的产品类别
     */
    public function addProductType($data)
    {
        if (isset($data['product_type_name'])) {
            $productTypeNamePyArray       = convert_pinyin($data['product_type_name']);
            $data['product_type_name_py'] = isset($productTypeNamePyArray[0]) ? $productTypeNamePyArray[0] : '';
            $data['product_type_name_zm'] = isset($productTypeNamePyArray[1]) ? $productTypeNamePyArray[1] : '';
            $insertProductTypeData        = [
                'product_type_name'    => $data['product_type_name'],
                'product_type_name_py' => $data['product_type_name_py'],
                'product_type_name_zm' => $data['product_type_name_zm'],
            ];

            return $this->entity->insert($insertProductTypeData);
        }
    }

    /**
     * 产品管理--编辑产品类别
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的产品类别信息
     */
    public function editProduct($data, $productTypeId = '')
    {
        if (isset($data['product_type_id'])) {
            $data['product_type_id']                     = isset($data['product_type_id']) ? $data['product_type_id'] : $productTypeId;
            $productTypeNamePyArray                      = convert_pinyin($data['product_type_name']);
            $editProductTypeData                         = [];
            $editProductTypeData['product_type_name']    = isset($data['product_type_name']) ? $data['product_type_name'] : '';
            $editProductTypeData['product_type_name_py'] = isset($productTypeNamePyArray[0]) ? $productTypeNamePyArray[0] : '';
            $editProductTypeData['product_type_name_zm'] = isset($productTypeNamePyArray[1]) ? $productTypeNamePyArray[1] : '';

            return $this->entity->where(['product_type_id' => $data['product_type_id']])->update($editProductTypeData);
        }
    }

    /**
     * 产品管理--删除产品类别
     *
     * @author
     *
     * @param  int $productTypeId [产品类别ID]
     *
     * @since  2018-07-20 创建
     *
     * @return boolean
     */
    public function deleteProductType($productTypeId)
    {
        return $this->entity->where('product_type_id', $productTypeId)->delete();
    }

    /**
     * 产品管理--根据产品类别ID获取某个产品类别的信息
     *
     * @author
     *
     * @param  int $productTypeId [产品类别ID]
     *
     * @since  2018-07-20 创建
     *
     * @return array
     */
    public function getProductTypeInfo($productTypeId)
    {
        return $this->entity->where('product_type_id', $productTypeId)->first();
    }
}
