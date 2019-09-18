<?php

namespace App\Services;

use App\Models\AdminPermission;

class AdminPermissionService
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
     * 获取角色对应权限信息
     * @param array $where
     * @return bool
     */
    public static function getAdminRoleInfo($where = [])
    {
        $result = AdminPermission::where($where)->first();
        if (!$result){
            return false;
        }
        return $result;
    }
}