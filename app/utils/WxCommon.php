<?php

namespace app\utils;

/**
 * 微信公共通用工具类
 * Class WxCommon
 * @package app\utils
 */
class WxCommon
{

    private $base_url = 'https://qyapi.weixin.qq.com/cgi-bin/';//基础url POST（HTTPS）

    private $corpid;

    private $provider_secret;

    /**
     *
     * WxCommon constructor.
     * @param string $corpid
     * @param string $provider_secret
     */
    public function __construct(string $corpid = '',string $provider_secret = '')
    {
        $this->corpid = $corpid;
        $this->provider_secret = $provider_secret;
    }

    /**
     * 通过corpid和secret 获取access_token(令牌),接口调用基础令牌
     */
    public function getAccessToken(): string
    {
        $url = $this->base_url . 'gettoken?corpid=' . $this->corpid . '&corpsecret=' . $this->provider_secret;
        $header = [
            "Content-Type: application/json; charset=UTF-8"
        ];
        $res = WxCommon::request($url, false, $header);
        if ($res === false) {
            $access_token = 'get access token fail';
        }
        $res = json_decode($res, true);
        if ($res['errcode'] == 0) {
            $access_token = $res['access_token'];
        } else {
            $access_token = 'access token error';
        }
        return $access_token;
    }


    /**
     * curl模拟请求 get|post
     * @param $url
     * @param bool $post
     * @param null $header
     * @return bool|string
     */
    public static function request($url, $post = false, $header = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // 信任任何证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);        // 表示不检查证书
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}