
CREATE TABLE `user_info` (
  `id` int(32) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '用户名字',
  `telephone` varchar(255) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `mail` varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '用户密码',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `dep_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户部门表',
  `del_status` tinyint(3) NOT NULL DEFAULT '5' COMMENT '删除状态 默认5 5:正常 4:删除',
  `operator` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人',
  `operator_time` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `operator_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '操作人的ip',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户性别 1：男性 2：女性 0：未知',
  `city` varchar(255) NOT NULL COMMENT '注册城市',
  `province` varchar(255) NOT NULL COMMENT '注册省份',
  `country` varchar(255) NOT NULL COMMENT '国家',
  `avatar_url` varchar(255) NOT NULL COMMENT '头像',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `extends` json DEFAULT NULL COMMENT '拓展字段',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='企业微信信息表';