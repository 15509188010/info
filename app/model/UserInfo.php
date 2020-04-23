<?php

namespace app\model;

use think\Model;

class UserInfo extends Model
{
    /**
     * 保存用户信息
     * 将解析后的数据写入数据库
     * ①userId在数据库中存在 update
     * ②userId在数据库中不存在则为新用户 insert
     * @param $params
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function saveIn($params)
    {
        //todo(模拟数据)
        /**$params=[
            "username" => '测试',//varchar(255) NOT NULL DEFAULT '' COMMENT '用户名字',
            "telephone" => '18888888888',//varchar(255) NOT NULL DEFAULT '' COMMENT '用户手机号',
            "mail" => '18888888888@163.com',//varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
            "password" => '11516555555555555555555555555555555555555555555555555555',//varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码',
            "remark" => '备注信息',//varchar(255) DEFAULT '' COMMENT '备注',
            "dep_id" => 1,//int(11) NOT NULL DEFAULT '0' COMMENT '用户部门表',
            "del_status" => 5,//tinyint(3) NOT NULL DEFAULT '5' COMMENT '删除状态 默认5 5:正常 4:删除',
            "operator" => 'xiaoming',//varchar(255) NOT NULL DEFAULT '' COMMENT '操作人',
            "operator_time" => '1850000000',//int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
            "operator_ip" => '127.0.0.1',//varchar(255) NOT NULL DEFAULT '' COMMENT '操作人的ip',
            "sex" => 1,//tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户性别 1：男性 2：女性 0：未知',
            "city" => '西安',//varchar(255) NOT NULL COMMENT '注册城市',
            "province" => '陕西',//varchar(255) NOT NULL COMMENT '注册省份',
            "country" => '中国',//varchar(255) NOT NULL COMMENT '国家',
            "avatar_url" => 'http://image.loc?788.png',//varchar(255) NOT NULL COMMENT '头像',
            "create_time" => '1850000000',//int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
            "update_time" => '1850000000',//int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
        ];*/

        $bool = self::exist(1);
        if ($bool) {
            $res = $this->insert($params);
        }else{
            $res = self::update($params,['id'=>$params['id']]);//todo(这里记得过滤字段)
        }

        if ($res === false) return false;
        return true;
    }

    /**
     * 查询当前用户是否存在数据库中
     * @param $userId
     * @return bool 用户不存在=>true 存在=>false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function exist($userId)
    {
        $dbResult = $this->where('userId', $userId)->find(); //todo(记得修改)
        if ($dbResult === false || empty($dbResult)) return true;
        return false;
    }
}