<?php

namespace App\Utils;

class UtilsHelper
{
    const RANGE = '0123456789abcdefghijklmnopqrstuvwxyz';

    /**
     * 生成盐
     * @return string
     */
    public static function getSalt()
    {
        $chars = self::RANGE;
        $str = '';
        for ($i = 0; $i < 8; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

    /**
     * 密码加盐
     * @param $password
     * @param $salt
     * @return string
     */
    public static function md5SaltPassword($password, $salt)
    {
        $new = $password.':'.$salt;
        $new = md5($new);
        return $new;
    }

    /**
     * @return float|int
     */
    public static function getUserId()
    {
        $one = '/^([\d])\1{3}$/';
        $two = '/^(0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)|9(?=0)){3}|(?:0(?=9)|9(?=8)|8(?=7)|7(?=6)|6(?=5)|5(?=4)|4(?=3)|3(?=2)|2(?=1)|1(?=0)){3}$/';
        $num = self::getDouble();
        for ($i = 0; $i<20; $i++) {
            $num = ceil($num * 8767600) + 11111111;
            if (!preg_match($one, $num) || !preg_match($two, $num)) {
                return $num;
            }
        }
    }

    /**
     * @return float|int
     */
    public static function getDouble($min = 0, $max = 1)
    {
        return $min + mt_rand()/mt_getrandmax() * ($max-$min);
    }

    /**
     * 生成32位token
     * @return string
     */
    public static function createToken()
    {
        return str_random(32);
    }
}