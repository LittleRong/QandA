DROP DATABASE if exists `question`;
CREATE DATABASE `question`
    default character set utf8 default collate utf8_general_ci;
use `question`;

DROP TABLE if exists `user`;
CREATE TABLE user(
    `id` int PRIMARY KEY AUTO_INCREMENT COMMENT '用户的id',
    `login_name` varchar(50) NOT NULL COMMENT '用户的登录名',
    `pwd` varchar(50) NOT NULL COMMENT '用户的登陆密码',
    `name` varchar(50) NOT NULL COMMENT '用户的真实姓名',
    `phone_number` varchar(13) NOT NULL COMMENT '用户的手机号码',
    `job_number` varchar(50) NOT NULL COMMENT '用户的工号',
    `permission` int NOT NULL COMMENT '管理权限 0是普通用户 1是管理员 2是超级管理员',
    `gender` int NOT NULL COMMENT '1 male, 2 female',
    `deleted` boolean NOT NULL COMMENT '表示员工已经离职'
)ENGINE = Innodb default charset utf8 comment '用户信息';
