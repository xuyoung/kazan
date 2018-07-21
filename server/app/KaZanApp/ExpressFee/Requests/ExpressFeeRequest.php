<?php
namespace App\KaZanApp\ExpressFee\Requests;

use App\KaZanApp\Base\Request;

class ExpressFeeRequest extends Request
{
    public function rules($request, $function = '')
    {
        $expressFeeId = isset($request->route()[2]['express_fee_id']) ? $request->route()[2]['express_fee_id'] : '';
        $rules        = array(
            'addExpressFee'  => array(
                'area' => 'required|string|unique:express_fee,area',
            ),
            'editExpressFee' => array(
                'express_fee_id'    => 'required|integer',
                'area'              => 'required|string|unique:express_fee,area,' . $expressFeeId . ',express_fee_id',
                'first_weight'      => 'required|numeric',
                'first_fee'         => 'required|numeric',
                'additional_weight' => 'numeric',
                'additional_fee'    => 'numeric'
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }
        return $this->getRouteValidateRule($rules, $function);
    }
}
