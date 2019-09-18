<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        header('Access-Control-Allow-Origin:*');
        $this->request = $request;
    }

    /**
     * 请求参数处理
     * @param array $arr
     * @return array|string
     */
    public function getParam($getVal, $default = '', $raw = false)
    {
        $value = $this->request->input($getVal, $default);
        if ($raw) {
            return strip_tags($value);
        }
        if (is_array ( $value )) {
            return $this->recursiveHtmlspecialchars ( $value );
        } else {
            return htmlspecialchars ( trim ( $value ) );
        }
    }

    /**
     * 递归的htmlspecialchars给定的数据元素
     * @param array $arr
     * @return array
     */
    private function recursiveHtmlspecialchars(array $arr)
    {
        $arrTemp = array ();
        foreach ( $arr as $k => $v ) {
            $vTemp = '';
            if (is_array ( $v )) {
                $vTemp = $this->recursiveHtmlspecialchars ( $v );
            } else {
                $vTemp = htmlspecialchars ( trim ( $v ) );
            }
            $arrTemp [$k] = $vTemp;
        }
        return $arrTemp;
    }

    /**
     * 返回json数据
     *
     * @param int $code
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function returnJson($succ = true, $data = [], $code = 0, $message = '')
    {
        $messageData = [
            'succ' => $succ,
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ];

        return response()->json($messageData);
    }

    /**
     * 验证
     * @param $request
     * @param $args
     */
    protected function validator($request, $args, $tips = '')
    {
        $tips = '' == $tips ? [
            'required'    => ':attribute是必填项',
            'integer'     => ':attribute必须为数字',
            'date_format' => ':attribute不符合日期格式',
            'date'        => ':attribute不符合日期格式',
            'alpha'       => ':attribute必须为字母',
            'string'      => ':attribute必须为字符串',
            'array'       => ':attribute必须为数组',
            'regex'       => ':attribute不符合正则规范',
            'in'          => ':attribute不在规定范围内',
            'min'         => ':attribute长度不够',
            'max'         => ':attribute长度超过限制',
            'unique'      => ':attribute必须唯一，:attribute已存在',
            'alpha_dash'  => ':attribute必须为字母、数字、破折号（ - ）以及下划线（ _ ）',
        ] : $tips;
        // 验证传递的参数
        $validator = Validator::make($request->all(),
            $args,
            $tips
        );
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
    }
}