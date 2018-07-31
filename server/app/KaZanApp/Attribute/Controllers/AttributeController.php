<?php
namespace App\KaZanApp\Attribute\Controllers;

use Illuminate\Http\Request;
use App\KaZanApp\Base\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 属性 controller ，实现属性管理菜单的所有内容，以及所有和属性模块相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class AttributeController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->attributeService = app('App\KaZanApp\Attribute\Services\AttributeService');
        $this->attributeRequest = app('App\KaZanApp\Attribute\Requests\AttributeRequest');
        $this->formFilter($request, $this->attributeRequest);
        $this->request = $request;
    }

    public function getAttributeTypeListAndTotal()
    {
        $result = $this->attributeService->getAttributeTypeListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    public function addAttributeType()
    {
        $result = $this->attributeService->addAttributeType($this->request->all());
        return $this->returnResult($result);
    }

    public function editAttributeType($attributeTypeId)
    {
        $result = $this->attributeService->editAttributeType($this->request->all(), $attributeTypeId);
        return $this->returnResult($result);
    }

    public function deleteAttributeType($attributeTypeId)
    {
        $result = $this->attributeService->deleteAttributeType($attributeTypeId);
        return $this->returnResult($result);
    }

    public function getAttributeTypeInfo($attributeTypeId)
    {
        $result = $this->attributeService->getAttributeTypeInfo($attributeTypeId);
        return $this->returnResult($result);
    }

    public function getAttributeValueListAndTotal()
    {
        $result = $this->attributeService->getAttributeValueListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    public function addAttributeValue()
    {
        $result = $this->attributeService->addAttributeValue($this->request->all());
        return $this->returnResult($result);
    }

    public function editAttributeValue($attributeValueId)
    {
        $result = $this->attributeService->editAttributeValue($this->request->all(), $attributeValueId);
        return $this->returnResult($result);
    }

    public function deleteAttributeValue($attributeValueId)
    {
        $result = $this->attributeService->deleteAttributeValue($attributeValueId);
        return $this->returnResult($result);
    }

    public function getAttributeValueInfo($attributeValueId)
    {
        $result = $this->attributeService->getAttributeValueInfo($attributeValueId);
        return $this->returnResult($result);
    }
}
