<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>驾校报名</title>
    <link rel="stylesheet" href="/Public/css/index.css">
    <script src="http//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap-theme.css">
    <script src="/Public/bootstrap/js/bootstrap.js"></script>
    <script src="/Public/bootstrap/js/npm.js"></script>
</head>
<body>
<div class="container-fluid">
        <div class="header ">
            <img src="<?php echo ($res['headimgurl']); ?>"/>
        </div>
        <div class="main">
           欢迎<?php echo ($res['nickname']); ?>报名潍科驾校
        </div>
        <div class="footer">
   			<button type="button" class="btn btn-primary btn-lg btn-block " id = "perfect">点我报名</button>  	
        </div>
</div>
</body>
</html>
<script>
    window.onload = function () {
        var perfect = document.getElementById("perfect");
        perfect.onclick = function(){
            window.location.href="<?php echo U('Wx/Index/exitStudent');?>"; 
        }
 }
</script>