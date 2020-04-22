<?php

namespace app\utils;

/**
 * 微信公共通用工具类
 * Class WxCommon
 * @package app\utils
 */
class WxCommon
{
    /**
     * curl模拟请求 get|post
     * @param $url
     * @param bool $post
     * @return bool|string
     */
    public static function request($url, $post = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}