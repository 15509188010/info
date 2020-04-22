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
        $bool = self::exist($params['userId']);
        if ($bool) {
            $res = $this->allowField([
                "username",//varchar(255) NOT NULL DEFAULT '' COMMENT '用户名字',
                "telephone",//varchar(255) NOT NULL DEFAULT '' COMMENT '用户手机号',
                "mail",//varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
                "password",//varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码',
                "remark",//varchar(255) DEFAULT '' COMMENT '备注',
                "dep_id",//int(11) NOT NULL DEFAULT '0' COMMENT '用户部门表',
                "del_status",//tinyint(3) NOT NULL DEFAULT '5' COMMENT '删除状态 默认5 5:正常 4:删除',
                "operator",//varchar(255) NOT NULL DEFAULT '' COMMENT '操作人',
                "operator_time",//int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
                "operator_ip",//varchar(255) NOT NULL DEFAULT '' COMMENT '操作人的ip',
                "sex",//tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户性别 1：男性 2：女性 0：未知',
                "city",//varchar(255) NOT NULL COMMENT '注册城市',
                "province",//varchar(255) NOT NULL COMMENT '注册省份',
                "country",//varchar(255) NOT NULL COMMENT '国家',
                "avatar_url",//varchar(255) NOT NULL COMMENT '头像',
                "create_time",//int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
                "update_time",//int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
                "extends",//json DEFAULT NULL COMMENT '拓展字段',
            ])->save($params);
        }else{
            $res = self::update($params);//todo(这里记得过滤字段)
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
        $dbResult = $this->where('userId', $userId)->find();
        if ($dbResult === false || empty($dbResult)) return true;
        return false;
    }
}