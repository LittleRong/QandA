<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"G:\xmapp\htdocs\QandA\public/../application/index\view\userindex\user_index.html";i:1503406416;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title>个人信息</title>
        <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
	</head>
	<body>
    <div class="pui-layout pui-bg-blue-500">
            <header class="pui-center pui-layout-fixed pui-layout-fixed-1200">
                <div class="pui-row">
           	<div class="pui-grid-xs-3 pui-grid-xs-push-9 pui-grid-sm-3 pui-grid-sm-push-9 pui-grid-md-3 pui-grid-md-push-9 pui-grid-lg-3 pui-grid-lg-push-9 pui-grid-xl-3 pui-grid-xl-push-9 pui-grid-xxl-3 pui-grid-xxl-push-9 ">
        	   	<ul class="pui-menu pui-menu-justify" style="margin-top:38px;margin-bottom: 0px;">
            	<li>
                <span><?php echo $data['user_message']['login_name']; ?></span>&emsp;<span id="logout_btn">退出</span>
            	</li>
	                	</ul>
           	</div>
           	<div class="pui-grid-xs-9 pui-grid-xs-pull-3 pui-grid-sm-9 pui-grid-sm-pull-3 pui-grid-md-9 pui-grid-md-pull-3 pui-grid-lg-9 pui-grid-lg-pull-3 pui-grid-xl-9 pui-grid-xl-pull-3 pui-grid-xxl-9 pui-grid-xxl-pull-3">
                    <h4><img src="img/logo.png" >中国移动南方基地知识题库</h4>
           	</div>
    	   	</div>


            </header>
        </div>
        <div class="pui-layout" style="width:96%;margin-top:30px ">
    	<div class="pui-row " >
        <div class="pui-grid-xs-12 pui-grid-sm-12 pui-grid-md-9 pui-grid-md-push-3 pui-grid-lg-9 pui-grid-lg-push-3 pui-grid-xl-9 pui-grid-xl-push-3 pui-grid-xxl-9 pui-grid-xxl-push-3">
           	<ul class="pui-menu  pui-menu-radius pui-menu-inline pui-menu-bordered " style="margin-bottom: 0px;">
    	            <li style="width: 25%">
    	                <a href="javascript:;" class="active">进行中</a>
    	            </li>
    	            <li style="width: 25%">
    	                <a href="javascript:;">已过期</a>
    	            </li>
    	            <li>
            	<div class="clear pui-card" style="margin-top:20px ">
                        <ul class="pui-list pui-list-line">
                        	<li>
                        	<?php foreach($data['event_message'] as $v=>$k): ?>
								<div class="clear pui-card pui-card-shadow pui-card-radius">
            	                	<div class="pui-card-box">
            	                    <h1><?php echo $k['event_title']; ?><small></small></h1>
            	                    <p class="pui-text-indent"><?php echo $k['event_description']; ?></p>
            	                    <p>
	                        			<strong>参赛形式:</strong> 2-3人团队  <strong>答题规则:</strong>每日10道题量<br>
	                        			<strong>截止日期：</strong>2017年9月30号<br>
	                        			<strong>可兑换道具规则：</strong>复活令牌 有爱令牌
	            	                </p>
	            	                <p class="pui-text-right"><br><a href="#" class="pui-btn pui-btn-default pui-unbordered">详细 &gt;&gt;</a></p>
	            	                </div>
	                            </div>
                        	<?php endforeach; ?>
                    		

                            <div class="clear pui-card pui-card-shadow pui-card-radius">
            	                <div class="pui-card-box">
            	                    <h1>2017年一叶知秋知识竞赛<small></small></h1>
            	                    <p></p>
                        	<strong>参赛形式:</strong> 2-3人团队  <strong>答题规则:</strong>每日10道题量<br>
                        	<strong>截止日期：</strong>2017年9月30号<br>
                        	<strong>可兑换道具规则：</strong>复活令牌 有爱令牌


            	                    </p>
            	                    <p class="pui-text-right"><br><a href="#" class="pui-btn pui-btn-default pui-unbordered">详细 &gt;&gt;</a></p>
            	                </div>
                            </div>
                        	</li>
                        </ul>

    	            	</div>
    	            </li>
    	        </ul>

    	   	</div>
    	   	<div class="pui-grid-xs-12  pui-grid-sm-12 pui-grid-md-3 pui-grid-md-pull-9 pui-grid-lg-3 pui-grid-lg-pull-9 pui-grid-xl-3 pui-grid-xl-pull-9 pui-grid-xxl-3 pui-grid-xxl-pull-9">
                <div class="pui-card pui-card-shadow pui-card-radius">
                    <div class="pui-card-box">
                        <h1 style="text-align: center;"><img src="img/logo.png" class="pui-img-circle pui-box-shadow-plus"></h1>
                        <h5 style="text-align: center;"><strong>姓名：</strong><?php echo $data['user_message']['name']; ?>&emsp;
                        	<?php if($data['user_message']['gender'] == '1'): ?>男<?php else: ?>女<?php endif; ?>
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

<script type="text/javascript">
$(document).ready(function(){
    $("#logout_btn").click(function(){
            var post_data = {};
            $.ajax({
                url:"<?php echo url('index/Login/logout'); ?>",
                dataType: "json",
                type: 'POST',
                data: post_data,
                async: false,
                success: function(data){
                    window.location.href="<?php echo url('index/Login/index'); ?>";
                },
                error: function(data, status, error){
                }
            });
            return false;
    });
});


</script>
</html>
