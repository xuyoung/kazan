<?php
namespace App\KaZanApp\Product\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\Product\Entities\ProductEntity;

/**
 * 产品service类，用来调用所需资源，提供和产品有关的服务。
 *
 * @author
 */
class ProductService extends BaseService
{

    public function __construct(ProductEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    /**
     * 产品管理--获取产品列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    产品列表和数量
     */
    public function getProductListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getProductTotal', 'getProductList', $params);
    }

    /**
     * 产品管理--获取产品列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    产品列表
     */
    public function getProductList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['product.product_id' => 'ASC'],
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
     * 产品管理--获取产品数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    产品数量
     */
    public function getProductTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getProductList($params);
    }

    /**
     * 产品管理--添加产品
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的产品
     */
    public function addProduct($data)
    {
        if (isset($data['product_name'])) {
            $productNamePyArray      = convert_pinyin($data['product_name']);
            $data['product_name_py'] = isset($productNamePyArray[0]) ? $productNamePyArray[0] : '';
            $data['product_name_zm'] = isset($productNamePyArray[1]) ? $productNamePyArray[1] : '';
            $insertProductData       = [
                'product_name'       => $data['product_name'],
                'attribute_type_id'  => isset($data['attribute_type_id']) ? $data['attribute_type_id'] : '',
                'attribute_value_id' => isset($data['attribute_value_id']) ? $data['attribute_value_id'] : '',
                'product_name_py'    => $data['product_name_py'],
                'product_name_zm'    => $data['product_name_zm'],
            ];

            return $this->entity->insert($insertProductData);
        }
    }

    /**
     * 产品管理--编辑产品
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的产品信息
     */
    public function editProduct($data, $productId = '')
    {
        if (isset($data['product_id'])) {
            $data['product_id']                    = isset($data['product_id']) ? $data['product_id'] : $productId;
            $productNamePyArray                    = convert_pinyin($data['product_name']);
            $editProductData                       = [];
            $editProductData['product_name']       = isset($data['product_name']) ? $data['product_name'] : '';
            $editProductData['product_name_py']    = isset($productNamePyArray[0]) ? $productNamePyArray[0] : '';
            $editProductData['product_name_zm']    = isset($productNamePyArray[1]) ? $productNamePyArray[1] : '';
            $editProductData['attribute_type_id']  = isset($data['attribute_type_id']) ? $data['attribute_type_id'] : '';
            $editProductData['attribute_value_id'] = isset($data['attribute_value_id']) ? $data['attribute_value_id'] : '';

            return $this->entity->where(['product_id' => $data['product_id']])->update($editProductData);
        }
    }

    /**
     * 产品管理--删除产品
     *
     * @author
     *
     * @param  int $productId [产品ID]
     *
     * @since  2018-07-20 创建
     *
     * @return boolean
     */
    public function deleteProduct($productId)
    {
        return $this->entity->where('product_id', $productId)->delete();
    }

    /**
     * 产品管理--根据产品ID获取某个产品的信息
     *
     * @author
     *
     * @param  int $productId [产品ID]
     *
     * @since  2018-07-20 创建
     *
     * @return array
     */
    public function getProductInfo($productId)
    {
        return $this->entity->where('product_id', $productId)->first();
    }
}
