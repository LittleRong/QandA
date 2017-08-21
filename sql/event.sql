
use `question`;

DROP TABLE if exists `event`;
CREATE TABLE event(
    `eid` int PRIMARY KEY IDENTITY COMMENT '事件ID',
    `aid` int NOT NULL COMMENT '管理员ID',
    `ename` varchar(100) NOT NULL COMMENT '事件名称',
    `event_time` varchar(150) NOT NULL COMMENT '事件时间',
	`question_num` varchar(150) NOT NULL COMMENT '题目数量',
    `ekind` varchar(50) NOT NULL COMMENT '事件种类',
    `pro_ramdom` boolean NOT NULL COMMENT '是否控制题目随机排序',
	`opt_ramdom` boolean NOT NULL COMMENT '是否控制选项随机排序',
	`credit_rule` varchar(250) NOT NULL COMMENT '积分规则',
    `message`  varchar(500) NOT NULL COMMENT '事件描述'
);
