<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\AdminUserService;
use App\Services\AdminRoleService;
use App\Services\AdminPermissionService;
use App\Utils\UtilsHelper;
use App\Enums\ErrorCode;
use Illuminate\Support\Facades\Redis;

class AdminUserController extends BaseController
{
    /**
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $args = [
            'username' => [
                'required',
                'regex:/^[a-zA-Z]\\w{6,12}$/'
            ],
            'password' => 'required',
        ];
        $result = $this->validator($request, $args);
        if ($result !== null){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, $result);
        }
        $username = $this->getParam('username');
        $where = [
            'username' => $username
        ];
        $userinfo = AdminUserService::getInstance()->getAdminUserInfo($where);
        if ($userinfo === false){
            return $this->returnJson(true, [], ErrorCode::ADMIN_USER_ERROR_CODE, '该用户不存在');
        }
        $oldSalt = $userinfo['salt'];
        $password = $this->getParam('password');
        $md5Password = UtilsHelper::md5SaltPassword($password, $oldSalt);
        $where = [
            'username' => $username,
            'password' => $md5Password
        ];
        $result = AdminUserService::getInstance()->getAdminUserInfo($where);
        if ($result === false){
            return $this->returnJson(true, [], ErrorCode::ADMIN_USER_ERROR_CODE, '用户名密码错误');
        }
        if (Redis::exists($result['uid'])){
            $token = Redis::get($result['uid']);
            Redis::del($token);
        }
        $data['token'] = UtilsHelper::createToken();
        $data['uid'] = $result['uid'];
        Redis::setex($data['token'], '604800' , $data['uid']);
        Redis::setex($data['uid'], '604800' , $data['token']);
        return $this->returnJson(true, $data, ErrorCode::SUCCESS);
    }

    /**
     * 注册
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $args = [
            'username' => [
                'required',
                'regex:/^[a-zA-Z]\\w{6,12}$/'
            ],
            'password' => 'required',
        ];
        $result = $this->validator($request, $args);
        if ($result !== null){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, $result);
        }
        $username = $this->getParam('username');
        $where = [
            'username' => $username
        ];
        $result = AdminUserService::getInstance()->getAdminUserInfo($where);
        if ($result !== false){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, '该用户已存在');
        }
        $password = $this->getParam('password');
        $salt = UtilsHelper::getSalt();
        $md5Password = UtilsHelper::md5SaltPassword($password, $salt);
        $arr = [
          'username' => $username,
          'password' => $md5Password,
            'salt' => $salt,
            'uid' => UtilsHelper::getUserId(),
        ];
        $result = AdminUserService::getInstance()->adminUserSave($arr);
        if ($result === true){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, '注册成功');
        }
        return $this->returnJson(false, [], ErrorCode::ADMIN_USER_ERROR_CODE, '注册失败');
    }

    /**
     * 给用户赋角色
     * @param Request $request
     * @return mixed
     */
    public function roleForUser(Request $request)
    {
        $args = [
            'uid' => 'required',
            'role' => 'required',
        ];
        $result = $this->validator($request, $args);
        if ($result !== null){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, $result);
        }

        $uid = $this->getParam('uid');
        $role = $this->getParam('role');
        $where = [
            'uid' => $uid,
        ];
        $result = AdminUserService::getInstance()->updateUserData($where, ['role' => $role]);
        if ($result == true){
            return $this->returnJson(true, [], ErrorCode::SUCCESS, '修改权限成功');
        }
        return $this->returnJson(true, [], ErrorCode::ADMIN_USER_ERROR_CODE, '修改权限失败');
    }



}