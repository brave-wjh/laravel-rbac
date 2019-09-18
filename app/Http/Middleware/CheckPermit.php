<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\ErrorCode;
use App\Services\AdminUserService;
use App\Services\AdminRoleService;
use App\Services\AdminPermissionService;

class CheckPermit
{
    /**
     * 处理传入的请求
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $messageData = [
            'succ' => false,
            'code' => ErrorCode::DATA_NOT_EXIST,
            'message' => '暂无权限',
            'data' => '',
            'timestamp' => time()
        ];
        $id = $request->header('uid');
        $where = [
            'uid' => $id,
        ];
        //查找当前用户的权限
        $user = AdminUserService::getInstance()->getAdminUserInfo($where);
        //获取到多个角色id
        $role = explode(',', $user['role']);
        $role_permit = '';
        foreach ($role as $k => $v){
            $permit = AdminRoleService::getInstance()->getAdminRoleInfo(['rid' => $v]);
            $role_permit .= ','.$permit['role_permit'];

        }
        $my_string=substr($role_permit,1,strlen($role_permit)-1);
        $my_string = explode( ',', $my_string);
        $my_string = array_unique($my_string);
        $permission = [];
        foreach ($my_string as $k => $v){
            $permit = AdminPermissionService::getInstance()->getAdminRoleInfo(['pid' => $v]);
            $permission[] = '/api'.$permit['action'];
        }
        $now = $request->s;
        if (in_array($now, $permission)){
            return $next($request);
        }
        return response()->json($messageData);
    }

}