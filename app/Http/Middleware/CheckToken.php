<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\ErrorCode;

class CheckToken
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
            'message' => '缺少Token参数',
            'data' => '',
            'timestamp' => time()
        ];
        $id = $request->header('uid') ?? '';
        $token = $request->header('token') ?? '';
        if(empty($id) || empty($token)){
            return response()->json($messageData);
        }
        //判断token操作
        $res = Redis::get($token);
        if ($res == $id)
        {
            return $next($request);
        }
        //最后走的操作
        $messageData['code'] = ErrorCode::TOKEN_NOT_EXIST;
        $messageData['message'] = 'token已失效';
        return response()->json($messageData);
    }

}