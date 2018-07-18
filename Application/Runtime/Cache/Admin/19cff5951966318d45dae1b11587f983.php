<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp" />
 <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/Public/css/style.css"/>
        <link href="/Public/assets/css/codemirror.css" rel="stylesheet">
        <link rel="stylesheet" href="/Public/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/Public/font/css/font-awesome.min.css" />
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/Public/js/jquery-1.9.1.min.js"></script>
		<script src="/Public/js/H-ui.js" type="text/javascript"></script>
        <script src="/Public/assets/js/bootstrap.min.js"></script>
		<script src="/Public/assets/js/typeahead-bs2.min.js"></script>
		<script src="/Public/assets/js/jquery.dataTables.min.js"></script>
		<script src="/Public/assets/js/jquery.dataTables.bootstrap.js"></script>
        <script src="/Public/assets/layer/layer.js" type="text/javascript" ></script>
        <script src="/Public/assets/laydate/laydate.js" type="text/javascript"></script>

        <script src="/Public/js/lrtk.js" type="text/javascript" ></script>
<title>个人资料</title>
</head>

<body>
<div class="margin clearfix">
 <div id="refund_style">
     <!--退款列表-->
     <div class="refund_list">
        <table class="table table-striped table-bordered table-hover" id="sample-table">
		<thead>
		<tr>
				<th width="120px">姓名</th>
				<th width="50px">性别</th>
				<th width="80px">微信名称</th>
                <th width="100px">手机号</th>
				<th width="100px">邮箱</th>
                <th width="80px">地址</th>
				<th width="70px">状态</th>
                <th width="150px">操作</th>
		</tr>
		</thead>
 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tbody>
     <tr>
     <td><?php echo ($vo[username]); ?></td>
     <td><?php echo ($vo[sex]); ?></td>
     <td><?php echo ($vo[nickname]); ?></td>
     <td><?php echo ($vo[phone]); ?></td>
     <td><?php echo ($vo[email]); ?></td>
     <td><?php echo ($vo[address]); ?></td>
     <td class="td-status"><span class="label label-success radius" ><?php echo ($vo[state]); ?></span></td>
     <td>
     <button onClick="Delivery_Refund(this,<?php echo ($vo[id]); ?>)"  href="javascript:;" title="同意"  class="btn btn-xs btn-success ty" name="<?php echo ($vo[id]); ?>">同意</button>
     <a title="修改个人信息"  href="<?php echo U('Admin/index/exitCoach',array('id'=><?php echo ($vo[id];?>))); ?>" class="btn btn-xs btn-info Refund_detailed" >修改</a>
     <a title="拒绝" href="javascript:;"  onclick="member_del(this,<?php echo ($i); ?>)" class="btn btn-xs btn-warning" name="<?php echo ($vo[id]); ?>" >拒绝</a>
     </td>
     </tr>
     </tbody><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<div class="result page"><?php echo ($page); ?></div>
</div>
 </div>
</div>
</body>
</html>
<script>
function Delivery_Refund(obj,id){
	layer.confirm('是否同意当前信息！',function(index){
    $.ajax({
            url:"<?php echo U('Admin/Index/examine');?>",//请求地址
            data:{"id":id},//发送的数据
            type:'POST',//请求的方式
            success:function (data) {
                    if(data==1){
                        $(obj).parents("tr").find(".td-manage").prepend('<a style=" display:none" class="btn btn-xs btn-success" onClick="member_stop(this,id)" href="javascript:;" title="已同意">同意</a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt  radius">已同意</span>');
                        $(obj).remove();
                        layer.msg('已同意!',{icon: 6,time:1000});
                    }else{
                        alert("审核不通过");
                    }
            },// 请求成功执行的方法
        })
})
}
/*************************************************************************/
//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.Refund_detailed').on('click', function(){
	var cname = $(this).attr("title");
	var chref = $(this).attr("href");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe').html(cname);
    parent.$('#iframe').attr("src",chref).ready();;
	parent.$('#parentIframe').css("display","inline-block");
	parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
	//parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+" class='iframeurl'>" + cnames + "</a>");
    parent.layer.close(index);
});
/****************************删除整行******************************/
function member_del(obj,id){
    
    layer.confirm('确认要删除吗？',function(index){

         $.ajax({
            url:"<?php echo U('Admin/Index/refuse');?>",//请求地址
            data:{"id":obj.name},//发送的数据
            type:'POST',//请求的方式
            success:function (argument) {
                if(argument=="1"){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000}); 
                }else{
                    alert("请稍后再试")

                }

            },// 请求成功执行的方法
            error:function (argument) {
                alert("请稍后再试")
            },//请求失败调用
        })

       
    });


   



    
}

$(function () {
    var ra = $(".radius");
    var ty = $(".ty");
    for(var i = 0;i<ra.length;i++){
        if(ra[i].innerText=="0"){
            ra[i].innerText="未审核";
        }else if($(".radius")[i].innerText=="1"){
            ty[i].disabled="value";
            ra[i].innerText="已审核";
        }
    }
    ;

});
</script>