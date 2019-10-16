<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Redis;

class AdminController extends BaseController
{
    /**
     * 登录
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {

    }

    /**
     * 注册
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $username = $this->getParam('username');
        $password = $this->getParam('password');
        $result = AdminService::getInstance()->register($username, $password);
        if ($result === true){
            return $this->returnJson(true, [], '200', '注册成功');
        }
        return $this->returnJson(false, [], '1001', '注册失败');
    }

    /**
     * 添加经纬度
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function geoadd()
    {
        $longitude = $this->getParam('longitude');
        $latitude = $this->getParam('latitude');
        $city = $this->getParam('city');
        Redis::geoadd('city', $longitude, $latitude, $city);
        return $this->returnJson(true, [], '200', '注册成功');
    }

    /**
     * 查询地区的经纬度
     */
    public function geolist()
    {
        $city = $this->getParam('city');

        $arr = Redis::geopos('city', $city);

        print_r($arr);
    }

    /**
     * 两个地点距离
     */
    public function geodist()
    {
        $city1 = $this->getParam('city1');
        $city2 = $this->getParam('city2');
        $result = Redis::geodist('city', $city1, $city2, 'km');
        var_dump($result);
    }

    /**
     * 根据经纬度查找一定距离内的元素
     */
    public function georadius()
    {
        $longitude = $this->getParam('longitude');
        $latitude = $this->getParam('latitude');
        $result = Redis::georadius('city', $longitude, $latitude, 1000, 'km', 'DESC');
        var_dump($result);
    }

    /**
     * 根据城市查找一定距离内的元素
     */
    public function georadiusbymember()
    {
        $city = $this->getParam('city');
        $result = Redis::georadiusbymember('city', $city, 1000, 'km', 'ASC');
        var_dump($result);
    }

    /**
     * 获取某个城市的时间复杂度
     */
    public function geohash()
    {
        $city = $this->getParam('city');
        $result = Redis::geohash('city', $city);
        var_dump($result);
    }
}