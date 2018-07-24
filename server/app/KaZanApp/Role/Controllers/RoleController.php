<?php
namespace App\KaZanApp\Role\Controllers;

use Illuminate\Http\Request;
use App\KaZanApp\Base\Controller;
use Illuminate\Support\Facades\DB;

/**
 * 角色 controller ，实现角色管理菜单的所有内容，以及所有和角色模块相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class RoleController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->roleService = app('App\KaZanApp\Role\Services\RoleService');
        $this->roleRequest = app('App\KaZanApp\Role\Requests\RoleRequest');
        $this->formFilter($request, $this->roleRequest);
        $this->request = $request;
    }

    public function getRoleListAndTotal()
    {
        $result = $this->roleService->getRoleListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    public function addRole()
    {
        $result = $this->roleService->addRole($this->request->all());
        return $this->returnResult($result);
    }

    public function editRole($roleId)
    {
        $result = $this->roleService->editRole($this->request->all(), $roleId);
        return $this->returnResult($result);
    }

    public function deleteRole($roleId)
    {
        $result = $this->roleService->deleteRole($roleId);
        return $this->returnResult($result);
    }

    public function getRoleInfo($roleId)
    {
        $result = $this->roleService->getRoleInfo($roleId);
        return $this->returnResult($result);
    }
}
