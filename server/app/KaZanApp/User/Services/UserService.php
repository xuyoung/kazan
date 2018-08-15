<?php
namespace App\KaZanApp\User\Services;

use App\KaZanApp\Base\BaseService;
use App\KaZanApp\User\Entities\UserEntity;

/**
 * 用户service类，用来调用所需资源，提供和用户有关的服务。
 *
 * @author
 */
class UserService extends BaseService
{

    public function __construct(UserEntity $entity)
    {
        parent::__construct();
        $this->entity = $entity;
    }

    /**
     * 用户管理--获取用户列表和数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-21 创建
     *
     * @return array    用户列表和数量
     */
    public function getUserListAndTotal($params)
    {
        $params = $this->parseParams($params);
        return $this->response($this, 'getUserListTotal', 'getUserList', $params);
    }

    /**
     * 用户管理--获取用户列表
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    用户列表
     */
    public function getUserList($params)
    {
        $default = [
            'fields'      => ['*'],
            'page'        => 0,
            'limit'       => config('kazan.pagesize'),
            'search'      => [],
            'order_by'    => ['user.user_id' => 'ASC'],
            'return_type' => 'array',
        ];
        // 是否进行关联查询
        $withAble = isset($params['fields']) ? true : false;
        $params   = array_merge($default, $params);

        $query = $this->entity->select($params['fields']);
        $query = $query->multiWheres($params['search'])->orders($params['order_by']);
        if (isset($params['with_trashed']) && $params['with_trashed'] && !$withAble) {
            $query = $query->with(['userHasOneRole' => function ($query) {
                $query->withTrashed();
            }])->withTrashed();
        } elseif (!$withAble) {
            $query = $query->with("userHasOneRole");
        }
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
     * 用户管理--获取用户数量
     *
     * @author
     *
     * @param  array $params [description]
     *
     * @since  2018-07-20 创建
     *
     * @return number    用户数量
     */
    public function getUserListTotal($params)
    {
        $params['page']        = 0;
        $params['return_type'] = 'count';
        return $this->getUserList($params);
    }

    /**
     * 用户管理--添加用户
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的用户信息
     */
    public function addUser($data)
    {
        if (isset($data['user_account']) && isset($data['user_name']) && isset($data['role_id'])) {
            $password             = isset($data["password"]) ? $data["password"] : '';
            $password             = crypt($password, null);
            $userNamePyArray      = convert_pinyin($data['user_name']);
            $data['user_name_py'] = isset($userNamePyArray[0]) ? $userNamePyArray[0] : '';
            $data['user_name_zm'] = isset($userNamePyArray[1]) ? $userNamePyArray[1] : '';
            $insertUserData       = [
                'user_account' => $data['user_account'],
                'password'     => $password,
                'user_name'    => $data['user_name'],
                'role_id'      => $data['role_id'],
                'user_name_py' => $data['user_name_py'],
                'user_name_zm' => $data['user_name_zm'],
            ];

            return $this->entity->insert($insertUserData);
        }
    }

    /**
     * 用户管理--编辑用户
     *
     * @author
     *
     * @param  array $data [description]
     *
     * @since  2018-07-20 创建
     *
     * @return array    添加的用户信息
     */
    public function editUser($data, $loginUserId = '')
    {
        if (isset($data['user_id']) || !empty($loginUserId)) {
            $password                     = isset($data["password"]) ? $data["password"] : '';
            $password                     = crypt($password, null);
            $userNamePyArray              = convert_pinyin($data['user_name']);
            $data['user_id']              = isset($data['user_id']) ? $data['user_id'] : $loginUserId;
            $editUserData                 = [];
            $editUserData['user_account'] = isset($data['user_account']) ? $data['user_account'] : '';
            $editUserData['user_name']    = isset($data['user_name']) ? $data['user_name'] : '';
            $editUserData['role_id']      = isset($data['role_id']) ? $data['role_id'] : '';
            $editUserData['password']     = $password;
            $editUserData['user_name_py'] = isset($userNamePyArray[0]) ? $userNamePyArray[0] : '';
            $editUserData['user_name_zm'] = isset($userNamePyArray[1]) ? $userNamePyArray[1] : '';

            return $this->entity->where(['user_id' => $data['user_id']])->update($editUserData);
        }
    }

    /**
     * 用户管理--删除用户
     *
     * @author
     *
     * @param  int $userId [用户ID]
     *
     * @since  2018-07-20 创建
     *
     * @return boolean
     */
    public function deleteUser($userId)
    {
        return $this->entity->where('user_id', $userId)->delete();
    }

    /**
     * 用户管理--根据用户ID获取某个用户的信息
     *
     * @author
     *
     * @param  int $userId [用户ID]
     *
     * @since  2018-07-20 创建
     *
     * @return array
     */
    public function getUserAllData($userId)
    {
        return $this->entity->where('user_id', $userId)->first();
    }

    /**
     * 用户管理--根据用户名获取某个用户的信息
     *
     * @author
     *
     * @param  string $userAccount [用户名]
     *
     * @since  2018-07-20 创建
     *
     * @return array
     */
    public function getUserByAccount($userAccount)
    {
        return $this->entity->where('user_account', $userAccount)->first();
    }

    /**
     * 用户管理--修改密码
     *
     * @author
     *
     * @param  array $data [密码数据]
     * @param  int $userId [用户ID]
     *
     * @since  2018-07-20 创建
     *
     * @return int
     */
    public function modifyUserPassword($data, $userId)
    {
        if (isset($data['old_password']) && isset($data['new_password']) && isset($data['confirm_new_password'])) {
            $oldPassword = crypt($data['old_password'], null);
            $userInfo    = $this->getUserAllData($userId);
            if ($userInfo->password && $userInfo->password == $oldPassword) {
                if ($data['new_password'] != $data['confirm_new_password']) {
                    return ['code' => ['0x002002', 'user']];
                }
                $newPassword = crypt($data['new_password'], null);
                return $this->entity->where(['user_id' => $userId])->update(['password' => $newPassword]);
            } else {
                return ['code' => ['0x002001', 'user']];
            }
        }
    }

}
