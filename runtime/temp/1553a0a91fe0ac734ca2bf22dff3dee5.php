<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"G:\xampp\htdocs\QandA\public/../application/index\view\eventmessage\event_message.html";i:1503990156;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta http-equiv="Cache-Control" content="no-siteapp"/>
		<meta name="renderer" content="webkit" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<title>事件详情</title>
        <link rel="icon" type="image/png" href="favicon.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
	</head>
	<body>
	    <div class="pui-layout">
	        <header>
	            <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/header2.jpg" style="width:100%;height: auto">
	        </header>
	    </div>
		<article style="width: 98%;margin: 0 auto">
                <h2 style="margin-top: 10px;text-align: left"><a type="button" class="pui-btn pui-btn-default" href="<?php echo url('index/userindex/user_index'); ?>" >返回</a></h2>
                <h2 style="text-align: left;margin: 0"><?php echo $data['event_message']['event_title']; ?></h2>
                <div class="pui-article-subtitle">
                     类型：<?php echo $data['event_message']['event_type']; ?>
                </div>
								<div class="pui-article-subtitle">
                     简介：<?php echo $data['event_message']['event_description']; ?>
                </div>
                <hr class="pui-hr-dashed">
                <div class="pui-article-content" style="padding: 0">
                    <div class="pui-pui-list-group">
		                <h5>具体规则：</h5>
		                <ul class="pui-list pui-list-line pui-list-stripe pui-list-bordered">
		                    <li>活动时间：<?php echo $data['event_message']['start_time']; ?>至<?php echo $data['event_message']['end_time']; ?></li>
			                    <?php if(!empty($data['event_message']['answer_day'])): ?>
									<li>答题时间：
									<?php foreach($data['event_message']['answer_day'] as $k=>$v): ?>
										<?php echo $v; ?>&emsp;
									<?php endforeach; ?>
									</li>
			                    <?php endif; ?>

		                    <li>积分规则：单选题<?php echo $data['event_message']['single']; ?>道，每题<?php echo $data['event_message']['single_score']; ?>分；
		                    多选题<?php echo $data['event_message']['multiple']; ?>道，每题<?php echo $data['event_message']['multiple_score']; ?>分；判断题<?php echo $data['event_message']['judge']; ?>道，每题<?php echo $data['event_message']['judge_score']; ?>分；填空题<?php echo $data['event_message']['fill']; ?>道，每题<?php echo $data['event_message']['fill_score']; ?>分；当日团队全对额外加<?php echo $data['event_message']['team_score']; ?>分，团队总积分上限<?php echo $data['event_message']['team_score_up']; ?>分，个人总积分上限<?php echo $data['event_message']['person_score_up']; ?>分。</li>
		                    	<?php if(!empty($data['event_message']['item_message'])): ?>
									<li>积分道具：
									<?php foreach($data['event_message']['item_message'] as $k=>$v): ?>
										<?php echo $v; ?>&emsp;
									<?php endforeach; ?>
									</li>
			                   	<?php endif; ?>

		                </ul>
		                <h5>得分情况：</h5>
		                <?php if(!empty($data['credit_message'])): ?>
							<ul class="pui-list pui-list-line">
		                    <li>个人得分：<?php echo $data['credit_message']['credit']; ?></li>
												<li>团队得分：<?php echo $data['credit_message']['team_score']; ?></li>
		                    <li>团队积分：<?php echo $data['credit_message']['team_credit']; ?></li>
		                    <?php if(!empty($data['credit_message']['detail_credit'])): ?>
							<li>积分详情：
								<table class="pui-table pui-table-bordered pui-table-text-center pui-table-thead-bg pui-table-interlaced-color box-shadow-bottom pui-table-gradient">
					                <thead>
					                    <tr>
					                        <th>组ID</th>
					                        <th>积分操作</th>
					                        <th>操作时间</th>
					                    </tr>
					                </thead>
					                <tbody>
					                    <?php foreach($data['credit_message']['detail_credit'] as $k=>$v): ?>
										<tr>
					                        <td><?php echo $v['team_id']; ?></td>
					                        <td><?php echo $v['change_reason']; ?><?php echo $v['change_value']; ?>分</td>
					                        <td><?php echo $v['change_time']; ?></td>
					                    </tr>
										<?php endforeach; ?>

					                </tbody>
					            </table>
							</li>
							<?php else: ?><li>积分详情：暂时没有记录</li>
		                    <?php endif; ?>

		                </ul>
		                <?php else: ?>
		                <div class="pui-article-subtitle">
		                     您暂时没有参与...
		                </div>
		                <?php endif; ?>
		            </div>
                </div>

            </article>
	</body>
</html>
