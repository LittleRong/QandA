DROP DATABASE if exists `question`;
CREATE DATABASE `question`
    default character set utf8 default collate utf8_general_ci;
use `question`;

DROP TABLE if exists `user`;
CREATE TABLE user(
    `id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '用户的id',
    `login_name` VARCHAR(50) NOT NULL COMMENT '用户的登录名',
    `pwd` VARCHAR(50) NOT NULL COMMENT '用户的登陆密码',
    `name` VARCHAR(50) NOT NULL COMMENT '用户的真实姓名',
    `phone_number` VARCHAR(13) NOT NULL COMMENT '用户的手机号码',
    `job_number` VARCHAR(20) NOT NULL COMMENT '用户的工号',
    `permission` INT NOT NULL COMMENT '管理权限 0是普通用户 1是管理员 2是超级管理员',
    `gender` INT NOT NULL COMMENT '1 male, 2 female',
    `deleted` BOOLEAN NOT NULL COMMENT '表示员工已经离职'
)ENGINE = Innodb default charset utf8 comment '用户信息';

DROP TABLE if exists `problem`;
CREATE TABLE problem(
    `problem_id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '题目的id',
    `problem_content` JSON NOT NULL COMMENT '题目的内容,保存为json形式,包括问题problem、选项option、答案answer',
    `problem_class` VARCHAR(20) NOT NULL COMMENT '题目的分类,如业务型,技术型等',
    `problem_type` INT NOT NULL COMMENT '题目的类型：0--填空题,1--单选题,2--多选题,3--判断题'
)ENGINE = Innodb default charset utf8 comment '题目表,包含所有题目';

DROP TABLE if exists `event`;
CREATE TABLE event(
    `event_id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '事件的id',
    `manage_id` INT NOT NULL COMMENT '本事件的管理员id',
    `event_title` VARCHAR(50) NOT NULL COMMENT '事件的标题',
    `event_description` TEXT NOT NULL COMMENT '事件的描述',
    `event_time` JSON COMMENT '事件时间,保存为json形式,包括开始时间start_time、结束时间end_time、答题时间time',
    `event_num` JSON COMMENT '题目数量,保存为json形式,包括单选题数量single_choice_number、多选题数量multiple_choice_number、填空题数量fill_number、判断题数量true_or_false_number',
    `event_type` VARCHAR(50) NOT NULL COMMENT '事件的种类',
    `problem_random` BOOLEAN NOT NULL COMMENT '是否控制题目随机排序,0--否,1--是',
    `option_random` BOOLEAN NOT NULL COMMENT '是否控制选项随机排序,0--否,1--是',
    `answer_time` VARCHAR(20) COMMENT '答题时间配置,答题时的规定完成时间',
    `credit_rule` JSON NOT NULL COMMENT '积分规则,保存为json形式,包括单选题分数single_choice_score、多选题分数multiple_choice_score、填空题分数fill_score、判断题分数true_or_false_score、当日本人全对额外加分person_score、当日团队全对额外加分team_score、团队总积分上限team_score_up、个人总积分上限person_score_up'
)ENGINE = Innodb default charset utf8 comment '事件表,保存发起的比赛信息';

DROP TABLE if exists `event_problem`;
CREATE TABLE event_problem(
    `refer_event_id` INT NOT NULL COMMENT '参见的事件id,关联的事件的id',
    `problem_id` INT NOT NULL COMMENT '使用的题目的id'
)ENGINE = Innodb default charset utf8 comment '比赛的题目';

DROP TABLE if exists `team`;
CREATE TABLE team(
    `team_id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '组id',
    `team_name` VARCHAR(50) NOT NULL COMMENT '组名',
    `refer_event_id` INT NOT NULL COMMENT '参见的事件id,关联的事件的id',
    `team_credit` FLOAT NOT NULL COMMENT '本组在事件中的积分',
)ENGINE = Innodb default charset utf8 comment '组信息表';

DROP TABLE if exists `item`;
CREATE TABLE item(
    `item_id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '道具id',
    `refer_event_id` INT NOT NULL COMMENT '参见的事件id,关联的事件的id',
    `item_name` VARCHAR(50) NOT NULL COMMENT '道具名称',
    `item_description` VARCHAR(100) NOT NULL COMMENT '道具描述',
    `change_rule` FLOAT NOT NULL COMMENT '积分兑换规则,需要使用多少积分兑换',
    `amount` INT NOT NULL COMMENT '存量,道具的剩余数量',
    `team_amount` INT NOT NULL COMMENT '每组可兑换数量	,限定的每组可以兑换数量'
)ENGINE = Innodb default charset utf8 comment '道具表';

DROP TABLE if exists `credit`;
CREATE TABLE credit(
    `user_id` INT NOT NULL COMMENT '操作人id',
    `refer_event_id` INT NOT NULL COMMENT '参见的事件id,关联的事件的id',
    `change_time` TIMESTAMP NOT NULL COMMENT '操作时间',
    `change_value` FLOAT NOT NULL COMMENT '操作值,更改的值',
    `change_reason` VARCHAR(100) NOT NULL COMMENT '更改原因'
)ENGINE = Innodb default charset utf8 comment '积分详细信息表';

ALTER TABLE event ADD participant_num INT NOT NULL COMMENT '参加比赛的小组人数';

DROP TABLE if exists `participant`;
CREATE TABLE participant(
	  `participant_id` INT PRIMARY KEY AUTO_INCREMENT COMMENT '事件的id',
    `refer_event_id` INT NOT NULL COMMENT '参见的事件id,关联的事件的id',
    `user_id` INT NOT NULL COMMENT '参赛人id,参加这次比赛的用户的id',
    `team_id` INT NOT NULL COMMENT '组id,所属组id',
    `credit` FLOAT NOT NULL COMMENT '该用户在比赛中的个人积分',
    `leader` BOOLEAN NOT NULL COMMENT '是否为组长,0--否,1--是',
    `waited_answer` JSON comment '保存参加比赛要答的题的答案'
)ENGINE = Innodb default charset utf8 comment '保存参加比赛的用户信息';

DROP TABLE if exists `participant_haved_answer`;
CREATE TABLE participant_haved_answer(
   `refer_participant_id`  INT NOT NULL comment '参赛者id',
   `refer_problem_id`   INT NOT NULL comment '题id',
   `refer_team_id` INT NOT NULL comment '关联的组id',
   `answer_date` Date not null comment '的用户答题日期',
   `user_answer` VARCHAR(60) comment '的用户答题结果',
   `true_or_false` boolean comment '的用户答题是否正确'
)ENGINE = Innodb default charset utf8 comment '保存参加比赛的用户已经答的题';
