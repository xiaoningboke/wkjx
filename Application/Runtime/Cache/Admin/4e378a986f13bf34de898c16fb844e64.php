<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp" />
 		<link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/Public/css/styles.css"/>       
        <link href="/Public/assets/css/codemirror.css" rel="stylesheet">
        <link rel="stylesheet" href="/Public/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/Public/assets/css/font-awesome.min.css" />
        	<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/Public/js/jquery-1.9.1.min.js"></script>
        <script src="/Public/assets/js/bootstrap.min.js"></script>
		<script src="/Public/assets/js/typeahead-bs2.min.js"></script>           	
        <script src="/Public/assets/layer/layer.js" type="text/javascript" ></script>          
        <script src="/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="/Public/assets/js/ace-elements.min.js"></script>
		<script src="/Public/assets/js/ace.min.js"></script>
        <title>系统设置</title>

</head>

<body>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
	<form action="" method="post"></form>
    <div class="tab-content">
		<div id="home" class="tab-pane active">
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>微信昵称： </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入微信昵称" value="<?php echo ($data['nickname']); ?>" name="nickname" class="col-xs-10 "></div>
          </div>
           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>性别： </label>
          <div class="col-sm-3">
          	<input type="radio" id="website-title"  value="0" name="sex" class="col-xs-3 ">保密
          </div>
          <div class="col-sm-3">
          	<input type="radio" id="website-title"  value="1" name="sex" class="col-xs-3 ">男
          </div>
          <div class="col-sm-3">
          	<input type="radio" id="website-title"  value="2" name="sex" class="col-xs-3 ">女
          </div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>姓名: </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入姓名" value="<?php echo ($data['username']); ?>" name="username" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>手机号: </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入手机号" value="<?php echo ($data['phone']); ?>" name="phone" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>邮箱: </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入邮箱" value="<?php echo ($data['email']); ?>" name="email" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>地址: </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入地址" value="<?php echo ($data['address']); ?>" name="address" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>年龄: </label>
          <div class="col-sm-9"><input type="text" id="website-title" placeholder="请输入年龄" value="<?php echo ($data['age']); ?>" name="age" class="col-xs-10 "></div>
          </div>

           <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>简介： </label>
          <div class="col-sm-9"><textarea class="textarea"><?php echo ($data[introduction]); ?></textarea></div>
          </div>
          <div class="Button_operation"> 
				<button onclick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i>&nbsp;保存</button>
				
				<button onclick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
               
			</div>
        </div>
        <div id="profile" class="tab-pane ">
        
        </div>
        <div id="dropdown" class="tab-pane">
          
		</div>
		<div id="other" class="tab-pane">
		   <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>屏蔽词： </label>
          <div class="col-sm-9"><textarea class="textarea"></textarea></div>          
          </div>
          <div class="Button_operation"> 
				<button onclick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i>&nbsp;保存</button>
				
				<button onclick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
               
			</div>
	    </div>
		</div>
		</div>
 </div>

</div>
</body>
</html>
<script>

</script>