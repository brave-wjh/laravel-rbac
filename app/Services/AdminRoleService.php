<?php

namespace App\Services;

use App\Models\AdminRole;

class AdminRoleService
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
     * 获取用户角色信息信息
     * @param array $where
     * @return bool
     */
    public static function getAdminRoleInfo($where = [])
    {
        $result = AdminRole::where($where)->first();
        if (!$result){
            return false;
        }
        return $result;
    }
}