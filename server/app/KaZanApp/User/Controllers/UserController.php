<?php
namespace App\KaZanApp\User\Controllers;

use App\KaZanApp\User\Requests\UserRequest;
use Illuminate\Http\Request;
use App\KaZanApp\Base\Controller;

/**
 * 用户 controller ，实现用户管理菜单的所有内容，以及所有和用户模块相关的功能实现
 * 这个类，用来：1、验证request；2、组织数据；3、调用service实现功能；[4、组织返回值]
 *
 * @author
 *
 * @since
 */
class UserController extends Controller
{
    public function __construct(
        Request $request
    ) {
        parent::__construct();
        $this->userService = app('App\KaZanApp\User\Services\UserService');
        $this->userRequest = app('App\KaZanApp\User\Requests\UserRequest');
        $this->formFilter($request, $this->userRequest);
        $this->request = $request;
    }

    /**
     * 获取用户列表数据和数量
     *
     * @param {int} autoFixPage 起始页
     * @param {int} limit 每页显示数量
     * @param {json} order_by 排序
     * @param {int} page 页码
     * @param {json} search 查询条件
     *
     * @paramExample {string} 参数示例
     * {
     *  autoFixPage: 1
     *  limit: 10
     *  order_by: {"user_name":"desc"}
     *  page: 2
     *  search: {"user_name":['系统',"like"]}
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          "total": 669, // 用户数量
     *          "list": [ // 用户列表
     *              {
     *                  "user_id": "1", // 用户ID
     *                  "user_account": "admin", // 用户名
     *                  "user_name": "系统管理员", // 姓名
     *                  "role_id": "1", // 用户角色ID
     *                  "phone_number": "187xxxxxxxx", // 手机号码
     *                  "user_status": "1", // 用户状态
     *                  "list_number": "用户序号",
     *                  "user_name_py": "xitongguanliyuan",
     *                  "user_name_zm": "xtgly",
     *              },
     *          ...
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function getUserListAndTotal()
    {
        $result = $this->userService->getUserListAndTotal($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 添加用户
     *
     * @param {string} user_account 用户名
     * @param {string} password 密码
     * @param {string} user_name 姓名
     * @param {int} role_id 角色ID
     * @param {string} phone_number 手机号码
     * @param {int} user_status 用户状态
     * @param {int} list_number 序号
     *
     * @paramExample {string} 参数示例
     * {
     *  user_account: 'jason',
     *  password: '123456'，
     *  user_name: '杰森',
     *  role_id: 1,
     *  phone_number: 187xxxxxxxx
     *  user_status: 1
     *  list_number: 918
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          created_at: "2018-06-24 16:35:02",
     *          list_number: 918,
     *          password: "$1$6MowpIHK$9v4M1au3Aq98plAqIt5bq1",
     *          updated_at: "2018-06-24 16:35:02",
     *          user_accounts: "jason",
     *          user_name: "杰森",
     *          user_id: "1",
     *          role_id: 1,
     *          user_status: 1,
     *          phone_number: "187xxxxxxxx",
     *          user_name_py: "jason",
     *          user_name_zm: "js",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function addUser()
    {
        $result = $this->userService->addUser($this->request->all());
        return $this->returnResult($result);
    }

    /**
     * 编辑用户
     *
     * @param {int} user_id 用户ID
     * @param {string} user_account 用户名
     * @param {string} password 密码
     * @param {string} user_name 姓名
     * @param {int} role_id 角色ID
     * @param {string} phone_number 手机号码
     * @param {int} user_status 用户状态
     * @param {int} list_number 序号
     *
     * @paramExample {string} 参数示例
     * {
     *  user_id: 1,
     *  user_account: 'jason',
     *  password: '123456'，
     *  user_name: '杰森',
     *  role_id: 1,
     *  phone_number: 187xxxxxxxx
     *  user_status: 1
     *  list_number: 918
     * }
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": {
     *          created_at: "2018-06-24 16:35:02",
     *          list_number: 918,
     *          password: "$1$6MowpIHK$9v4M1au3Aq98plAqIt5bq1",
     *          updated_at: "2018-06-24 16:35:02",
     *          user_accounts: "jason",
     *          user_name: "杰森",
     *          user_id: "1",
     *          role_id: 1,
     *          user_status: 1,
     *          phone_number: "187xxxxxxxx",
     *          user_name_py: "jason",
     *          user_name_zm: "js",
     *      }
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function editUser($userId)
    {
        $result = $this->userService->editUser($this->request->all(), $userId);
        return $this->returnResult($result);
    }

    /**
     * 删除用戶
     *
     * @param {string} user_id 用户ID
     *
     * @paramExample {string} 参数示例
     * api/user/1
     *
     * @success {boolean} status(1) 接入成功
     * @successExample {json} Success-Response:
     * {
     *      "status": 1,
     *      "data": true
     * }
     *
     * @error {boolean} status(0) 接入失败
     * @error {array} errors 接入失败错误信息
     *
     * @errorExample {json} Error-Response:
     * { "status": 0,"errors":[{"code":"0x000003","message":"未知错误"}] }
     */
    public function deleteUser($userId)
    {
        $result = $this->userService->deleteUser($userId);
        return $this->returnResult($result);
    }

    public function getUserAllData($userId)
    {
        $result = $this->userService->getUserAllData($userId);
        return $this->returnResult($result);
    }

    public function modifyUserPassword($userId)
    {
        $result = $this->userService->modifyUserPassword($this->request->all(), $userId);
        return $this->returnResult($result);
    }

}
