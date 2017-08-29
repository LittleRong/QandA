<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"G:\xampp\htdocs\QandA\public/../application/item_manage\view\exchange\exchange_item.html";i:1503990716;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="Plane UI" />
    <meta name="keywords" content="Plane UI" />
    <meta name="author" content="Pandao, pandao@vip.qq.com" />
    <meta name="robots" content="index,follow" />

    <!-- 禁止百度转码 -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />

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

    <title>积分兑换</title>

    <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
</head>
<body>
    <!-- 事件ID -->
    <div id="exchange_event" style="display: none;"><?php echo $event_id; ?></div>
    <div class="pui-grid">
        <div class="pui-row" style="margin-bottom: 0">
            <div class="pui-grid-xs-12">
                <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/header.jpg" style="width: 100%; height: auto;" />
            </div>
        </div>
        <div class="pui-row" style="margin: 0;">
            <div class="pui-grid-xs-10" style="margin-top: 20px;">
                <div class="pui-row">
					<div class="pui-grid-xs-3 pui-card pui-card-shadow pui-card-radius">
							<blockquote>
								<p>兑换规则</p>                               
							</blockquote>
							<div>
                                <p>只能由组长兑换</p>
									可用积分：<?php echo $teamCred; ?><br>
									已有道具:<?php if(!empty($haveItem)): foreach($haveItem as $v=>$k): ?>
															 <?php echo $k['item_name']; ?>有<?php echo $k['num']; ?>个
															 <br>
														 <?php endforeach; endif; ?>
							</div>
				</div>
                    <div class="pui-grid-xs-9 pui-card pui-card-shadow pui-card-radius">
                        <h2 style="margin-top: 10px;margin-left:20px;text-align: left"><a type="button" class="pui-btn pui-btn-default" href="<?php echo url('index/userindex/user_index'); ?>" >返回</a></h2>
                        <hr>
                        <div class="pui-row">
                            <?php if(!empty($arr)): foreach($arr as $v=>$k): ?>
        			<div class="pui-grid-xs-4">
                        <div class="pui-center pui-text-center">
                            <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/道具.jpg" class="pui-img-thumbnail pui-img-xl" />
                        </div>
                        <div class="exchange_item" style="display: none;"><?php echo $k['item_id']; ?></div>
                        <div class="pui-center pui-text-center">
                            道具名：<?php echo $k['item_name']; ?>
                        </div>
                        <div class="pui-center pui-text-center">
                            道具描述：<?php echo $k['item_description']; ?>
                        </div>
                        <div class="pui-center pui-text-center">
                            兑换积分:<?php echo $k['change_rule']; ?>
                        </div>
                        <div class="pui-center pui-text-center">
                            剩余：
                  <?php if(!empty($k['amount'])): ?>
                  <?php echo $k['amount']; else: ?>
                  无限
                  <?php endif; ?>

                        </div>
                        <div class="pui-center pui-text-center">
                            最多可兑换：
                  <?php if(!empty($k['team_amount'])): ?>
                  <?php echo $k['team_amount']; else: ?>
                  无限
                  <?php endif; ?>
                        </div>
												<?php if($isLeader==1): ?>
                        <div class="pui-center pui-text-center">
                            <input type="button" class="exchange_btn pui-btn pui-btn-primary pui-btn-small" value="兑换">
                        </div>
												<?php endif; ?>
                    </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
        <!-- 代码写在这上面 -->
    <script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/js/planeui.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".exchange_btn").click(function () {
                var exchange_item = $(this).parent().parent().find('.exchange_item').html();//获取exchange_item
                var exchange_event = $('#exchange_event').html();
                var post_data = { exchange_item: exchange_item, exchange_event: exchange_event };
                $.ajax({
                    url: "<?php echo url('item_manage/Exchange/exchange'); ?>",
                    dataType: "json",
                    type: 'POST',
                    data: post_data,
                    async: false,
                    success: function (data) {
                        json_data = eval('(' + data + ')');
                        alert(json_data['result']);
                        window.location.reload();
                    },
                    error: function (data, status, error) {
                    }
                });
            });
        });
    </script>

</body>
</html>
