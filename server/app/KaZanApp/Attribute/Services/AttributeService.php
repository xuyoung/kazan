<?php
namespace App\KaZanApp\Attribute\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\Attribute\Entities\AttributeTypeEntity;
use App\KaZanApp\Attribute\Entities\AttributeValueEntity;

/**
 * 属性service类，用来调用所需资源，提供和属性有关的服务。
 *
 * @author
 */
class AttributeService extends BaseService
{

    public function __construct(AttributeTypeEntity $attributeTypeEntity, AttributeValueEntity $attributeValueEntity)
    {
        parent::__construct();
        $this->attributeTypeEntity  = $attributeTypeEntity;
        $this->attributeValueEntity = $attributeValueEntity;
    }

    /**
     * 属性类别管理--获取属性类别列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    属性类别列表和数量
     */
    public function getAttributeTypeListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getAttributeTypeListTotal', 'getAttributeTypeList', $params);
    }

    /**
     * 属性类别管理--获取属性类别列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    属性类别列表
     */
    public function getAttributeTypeList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['attribute_type.attribute_type_id' => 'ASC'],
            'return_type' => 'array',
        ];
        $params = array_merge($default, $params);

        $query = $this->attributeTypeEntity->select($params['fields']);
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
     * 属性类别管理--获取属性类别数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    属性类别数量
     */
    public function getAttributeTypeListTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getAttributeTypeList($params);
    }

    public function addAttributeType($data)
    {
        if (isset($data['attribute_type_name'])) {
            $insertAttributeTypeData = [
                'attribute_type_name' => $data['attribute_type_name'],
            ];

            return $this->attributeTypeEntity->insert($insertAttributeTypeData);
        }
    }

    public function editAttributeType($data, $attributeTypeId = '')
    {
        if (isset($data['attribute_type_id']) || !empty($attributeTypeId)) {
            $data['attribute_type_id']                    = isset($data['attribute_type_id']) ? $data['attribute_type_id'] : $attributeTypeId;
            $editAttributeTypeData                        = [];
            $editAttributeTypeData['attribute_type_name'] = isset($data['attribute_type_name']) ? $data['attribute_type_name'] : '';
            return $this->attributeTypeEntity->update($editAttributeTypeData, ['attribute_type_id' => $data['attribute_type_id']]);
        }
    }

    public function deleteAttributeType($attributeTypeId)
    {
        return $this->attributeTypeEntity->where('attribute_type_id', $attributeTypeId)->delete();
    }

    public function getAttributeTypeInfo($attributeTypeId)
    {
        $attributeTypeInfo = $this->attributeTypeEntity->where('attribute_type_id', $attributeTypeId)->first();
        return $attributeTypeInfo;
    }

    /**
     * 属性值管理--获取属性值列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    属性值列表和数量
     */
    public function getAttributeValueListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getAttributeValueListTotal', 'getAttributeValueList', $params);
    }

    /**
     * 属性值管理--获取属性值列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    属性值列表
     */
    public function getAttributeValueList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['attribute_value.attribute_value_id' => 'ASC'],
            'return_type' => 'array',
        ];
        $params = array_merge($default, $params);

        $query = $this->attributeValueEntity->select($params['fields']);
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
     * 属性值管理--获取属性值数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    属性值数量
     */
    public function getAttributeValueListTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getAttributeValueList($params);
    }

    public function addAttributeValue($data)
    {
        if (isset($data['attribute_value_name']) && isset($data['attribute_type_id'])) {
            $insertAttributeValueData = [
                'attribute_type_id'    => $data['attribute_type_id'],
                'attribute_value_name' => $data['attribute_value_name'],
            ];

            return $this->attributeValueEntity->insert($insertAttributeValueData);
        }
    }

    public function editAttributeValue($data, $attributeValueId = '')
    {
        if (isset($data['attribute_value_id']) || !empty($attributeValueId)) {
            $data['attribute_value_id']                     = isset($data['attribute_value_id']) ? $data['attribute_value_id'] : $attributeValueId;
            $editAttributeValueData                         = [];
            $editAttributeValueData['attribute_value_name'] = isset($data['attribute_value_name']) ? $data['attribute_value_name'] : '';
            $editAttributeValueData['attribute_type_id']    = isset($data['attribute_type_id']) ? $data['attribute_type_id'] : '';
            return $this->attributeValueEntity->update($editAttributeValueData, ['attribute_value_id' => $data['attribute_value_id']]);
        }
    }

    public function deleteAttributeValue($attributeValueId)
    {
        return $this->attributeValueEntity->where('attribute_value_id', $attributeValueId)->delete();
    }

    public function getAttributeValueInfo($attributeValueId)
    {
        $attributeTypeInfo = $this->attributeValueEntity->where('attribute_value_id', $attributeValueId)->first();
        return $attributeTypeInfo;
    }
}
