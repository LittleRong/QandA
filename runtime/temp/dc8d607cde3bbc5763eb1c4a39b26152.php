<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\xampp\htdocs\QandA\public/../application/user_answer\view\user_index\user_index.html";i:1503059841;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>答题系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
    登录成功，欢迎！！！
    <button type="button" id="logout_btn">退出</button>
</body>
</html>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#logout_btn").click(function(){
            var post_data = {};
            $.ajax({
                url:"logout",
                dataType: "json",
                type: 'POST',
                data: post_data,
                async: false,
                success: function(data){
                    location.reload();
                },
                error: function(data, status, error){
                }
            });
    });
});
</script>
