<?php
namespace App\KaZanApp\Attribute\Requests;

use App\KaZanApp\Base\Request;

class AttributeRequest extends Request
{
    public function rules($request, $function = '')
    {
        $rules = array(
            'addAttributeType'   => array(
                'attribute_type_name' => 'required|string',
            ),
            'editAttributeType'  => array(
                'attribute_type_name' => 'required|string',
            ),
            'addAttributeValue'  => array(
                'attribute_type_id'    => 'required|integer',
                'attribute_value_name' => 'required|string',

            ),
            'editAttributeValue' => array(
                'attribute_type_id'    => 'required|integer',
                'attribute_value_name' => 'required|string',
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }

        return $this->getRouteValidateRule($rules, $function);
    }
}
