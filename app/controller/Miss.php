<?php


namespace app\controller;


use app\BaseController;

class Miss extends BaseController
{
    /**
     * 未匹配到路由时统一处理
     */
    public function index()
    {
        $json = json_encode([
            "code" => 404,
            "data" => false,
            "msg"  => 'not found router'
        ],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        exit($json);
    }
}