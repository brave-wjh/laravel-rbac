<?php

namespace App\Enums;

class ErrorCode
{
    const SUCCESS = 0;       //成功返回码


    const ADMIN_USER_ERROR_CODE = 10001; //Admin_user模块的错误码
    const DATA_NOT_EXIST = 10002; //中间件模块的错误码
    const TOKEN_NOT_EXIST = 10003; //中间件模块的错误码
}