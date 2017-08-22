<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\xampp\htdocs\QandA\public/../application/index\view\login\index.html";i:1503124189;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>答题系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo \think\Config::get('web_res_root'); ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo \think\Config::get('web_res_root'); ?>/css/jquery-ui.min.css">
</head>
<body>
    <form id="login_form" method="post">
        <h3>用户登录</h3>
        <div>
            <label>用户名</label>
            <input type="text" id="username" name="username"/>
        </div>
        <div>
            <label>密码</label>
            <input type="password" id="password" name="password"/>
        </div>
        <div>
            <input id="login_btn" type="submit" name="submit" value="登陆"/>
        </div>
    </form>
</body>
<!-- jQuery -->
<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery.min.js"></script>
<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/jquery-ui.min.js"></script>
<script src="<?php echo \think\Config::get('web_res_root'); ?>/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#login_btn").click(function(){
        var username = $("#username").val();
        var password = $("#password").val();
        if(username == ''){
            alert("用户名不能为空");
        }else if(password == ''){
            alert("密码不能为空");
        }else{
            var post_data = {username:username,password:password};
            $.ajax({
                url:"login",
                dataType: "json",
                type: 'POST',
                data: post_data,
                async: false,
                success: function(data){
                    alert("跳转成功");
                    json_data=eval('('+data+')');
                    if(json_data['result']=="登陆成功"||json_data['result']=="已登陆"){
                        alert(json_data['result']);
                        //登录成功操作......
                    }else{
                        alert(json_data['result']);
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
