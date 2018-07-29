<?php
namespace App\KaZanApp\Formula\Requests;

use App\KaZanApp\Base\Request;

class FormulaRequest extends Request
{
    public function rules($request, $function = '')
    {
        $formulaId = isset($request->route()[2]['formula_id']) ? $request->route()[2]['formula_id'] : '';
        $rules     = array(
            'addFormula'  => array(
                'product_id'   => 'required|integer',
                'cloth_size'   => 'required|string',
                'formula_json' => 'required|string',
            ),
            'editFormula' => array(
                'formula_id'   => 'required|integer',
                'product_id'   => 'required|integer',
                'cloth_size'   => 'required|string',
                'formula_json' => 'required|string',
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }

        return $this->getRouteValidateRule($rules, $function);
    }
}
