<?php
namespace App\KaZanApp\Auth\Requests;

use App\KaZanApp\Base\Request;
use Illuminate\Contracts\Validation\Validator;

class AuthRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($request, $function = '')
    {
        $rules = array(
            'login' => array(
                'user_account' => "required",
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }
        return $this->getRouteValidateRule($rules, $function);
    }
}
