<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"G:\xampp\htdocs\QandA\public/../application/index\view\userindex\user_index.html";i:1503989807;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title>个人信息</title>
    <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
</head>
<body>
    <div class="pui-layout">
        <header>
            <div style="position: relative;">
                <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/header2.jpg" style="width: 100%;height: auto">
                <div class="form-group pui-btn-gradient pui-btn-shadow" style="position: absolute;bottom: 10px;right: 20px">
                    <input type="button" class="pui-btn pui-btn-small pui-btn-default " value="<?php echo $data['user_message']['login_name']; ?>">
                    <a type="button" class="pui-btn pui-btn-small pui-btn-primary " href="<?php echo url('index/Login/logout'); ?>" >退出</a>
                </div>
            </div>
        </header>
    </div>
    <div class="pui-layout" style="width: 96%; margin-top: 30px">
        <div class="pui-row ">
            <div class="pui-grid-xs-12 pui-grid-sm-12 pui-grid-md-9 pui-grid-md-push-3 pui-grid-lg-9 pui-grid-lg-push-3 pui-grid-xl-9 pui-grid-xl-push-3 pui-grid-xxl-9 pui-grid-xxl-push-3">
                <ul class="pui-menu  pui-menu-radius pui-menu-inline pui-menu-bordered " style="margin-bottom: 0px;">
                    <li style="width: 25%">
                        <a href="javascript:;" class="active">进行中</a>
                    </li>
                    <li style="width: 25%">
                        <a href="javascript:;">已过期</a>
                    </li>
                    <li>
                        <div class="clear pui-card" style="margin-top: 20px">
                            <ul class="pui-list pui-list-line">
                                <li><?php if(!empty($data['event_message'])): foreach($data['event_message'] as $v=>$k): ?>
                                <div class="clear pui-card pui-card-shadow pui-card-radius">
                                    <div class="pui-card-box">
                                        <h1><?php echo $k['event_title']; ?><small></small></h1>
                                        <p class="pui-text-indent"><?php echo $k['event_description']; ?></p>
                                        <p>
                                            <strong>参赛形式:</strong> <?php echo $k['participant_num']; ?>人<strong>&emsp;答题规则：</strong>总共<?php echo $k['fill']+$k['judge']+$k['single']+$k['multiple']; ?>道题量。单选题<?php echo $k['single']; ?>道，判断题<?php echo $k['judge']; ?>道，多选题<?php echo $k['multiple']; ?>道，填空题<?php echo $k['fill']; ?>道<br>
                                            <strong>活动时间：</strong><?php echo $k['start_time']; ?>至<?php echo $k['end_time']; ?><br>
                                            <strong>可兑换道具：</strong><?php echo $k['item']; ?>
                                        </p>
                                        <p>
                                            <input type="button" class="pui-btn pui-btn-default" value="兑换道具" onclick="location.href='<?php echo url('/item_manage/exchange/show_item',array('event_id'=>$k['event_id'])); ?>'" />
                                            <input type="button" class="pui-btn pui-btn-default" value="开始答题" onclick="location.href='<?php echo url('/problem/userproblem',array('event_id'=>$k['event_id'])); ?>'" />
                                        </p>
                                        <p class="pui-text-right">
                                            <br>
                                            <a href="<?php echo url('/index/eventmessage/event_message',array('event_id'=>$k['event_id'])); ?>" class="pui-btn pui-btn-default pui-unbordered">详细 &gt;&gt;</a>
                                        </p>
                                    </div>
                                </div>
                                    <?php endforeach; endif; ?>
                                </li>
                            </ul>

                        </div>
                    </li>
                </ul>

            </div>
            <div class="pui-grid-xs-12  pui-grid-sm-12 pui-grid-md-3 pui-grid-md-pull-9 pui-grid-lg-3 pui-grid-lg-pull-9 pui-grid-xl-3 pui-grid-xl-pull-9 pui-grid-xxl-3 pui-grid-xxl-pull-9">
                <div class="pui-card pui-card-shadow pui-card-radius">
                    <div class="pui-card-box">
                        <h1 style="text-align: center;">
                            <?php if($data['user_message']['gender'] == '男'): ?>
                            <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/boy.jpg" class="pui-img-circle pui-box-shadow-plus">
                            <?php else: ?>
                            <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/girl.jpg" class="pui-img-circle pui-box-shadow-plus">
                            <?php endif; ?>
                            </h1>
                        <h5 style="text-align: center;"><strong>姓名：</strong><?php echo $data['user_message']['name']; ?>                            
                        </h5>
                        <h5 style="text-align: center;"><strong>工号：</strong><?php echo $data['user_message']['job_number']; ?></h5>
                        <h5 style="text-align: center;"><strong>手机号：</strong><?php echo $data['user_message']['phone_number']; ?></h5>
                        <p style="text-align: right;"><a href="<?php echo url('index/login/change_pwd'); ?>">修改密码</a></p>
                    </div>
                </div>
            </div>
        </div>
</body>

<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/js/planeui.js"></script>
</html>
