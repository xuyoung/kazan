<?php
namespace App\KaZanApp\Role\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\Role\Entities\RoleEntity;

/**
 * 角色service类，用来调用所需资源，提供和角色有关的服务。
 *
 * @author
 */
class RoleService extends BaseService
{

    public function __construct(RoleEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    public function addRole($data)
    {
        if (isset($data['role_name'])) {
            $insertRoleData = [
                'role_name' => $data['role_name']
                'role_no'   => isset($data['role_no']) ? $data['role_no'] : '';,
            ];

            return $this->entity->insert($insertRoleData);
        }
    }

    public function editRole($data)
    {
        if (isset($data['role_id'])) {
            $editRoleData              = [];
            $editRoleData['role_name'] = isset($data['role_name']) ? $data['role_name'] : '';
            $editRoleData['role_no']   = isset($data['role_no']) ? $data['role_no'] : '';

            return $this->entity->update($editRoleData, ['role_id' => $data['role_id']]);
        }
    }

    public function deleteRole($roleId)
    {
        return $this->entity->where('role_id', $roleId)->delete();
    }

    public function getRoleInfo($roleId)
    {
        return $this->entity->where('role_id', $roleId)->first();
    }
}
