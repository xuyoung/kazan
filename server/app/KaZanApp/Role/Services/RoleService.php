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

    /**
     * 角色管理--获取角色列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    角色列表和数量
     */
    public function getRoleListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getRoleListTotal', 'getRoleList', $params);
    }

    /**
     * 角色管理--获取角色列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    角色列表
     */
    public function getRoleList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['role.role_id' => 'ASC'],
            'return_type' => 'array',
        ];
        $params = array_merge($default, $params);

        $query = $this->entity->select($params['fields']);
        $query = $query->multiWheres($params['search'])->orders($params['order_by']);
        $query = $query->parsePage($params['page'], $params['limit']);
        if ($params['return_type'] == 'array') {
            return $query->get()->toArray();
        } else if ($params['return_type'] == 'count') {
            return $query->count();
        } else {
            return $query->get();
        }
    }


    /**
     * 角色管理--获取角色数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    角色数量
     */
    public function getRoleListTotal($params)
    {
        $params['page'] = 0;
        $params['return_type'] = 'count';
        return $this->getRoleList($params);
    }

    public function addRole($data)
    {
        if (isset($data['role_name'])) {
            $insertRoleData = [
                'role_name'       => $data['role_name'],
                'role_permission' => isset($data['role_permission']) ? json_encode($data['role_permission']) : '',
                'role_no'         => isset($data['role_no']) ? $data['role_no'] : '',
            ];

            return $this->entity->insert($insertRoleData);
        }
    }

    public function editRole($data, $roleId = '')
    {
        if (isset($data['role_id']) || !empty($roleId)) {
            $data['role_id'] = isset($data['role_id']) ? $data['role_id'] : $roleId;
            $editRoleData                    = [];
            $editRoleData['role_name']       = isset($data['role_name']) ? $data['role_name'] : '';
            $editRoleData['role_permission'] = isset($data['role_permission']) ? json_encode($data['role_permission']) : '';
            $editRoleData['role_no']         = isset($data['role_no']) ? $data['role_no'] : '';

            return $this->entity->where(['role_id' => $data['role_id']])->update($editRoleData);
        }
    }

    public function deleteRole($roleId)
    {
        return $this->entity->where('role_id', $roleId)->delete();
    }

    public function getRoleInfo($roleId)
    {
        $roleInfo = $this->entity->where('role_id', $roleId)->first();
        if (!empty($roleInfo) && isset($roleInfo->role_permission)) {
            $roleInfo->role_permission = json_decode($roleInfo->role_permission);
        }
        return $roleInfo;
    }
}
