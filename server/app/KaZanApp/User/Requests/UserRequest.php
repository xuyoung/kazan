<?php
namespace App\KaZanApp\User\Requests;

use App\KaZanApp\Base\Request;

class UserRequest extends Request
{
    public function rules($request, $function = '')
    {
        $userId = isset($request->route()[2]['user_id']) ? $request->route()[2]['user_id'] : '';
        $rules  = array(
            'addUser'  => array(
                'user_name'    => 'required|string',
                'user_account' => 'required|string|unique:user,user_account',
                'role_id'      => 'required|integer',
            ),
            'editUser' => array(
                'user_name'    => 'required|string',
                'user_account' => 'required|string|unique:user,user_account,' . $userId . ',user_id',
                'role_id'      => 'required|integer',
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }
        return $this->getRouteValidateRule($rules, $function);
    }
}
