<?php

namespace App\Services;

use App\Models\AdminUser;

class AdminUserService
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset (self::$instance)) {
            self::$instance = new self ();
        }

        return self::$instance;
    }

    /**
     * 添加用户
     * @param $data
     * @return bool
     */
    public static function adminUserSave($data)
    {
        $result = AdminUser::insert($data);
        if ($result == true){
            return true;
        }
        return false;
    }

    /**
     * 获取用户信息
     * @param array $where
     * @return bool
     */
    public static function getAdminUserInfo($where = [])
    {
        $result = AdminUser::where($where)->first();
        if (!$result){
            return false;
        }
        return $result;
    }

    /**
     * 根据特定条件修改用户信息
     * @param $where
     * @param $data
     * @return bool
     */
    public static function updateUserData($where, $data)
    {
        $result = AdminUser::where($where)->update($data);
        if ($result == true){
            return true;
        }
        return false;
    }

}
