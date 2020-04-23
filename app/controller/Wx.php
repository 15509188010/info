<?php

namespace app\controller;

use app\BaseController;
use app\model\UserInfo;
use app\utils\WxCommon;
use think\App;

/**
 * 企业微信用户信息 Api
 * Class Wx
 * @package app\controller
 */
class Wx extends BaseController
{
    private $objUserInfo;//用户信息对象

    private $base_url = 'https://qyapi.weixin.qq.com/cgi-bin/';//基础url POST（HTTPS）

    private $access_token;//todo(token有请求次数限制,所以需要缓存在redis中,有效期7200s)

    private $objWxCommon;//微信工具对象

    /**
     * Wx constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->objUserInfo = new UserInfo();
        $this->objWxCommon = new WxCommon('ww930372736b675d8c', '8rjpuiSvAuOUVzoenHdJhlzL8qe9ldRqDpgMkYa-ncM');
    }

    /**
     * 根据code获取成员信息
     * access_token获取方式 https=>//work.weixin.qq.com/api/doc/90001/90142/90593#%E6%9C%8D%E5%8A%A1%E5%95%86%E7%9A%84token
     * (第三方文档https=>//blog.csdn.net/xi_haibin/article/details/89394707)
     * auth_code oauth2.0授权企业微信管理员登录产生的code，最长为512字节。只能使用一次，5分钟未被使用自动过期
     */
    public function getUserByCode()
    {
        $this->access_token = $this->objWxCommon->getAccessToken();//获取授权token
        $auth_code = 'aaaaaaaaaaaaaaa';//todo(用户授权登录返回的auth_code,找前端授权的地方让他们传给你)
        $postData = [
            'auth_code' => $auth_code,
        ];
        $raw = json_encode($postData);
        $url = $this->base_url . 'user/getuserinfo?access_token=' . $this->access_token . '&code=' . $auth_code;
        $header = [
            "Content-Type: application/json; charset=UTF-8"
        ];
        $result = WxCommon::request($url, false, $header);
        if ($result === false) {
            parent::buildJson(402, [], '未知错误');
        }
        $result = json_decode($result, true);
        if ($result['errcode'] != 0) {
            //获取信息失败
            parent::buildJson(403, $result, '获取用户信息失败!');
        }
        $res = $this->objUserInfo->saveIn($result);
        if ($res) {
            //写数据成功
            parent::buildJson(200, $res, 'success');
        }
        parent::buildJson(204, $res, 'error');
    }

    /**
     * 使用user_ticket获取成员详情
     * https://qyapi.weixin.qq.com/cgi-bin/user/getuserdetail?access_token=ACCESS_TOKEN
     */
    public function getUserByTicket()
    {
        $user_ticket= '';//todo(需要前端提供)
        $post = [
            'user_ticket' => $user_ticket
        ];
        $raw = json_encode($post);
        $url = $this->base_url . 'user/getuserdetail?access_token=' . $this->access_token;
        $header = [
            "Content-Type: application/json; charset=UTF-8"
        ];
        $result = WxCommon::request($url, $raw , $header);
        if ($result === false) {
            parent::buildJson(402, [], '未知错误');
        }
        $result = json_decode($result, true);
        if ($result['errcode'] != 0) {
            //获取信息失败
            parent::buildJson(403, $result, '获取用户信息失败!');
        }
        /**
         * 将解析后的数据写入数据库
         * ①userId在数据库中存在 update
         * ②userId在数据库中不存在则为新用户 insert
         */
        $res = $this->objUserInfo->saveIn($result);
        if ($res) {
            //写数据成功
            parent::buildJson(200, $res, 'success');
        }
        parent::buildJson(204, $res, 'error');
    }
}