<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"G:\xampp\htdocs\QandA\public/../application/event\view\index\event_manager.html";i:1504029673;}*/ ?>
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

		<title>事件管理主页</title>

        <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
				<link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/user_manage/user_manager.css" />
	</head>
	<body>
		<!-- 代码写在这下面 -->
		<div class="pui-grid">
			<!-- header -->
			<div class="pui-row" style="padding-bottom: 0">
				<div class="pui-grid-xs-12">
					<div class="page-header">
							<div class="pui-layout pui-layout-fixed pui-layout-fixed-1200">
									<div class="pui-menubar pui-menubar-square pui-menubar-header-style pui-bg-none pui-unbordered">
										<div class="pui-menubar-aside">
											<h2 class="pui-margin-none pui-text-normal page-title" title="中国移动南方基地">
												<img src="<?php echo \think\Config::get('web_res_root'); ?>/image/CM.png" class="icon-CM" />
																																					中国移动南方基地知识题库
											</h2>
								</div>
								<div class="pui-menubar-offside">
										<ul class="pui-menu pui-menu-inline pui-menu-simple pui-right">
												<li>
														<a href="#top">管理员</a>
												</li>
												<li>
														<a href="<?php echo url('index/login/change_pwd'); ?>" id="pwchange">密码修改</a>
												</li>
												<li>
														<a href="<?php echo url('index/Login/logout'); ?>">退出</a>
												</li>
										</ul>
								</div>
							</div>
						</div>
				</div>
		</div>
				</div>
			</div>
			<!-- header -->
			<div class="pui-row" style="margin: 0;">
				<div class="pui-grid-xs-2" style="padding-left: 0;">
				<!-- 侧栏 -->
					<div class="SlideMenu" style="margin-top: 0;">
					<div class="pui-btn-group-vertical pui-btn-gradient pui-btn-shadow ">
												<div class="pui-btn-group ">
														<a href="<?php echo url('index/usermanage/user_manage'); ?>" ><button class="pui-btn-style  pui-btn pui-btn-primary pui-btn-large pui-text-shadow"><i class="fa fa-user fa-large"></i> 用户管理</button></a>
														<a href="<?php echo url('manage/Problemmanage/problem_manage'); ?>" ><button class="pui-btn-style  pui-btn pui-btn-primary pui-btn-large pui-text-shadow "><i class="fa fa-list-alt fa-large"></i> 题目管理</button></a>
														<a href="<?php echo url('event/index/showevent'); ?>"><button class="pui-btn-style  pui-btn pui-btn-primary pui-btn-large pui-text-shadow pui-btn-primary-active"><i class="fa fa-file-o fa-large"></i> 事件管理</button></a>
														<a href="<?php echo url('item_manage/item/index'); ?>" ><button class="pui-btn-style  pui-btn pui-btn-primary pui-btn-large pui-text-shadow "><i class="fa fa-th fa-large"></i> 道具管理</button></a>
												</div>
									 </div>
								</div>
								<!-- 侧栏 -->
				</div>
				<br>
				<div class="pui-grid-xs-9">
					<div class="pui-btn-group pui-btn-group-justify" style="width:100% ;">
									<button type="button" class="pui-btn pui-btn-default pui-btn-large">
											正在进行
									</button>
									<button type="button" class="pui-btn pui-btn-default pui-btn-large">
											已经过期
									</button>
							</div>

								<!-- <div class="pui-card-box">
									<h1>《八月照相馆》<small>韩国爱情电影</small></h1>
									<p class="pui-text-indent">《八月照相馆》是由许秦豪执导，韩石圭、沈银河主演的爱情电影。影片讲述了一个发生在已经收到死亡宣告的男子温暖而美丽的故事。该片于1998年1月24日在韩国上映。影片获第34届韩国百想艺术大赏和第19届韩国青龙电影奖最佳电影奖。</p>
									<p class="pui-text-indent">《八月照相馆》的故事灵感来源于韩国已故歌手金光硕一张表情安详温暖的遗照，而该片的大多数主创人员都是出生在八月，所以片名叫做片名《八月照相馆》。</p>
									<p class="pui-text-right"><br><a href="#" class="pui-btn pui-btn-default pui-unbordered">详细 &gt;&gt;</a></p>
					</div> -->

										<?php if($data == ''): ?>
										<div class="pui-card pui-card-shadow pui-card-radius">
										<div class="pui-card-box">
												<h1>当前无事件<small></small></h1>
										</div>
										</div>
										<?php else: foreach($data as $k=>$v): ?>
										<div class="pui-card pui-card-shadow pui-card-radius">
										<div class="pui-card-box">
												<h1><?php echo $v['event_title']; ?><small><?php echo $v['event_type']; ?></small></h1>
												<p class="pui-text-indent"><?php echo $v['event_description']; ?></p>
												<p class="pui-text-right"><br><a href="<?php echo url('event/Question/problem_insert',array('event_id'=>$v['event_id'])); ?>" class="pui-btn pui-btn-default pui-unbordered">配置 &gt;&gt;</a></p>
										</div>
										</div>
										<?php endforeach; endif; ?>




									<a href="<?php echo \think\Config::get('web_res_root'); ?>index.php/event/index/insertevent">
									<input type="button" class="pui-btn pui-btn-primary pui-btn-large" value="发起新事件">
								</a>
						 </div>

					</div>
				</div>
		</div>
        <!-- 代码写在这上面 -->
				<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/event/js/jquery.min.js"></script>
				<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/event/dist/js/planeui.js"></script>
	</body>
</html>
