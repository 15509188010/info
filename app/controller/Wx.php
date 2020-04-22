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

    private $base_url = 'https=>//qyapi.weixin.qq.com/cgi-bin/service/get_login_info?';//获取登录用户信息,基础url POST（HTTPS）

    private $access_token = 'access token';//todo(需要)

    /**
     * Wx constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->objUserInfo = new UserInfo();
    }

    /**
     * access_token获取方式 https=>//work.weixin.qq.com/api/doc/90001/90142/90593#%E6%9C%8D%E5%8A%A1%E5%95%86%E7%9A%84token
     * (第三方文档https=>//blog.csdn.net/xi_haibin/article/details/89394707)
     * auth_code oauth2.0授权企业微信管理员登录产生的code，最长为512字节。只能使用一次，5分钟未被使用自动过期
     */
    public function auth()
    {
        $auth_code = 'aaaaaaaaaaaaaaa';//todo(用户授权登录返回的auth_code)

        $postData = [
            'auth_code' => $auth_code,
        ];
        $raw = json_encode($postData);
        $result = WxCommon::request($this->base_url . '?access_token=' . $this->access_token, $raw);
        $result = [
            "errcode"   => 0,
            "errmsg"    => "ok",
            "usertype"  => 1,
            "user_info" => [
                "userid" => "xxxx",
                "name"   => "xxxx",
                "avatar" => "xxxx"
            ],
            "corp_info" => [
                "corpid" => "wxCorpId",
            ],
            "agent"     => [
                ["agentid" => 0, "auth_type" => 1],
                ["agentid" => 1, "auth_type" => 1],
                ["agentid" => 2, "auth_type" => 1]
            ],
            "auth_info" => [
                "department" => [
                    [
                        "id"       => 2,
                        "writable" => true
                    ]
                ]
            ]
        ];//todo(模拟微信返回信息)

        /**
         * 将解析后的数据写入数据库
         * ①userId在数据库中存在 update
         * ②userId在数据库中不存在则为新用户 insert
         */
        $res = $this->objUserInfo->saveIn($result);
        if ($res){
            //写数据成功
            parent::buildJson(200,$res,'success');
        }
        parent::buildJson(204,$res,'error');
    }

    /**
     * 通过corpid和secret 获取access_token(令牌),接口调用基础令牌
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }


}