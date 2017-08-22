<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\xampp\htdocs\QandA\public/../application/admin\view\index\contact.html";i:1503202346;}*/ ?>
<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Contact - Alpha by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="../../../../public/assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>
		<div id="page-wrapper">

			<!-- Header -->
				<header id="header">
					<h1><a href="index.html">Alpha</a> by HTML5 UP</h1>
					<nav id="nav">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li>
								<a href="#" class="icon fa-angle-down">Layouts</a>
								<ul>
									<li><a href="generic.html">Generic</a></li>
									<li><a href="contact.html">Contact</a></li>
									<li><a href="elements.html">Elements</a></li>
									<li>
										<a href="#">Submenu</a>
										<ul>
											<li><a href="#">Option One</a></li>
											<li><a href="#">Option Two</a></li>
											<li><a href="#">Option Three</a></li>
											<li><a href="#">Option Four</a></li>
										</ul>
									</li>
								</ul>
							</li>
							<li><a href="#" class="button">Sign Up</a></li>
						</ul>
					</nav>
				</header>

			<!-- Main -->
				<section id="main" class="container 100%">
					<header>
						<h2>事件录入系统</h2>
						<p>Tell us what you think about our little operation.</p>
					</header>
					<div class="box">
						<form id="myform" method="post" action="./checkall">
							<div class="row uniform 50%">
								<div class="2u 12u(mobilep)">
									<input type="text" name="eid" id="eid" value="" placeholder="事件ID"  />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="aid" id="aid" value="" placeholder="管理员ID" />
								</div>
								<div class="4u 12u(mobilep)">
									<input type="text" name="ename" id="ename" value="" placeholder="事件名称" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="start_time" id="start_time" value="" placeholder="开始时间" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="end_time" id="end_time" value="" placeholder="结束时间" />
								</div>
							</div>
							<div class="row uniform 50%">
								<div class="1u 12u(mobilep)">
									<input type="text" name="single" id="single" value="" placeholder="单选" />
								</div>
								<div class="1u 12u(mobilep)">
									<input type="text" name="multiple" id="multiple" value="" placeholder="多选" />
								</div>
								<div class="1u 12u(mobilep)">
									<input type="text" name="fill" id="fill" value="" placeholder="填空" />
								</div>
								<div class="1u 12u(mobilep)">
									<input type="text" name="judge" id="judge" value="" placeholder="判断" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="pro_ramdom" id="pro_ramdom" value="" placeholder="题目随机" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="opt_ramdom" id="opt_ramdom" value="" placeholder="选项随机" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="ekind" id="ekind" value="" placeholder="事件种类" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="time" id="time" value="" placeholder="答题时长" />
								</div>
							</div>
							<div class="row uniform 50%">
								<div class="2u 12u(mobilep)">
									<input type="text" name="single_score" id="single_score" value="" placeholder="单选分数" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="multiple_score" id="multiple_score" value="" placeholder="多选分数" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="fill_score" id="fill_score" value="" placeholder="填空分数" />
								</div>
								<div class="2u 12u(mobilep)">
									<input type="text" name="judge_score" id="judge_score" value="" placeholder="判断分数" />
								</div>
								<div class="4u 12u(mobilep)">
									<input type="text" name="person_score" id="person_score" value="" placeholder="当日本人全对额外加分" />
								</div>
								<div class="4u 12u(mobilep)">
									<input type="text" name="team_score" id="team_score" value="" placeholder="当日团队全对额外加分" />
								</div>
								<div class="4u 12u(mobilep)">
									<input type="text" name="person_score_up" id="person_score_up" value="" placeholder="个人总积分上限" />
								</div>
								<div class="4u 12u(mobilep)">
									<input type="text" name="team_score_up" id="team_score_up" value="" placeholder="团队总积分上限" />
								</div>
								<div class="12u">
									<textarea name="message" id="message" placeholder="请输入事件描述。" rows="3"></textarea>
								</div>
							</div>
							<div class="row uniform">
								<div class="12u">
									<ul class="actions align-center">
										<li><input id='submit_message' type="button" value="录入" /></li>
									</ul>
								</div>
							</div>
						</form>
					</div>
				</section>

			<!-- Footer -->
				<footer id="footer">
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
						<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
						<li><a href="#" class="icon fa-google-plus"><span class="label">Google+</span></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				</footer>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrollgress.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>

	<!-- jQuery -->
	<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery.min.js"></script>
	<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery-ui.min.js"></script>
	<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
	    $("#submit_message").click(function(){
	        var eid = $("#eid").val();
	        var aid = $("#aid").val();
					var ename = $("#ename").val();
					var start_time = $("#start_time").val();
					var end_time = $("#end_time").val();
					var single = $("#single").val();
	        var multiple = $("#multiple").val();
					var fill = $("#fill").val();
					var judge = $("#judge").val();
					var pro_ramdom = $("#pro_ramdom").val();
					var opt_ramdom = $("#opt_ramdom").val();
					var ekind = $("#ekind").val();
					var time = $("#time").val();
					var single_score = $("#single_score").val();
					var multiple_score = $("#multiple_score").val();
					var fill_score = $("#fill_score").val();
					var judge_score = $("#judge_score").val();
					var person_score = $("#person_score").val();
					var team_score = $("#team_score").val();
					var person_score_up = $("#person_score_up").val();
					var team_score_up = $("#team_score_up").val();
					var message = $("#message").val();

	        if(eid == ''){
	            alert("事件ID不能为空");
	        }else if(aid == ''){
	            alert("管理员ID不能为空");
				  }else if(ename == ''){
			        alert("事件名称不能为空");
	        }else{
	            var post_data = {eid:eid,aid:aid,ename:ename,start_time:start_time,end_time:end_time,single:single,multiple:multiple,
							fill:fill,judge:judge,pro_ramdom:pro_ramdom,opt_ramdom:opt_ramdom,ekind:ekind,time:time,single_score:single_score,
						multiple_score:multiple_score,fill_score:fill_score,judge_score:judge_score,person_score:person_score,
					team_score:team_score,person_score_up:person_score_up,team_score_up:team_score_up,message:message};
	            $.ajax({
	                url:"manage",
	                dataType: "json",
	                type: 'POST',
	                data: post_data,
	                async: false,
	                success: function(data){
	                    alert("跳转成功");
	                    json_data=eval('('+data+')');
											if(json_data['result']=="录入成功!"){
	                        alert(json_data['result']);
													$("#myform").submit();
	                        //登录成功操作......
	                    }else{
	                        alert("录入失败！");
	                        //登录失败操作......
	                    }
	                },
	                error: function(data, status, error){
	                    alert("跳转失败");
	                    alert(error);

	                }
	            });
	        }
	    });
	});

	</script>



</html>
