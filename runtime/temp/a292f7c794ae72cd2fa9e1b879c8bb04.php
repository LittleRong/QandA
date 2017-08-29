<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:80:"G:\xampp\htdocs\QandA\public/../application/event\view\question\tiku_upload.html";i:1503938433;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<meta name="renderer" content="webkit" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta name="description" content="Plane UI" />
        <meta name="keywords" content="Plane UI" />
		<meta name="author" content="Pandao, pandao@vip.qq.com"/>
		<meta name="robots" content="index,follow" />

		<!-- 禁止百度转码 -->
        <meta http-equiv="Cache-Control" content="no-siteapp"/>

		<!-- 添加到主屏后的标题 iOS6+ -->
		<meta name="apple-mobile-web-app-title" content="Plane UI" />

		<!-- 是否启用 WebApp 全屏模式 -->
		<meta name="apple-mobile-web-app-capable" content="yes" />

		<!-- 设置状态栏的背景颜色，只有在 `"apple-mobile-web-app-capable" content="yes"` 时生效 -->
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<!-- for iOS icons -->
		<link rel="apple-touch-icon-precomposed" href="app/icons/icon-57x57.png" />
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="app/icons/icon-72x72.png" />
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="app/icons/icon-114x114.png" />
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="app/icons/icon-120x120.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="app/icons/icon-144x144.png" />
		<link rel="apple-touch-icon-precomposed" sizes="180x180" href="app/icons/icon-180x180.png">

		<!-- for Android 5 -->
		<meta name="theme-color" content="#0098DF" />

		<!-- Windows 8 metro color -->
		<meta name="msapplication-TileColor" content="#0098DF" />

		<!-- Windows 8 metro icon -->
		<meta name="msapplication-TileImage" content="favicon.png" />

		<!-- closed google auto translate -->
		<meta name="google" value="notranslate" />

		<!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->
		<meta name="HandheldFriendly" content="true" />

		<!-- 微软的老式浏览器 -->
		<meta name="MobileOptimized" content="320" />

		<!-- uc 强制竖屏 -->
		<meta name="screen-orientation" content="portrait" />

		<!-- QQ 强制竖屏 -->
		<meta name="x5-orientation" content="portrait" />

		<!-- UC 强制全屏 -->
		<meta name="full-screen" content="yes" />

		<!-- QQ 强制全屏 -->
		<meta name="x5-fullscreen" content="true" />

		<!-- UC 应用模式 -->
		<meta name="browsermode" content="application" />

		<!-- QQ 应用模式 -->
		<meta name="x5-page-mode" content="app" />

		<!-- windows phone 点击无高光 -->
		<meta name="msapplication-tap-highlight" content="no" />

		<title>发起事件</title>

        <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/event/dist/css/planeui.min.css" />
	</head>
	<body>
		<!-- 代码写在这下面 -->
        <div class="pui-grid">
        	<div class="pui-row">
        		<div class="pui-grid-xs-12">
        			<img src="<?php echo \think\Config::get('web_res_root'); ?>/event/img/header.jpg" style="width: 100%;height: auto;" />
        		</div>
        	</div>
        	<div class="pui-row">
        		<h1 class="pui-text-center">——题库上传——</h1>

				<div class="pui-form-group pui-grid-center">

                    <form class="pui-form pui-input-sm-large pui-input-md-large pui-grid" style="text-align: center" action="<?php echo \think\Config::get('web_res_root'); ?>index.php/event/question/upload" method="post" enctype="multipart/form-data">
                    <label>选择上传的文件</label>
										<a href="<?php echo \think\Config::get('web_res_root'); ?>index.php/event/question/problem_manage">
                    <input type="file" name="image" class="pui-input-border-error"> <input type="submit" class="pui-btn pui-btn-success" name="submit" value="Submit" />
										</a>
										<a href="<?php echo \think\Config::get('web_res_root'); ?>index.php/event/question/problem_manage">
                    <input type="button" class="pui-btn pui-btn-success" name="cancel" value="Cancel" />
										</a>
                    </form>

                </div>

        	</div>


        </div>
        <!-- 代码写在这上面 -->

	</body>

		<!-- jQuery -->
		<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/event/dist/js/planeui.js"></script>
		<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery.min.js"></script>
		<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery-ui.min.js"></script>
		<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/bootstrap.min.js"></script>



</html>
