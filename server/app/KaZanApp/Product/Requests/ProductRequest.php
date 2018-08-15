<?php
namespace App\KaZanApp\Product\Requests;

use App\KaZanApp\Base\Request;

class ProductRequest extends Request
{
    public function rules($request, $function = '')
    {
        $productId     = isset($request->route()[2]['product_id']) ? $request->route()[2]['product_id'] : '';
        $productTypeId = isset($request->route()[2]['product_type_id']) ? $request->route()[2]['product_type_id'] : '';
        $rules         = array(
            'addProduct'      => array(
                'product_name'       => 'required|string|unique:product,product_name',
                'attribute_type_id'  => 'required|integer',
                'attribute_value_id' => 'required|integer',
            ),
            'editProduct'     => array(
                'product_name'       => 'required|string|unique:product,product_name,' . $productId . ',product_id',
                'attribute_type_id'  => 'required|integer',
                'attribute_value_id' => 'required|integer',
            ),
            'addProductType'  => array(
                'product_type_name' => 'required|string|unique:product_type,product_type_name',
            ),
            'editProductType' => array(
                'product_type_name' => 'required|string|unique:product_type,product_type_name,' . $productTypeId . ',product_type_id',
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }

        return $this->getRouteValidateRule($rules, $function);
    }
}
