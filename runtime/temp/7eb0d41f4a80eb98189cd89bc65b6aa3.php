<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:94:"G:\xampp\htdocs\QandA\public/../application/problem_manage\view\user_problem\user_problem.html";i:1503988859;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta http-equiv="Cache-Control" content="no-siteapp"/>
		<meta name="renderer" content="webkit" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

		<title>开始答题</title>
        <link rel="icon" type="image/png" href="favicon.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo \think\Config::get('web_res_root'); ?>/css/planeui.min.css" />
	</head>
	<body>
	<div id="load" style="position: fixed;height: 100%;width:100%;background: #eee;filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5;display: none   ">
		<div class="pui-loading pui-loading-ring-large" style="margin: 0 auto;margin-top:20%"></div>
    </div>
    <div  class="pui-layout">
        <header>
            <div style="position: relative;">
                <img src="<?php echo \think\Config::get('web_res_root'); ?>/img/header2.jpg" style="width: 100%;height: auto">
                <div class="form-group pui-btn-gradient pui-btn-shadow" style="position: absolute;bottom: 10px;right: 20px">
                    <input type="button" class="pui-btn pui-btn-small pui-btn-default " value="小明">
                    <a type="button" class="pui-btn pui-btn-small pui-btn-primary " href="<?php echo url('index/Login/logout'); ?>" >退出</a>
                </div>
            </div>
        </header>
    </div> 
    <div id="content" class="pui-layout" style="width:96%;margin-top:30px ">
		<div class="pui-row">
		   	<div class="pui-grid-xs-3 pui-grid-xs-push-9 pui-grid-sm-3 pui-grid-sm-push-9 pui-grid-md-3 pui-grid-md-push-9 pui-grid-lg-3 pui-grid-lg-push-9 pui-grid-xl-3 pui-grid-xl-push-9 pui-grid-xxl-3 pui-grid-xxl-push-9 ">
		    	<div class="pui-text-center">
		     		<h4 style="color: #008EE5">倒计时：32分钟</h4>
		    		<div style="text-align:center;">
						<input type="button" class="pui-btn pui-btn-primary" id="submit" value="交卷">
					</div>
		    	</div>
		   	</div>
			<div class="pui-grid-xs-9 pui-grid-xs-pull-3 pui-grid-sm-9 pui-grid-sm-pull-3 pui-grid-md-9 pui-grid-md-pull-3 pui-grid-lg-9 pui-grid-lg-pull-3 pui-grid-xl-9 pui-grid-xl-pull-3 pui-grid-xxl-9 pui-grid-xxl-pull-3 ">
				<div>
			 		<ul class="pui-menu  pui-menu-radius pui-menu-inline pui-menu-bordered pui-text-center" style="margin-bottom: 0px;">
			            <li style="width: 25%">
			                <a href="javascript:;" id="single" class="choose_btn" >单选</a>
			            </li>
			            <li style="width: 25%">
			                <a href="javascript:;" id="multi"  class="choose_btn">多选</a>
			            </li>
			            <li style="width: 25%">
			                <a href="javascript:;" id="judge"  class="choose_btn">判断</a>
			            </li>
			            <li style="width: 25%">
			                <a href="javascript:;" id="fill"  class="choose_btn">填空</a>
			            </li>
			        </ul>

			        <div class="pui-center pui-text-center f24" style="width:70%;">
						<h6 style="color: #aaa">今日题量：总共10道题，单选5道，多选2道，判断2道，填空1道</h6>
					</div>
						<?php foreach($data as $v=>$k): if(is_array($k)): ?>
								<div id="<?php echo $v; ?>_panel" class="tixing_panel pui-layout">
									<?php foreach($k as $v2=>$k2): ?>
										<div class="timu_item pui-card pui-card-shadow pui-card-radius" id="<?php echo $k2['problem_id']; ?>">
			                				<div class="pui-card-box">
			                    			<h5><?php echo $v2+1; ?>、<?php echo $k2['problem']; ?></h5>

											<?php if(array_key_exists('option',$k2)): if($v == 'single'): foreach($k2['option'] as $v3=>$k3): ?>
														<input type="radio" name="<?php echo $v; ?>_<?php echo $k2['problem_id']; ?>" id="<?php echo $k3['q_id']; ?>"><?php echo $v3; ?>、<?php echo $k3['content']; ?> <br>
													<?php endforeach; else: foreach($k2['option'] as $v3=>$k3): ?>
														<input type="checkbox" name="<?php echo $v; ?>_<?php echo $k2['problem_id']; ?>" id="<?php echo $k3['q_id']; ?>"><?php echo $v3; ?>、<?php echo $k3['content']; ?> <br>
													<?php endforeach; endif; else: if($v == 'judge'): ?>
													<input type="radio" name="<?php echo $v; ?>_<?php echo $k2['problem_id']; ?>" value="1">对<br>
													<input type="radio" name="<?php echo $v; ?>_<?php echo $k2['problem_id']; ?>" value="0">错
												<?php endif; if($v == 'fill'): ?>
													<input type="text" name="<?php echo $v; ?>_<?php echo $k2['problem_id']; ?>" ><br>
													<?php endif; endif; ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php else: endif; endforeach; ?>
				<br>
				</div>

			</div>
		</div>
	</div>
	<div id="submit_result" style="display:none;width: 90%;margin: 0 auto;">
		<h5>&emsp;您的得分是：<span id="per_score"></span>；团队总得分：<span id="all_score"></span>
		<input type="button" class=" pui-btn pui-btn-primary" style="float:right" value="回到个人主页" >
		</h5>
		<div class="pui-timeline">
            <div class="pui-timeline-list"> 
                <div class="pui-timeline-divider pui-timeline-divider-line">您所在的队伍：</div>
                <div class="pui-timeline-item pui-timeline-badge-date">
                    <label class="pui-badge pui-badge-info">2017-12-05</label>
                    <div class="pui-timeline-item-context">
                        小明 获得了80分
                    </div>
                </div> 
                <div class="pui-timeline-item pui-timeline-badge-datetime">
                    <label class="pui-badge pui-badge-info">2017-11-05</label>
                    <div class="pui-timeline-item-context">
                        小张 获得了100分
                    </div>
                </div> 
            </div>
        </div>
	</div>
<script type="text/javascript" src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('.choose_btn').bind('click',function(){
			var id=$(this).attr('id');
			var id_panel=id+'_panel';
			$('.choose_btn').removeClass('active');
			$(this).addClass('active');
			$('.tixing_panel').hide();
			$('#'+id_panel).show();

		});
		$('#single').click();

		$('#submit').bind("click",function(){
			var user_answer ={} ;
			var answer_single={};


			//获取单选题id以及答案
			var single_items=new Array();
			var single_length=$("#single_panel .timu_item").length;
			for(var i=0;i<single_length;i++){
				//s:单选题id;s_answer:单选题答案id
				var s=$("#single_panel .timu_item").eq(i).attr('id');
				var s_answer=$("#single_panel .timu_item input[type='radio']:checked").eq(i).attr("id");

				var answer_single={};
	        	answer_single['problem_id']=s;
	        	answer_single['q_id']=s_answer;

				single_items[i]=answer_single;

			}

			var multi_items=new Array();
			//获取多选题id以及答案
			var multi_length=$("#multi_panel .timu_item").length;
			for(var i=0;i<multi_length;i++){
				var m=$("#multi_panel .timu_item").eq(i).attr('id');
				var m_id='input[name=multi_'+m+']:checked';
				var m_answers=$("#multi_panel .timu_item").eq(i);
				var m_answers_lengths=m_answers.length;

				//m:多选题id;id_array：多选题答案数组
				var id_array=new Array();
				$(m_id).each(function(){
				    id_array.push($(this).attr('id'));//向数组中添加元素
				});
				// var idstr=id_array.join(',');//将数组元素连接起来以构建一个字符串
				var answer_multi={};

	        	answer_multi['problem_id']=m;
	        	answer_multi['q_id']=id_array;

	        	multi_items[i]=answer_multi;
			}

			//获取判断题id以及答案
			var judge_items=new Array();
			var judge_length=$("#judge_panel .timu_item").length;
			for(var i=0;i<judge_length;i++){
				var j=$("#judge_panel .timu_item").eq(i).attr("id");
				var j_answer=$("#judge_panel .timu_item input[type='radio']:checked").eq(i).attr("value");
				
				var answer_judge={};
	        	answer_judge['problem_id']=j;
	        	answer_judge['answer']=j_answer;
				
				judge_items[i]=answer_judge;

			}

			//获取填空题id以及答案
			var fill_items=new Array();
			var fill_length=$("#fill_panel .timu_item").length;
			for(var i=0;i<fill_length;i++){
				var f=$("#fill_panel .timu_item").eq(i).attr("id");
				var f_answer=$("#fill_panel .timu_item input[type='text']").eq(i).attr("value");
				
				var answer_fill={};
	        	answer_fill['problem_id']=f;
	        	answer_fill['answer']=f_answer;
				
				fill_items[i]=answer_fill;

			}

			user_answer['single']=	single_items;
			user_answer['multi']=	multi_items;
			user_answer['judge']=	judge_items;
			user_answer['fill']=	fill_items;
			$.ajax({  
                type: "POST",  
                url: '../answer/SubmitAnswer',  
                async: true, //同步  
                dataType: "json",  
                data:user_answer,  
                //后台执行完成后，返回页面处理函数  
                beforeSend:function(){
                	$("#load").show();
                },
                success: function(results){
                	$("#load").hide();
                	$("#content").hide();
                	var parsedJson = jQuery.parseJSON(results); 
                	//alert(parsedJson.user_credit);
                	$("#per_score").text(parsedJson.user_credit);
                	$("#submit_result").show();
                }
            });
		});

	})
</script>

</body>
</html>
