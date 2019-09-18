<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Utils\RedisHelper;
use App\Enums\ErrorCode;

class TestController extends BaseController
{
    public function wjh()
    {
       //RedisHelper::getInstance()->setex('wjh', 10, 'hh');
        return $this->returnJson(true, [], ErrorCode::SUCCESS, '测试权限1');
    }

    public function ww()
    {
        return $this->returnJson(true, [], ErrorCode::SUCCESS, '测试权限2');
    }

    public function www()
    {
        return $this->returnJson(true, [], ErrorCode::SUCCESS, '测试权限3');
    }
}