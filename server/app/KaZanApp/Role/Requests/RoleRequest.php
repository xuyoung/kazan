<?php
namespace App\KaZanApp\Role\Requests;

use App\KaZanApp\Base\Request;

class RoleRequest extends Request
{
    public function rules($request, $function = '')
    {
        $roleId = isset($request->route()[2]['role_id']) ? $request->route()[2]['role_id'] : '';
        $rules  = array(
            'addRole'     => array(
                'role_name'             => 'required|string'
            ),
            'editRole'       => array(
                'role_name'             => 'required|string'
            ),
        );

        if (empty($function)) {
            $function = explode("@", $request->route()[1]['uses'])[1];
        }
        return $this->getRouteValidateRule($rules, $function);
    }
}
