<?php
namespace Wx\Controller;

use Wx\Model\StudentModel;
use Wx\Model\CoachModel;

use Think\Controller;
class IndexController extends Controller {
    /**
     * 验证接入
     * @return [type] [description]
     */
    public function index(){
        //获得参数 signature nonce token timestamp echostr
		$nonce     = $_GET['nonce'];
		$token     = 'xxxx';
		$timestamp = $_GET['timestamp'];
		$echostr   = $_GET['echostr'];
		$signature = $_GET['signature'];
		//形成数组，然后按字典序排序
		$array = array();
		$array = array($nonce, $timestamp, $token);
		sort($array);
		//拼接成字符串,sha1加密 ，然后与signature进行校验
		$str = sha1( implode( $array ) );
		if( $str  == $signature && $echostr ){
			//第一次接入weixin api接口的时候
            echo  $echostr;
			exit;
		}else{
			$this->reponseMsg();
		}
    }

    /**
     * 回复纯文本
     * @param  [type] $postObj [description]
     * @param  [type] $Con     [description]
     * @return [type]          [description]
     */
    public function reponseOneMsg($postObj,$Con){
            $content  = $Con;
            $toUser   = $postObj->FromUserName;
            $fromUser = $postObj->ToUserName;
            $time     = time();
            $msgType  =  'text';
            $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            </xml>";
             $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
             return $info;
    }
    
    /**
     * 判断消息事件
     * @param  [type] $Con [description]
     * @return [type]      [description]
     */
    public function reponseMsg($Con){
    	//1.获取到微信推送过来post数据（xml格式）
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		//2.处理消息类型，并设置回复类型和内容
		$postObj = simplexml_load_string( $postArr );//xml转换成对象
        //判断该数据包是否是订阅的事件推送
        if( strtolower( $postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if( strtolower($postObj->Event == 'subscribe') ){
                $Con = "欢迎关注潍科驾校 \n <a href = 'http://wx.sunxiaoning.com/index.php/wx/index/getUserDetail' >点我报名</a> ";
                $info = $this->reponseOneMsg($postObj,$Con);
                echo "$info";
            }
        }
		//判断是否是用户回复过来的消息
		//用户发送过来消息后回复图文消息或者是单文本消息
		if( strtolower($postObj->MsgType) == 'text' ){
			/////////此处用于自动回复客户发来的信息
    }
    if (strtolower($postObj->Event)=='click') {
        //如果是自定义菜单中的event -> click
        if(strtolower($postObj->EventKey)=='item1'){
            $Con = "请按照提示操作 \n <a href = 'http://wx.sunxiaoning.com/index.php/wx/index/getUserDetail' >点我报名</a> ";
            $info = $this->reponseOneMsg($postObj,$Con);
            echo "$info";
        }
    }
}
    /**
     * 返回access_token
     * @return [type] [description]
     */
    public function getWxAccessToken(){
    	
    		//如果access_token不存在或者已经过期，重新获取access_token
    		$appid = 'wxde8d3eacc9f91cae';
    		$appsecret = '3ae10c48de0ec193a7cc695f098c2817';
    		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    		$res = $this->http_curl($url,'get','json');
    		$access_token = $res['access_token'];
    		return $access_token;
    
    }
    /**
     * 创建自定义菜单
     * @return [type]
     */
    public function defineditem(){
    	//创建微信菜单
    	//目前微信接口的调用都是通过curl  post/get
    	header('content-type:text/html;charset=utf-8');
    	$access_token = $this->getWxAccessToken();
    	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
    	$postArr = array(
    			'button'=>array(
    				array(
    					'name'=>urlencode('点我报名'),
    					'type'=>'view',
    					'url'=>'http://wx.sunxiaoning.com/index.php/wx/index/getUserDetail',
    				),//第一个一级菜单
		    		array(
		    			'name'=>urlencode('我的信息'),
		    			'sub_button'=>array(
		    				array(
		    					'name'=>urlencode('我是学员'),
		    					'type'=>'view',
                                'url'=>'http://wx.sunxiaoning.com/index.php/wx/index/getUserDetail',
		    				),//第一个二级菜单
							array(
								'name'=>urlencode('我是教练'),
								'type'=>'view',
								'url'=>'http://wx.sunxiaoning.com/index.php/wx/index/getCoachDetail',
							)//第一个二级菜单
		    			)
		    		),//第二个一级菜单
		    		array(
		    			'name'=>urlencode('帮助'),
		    			'type'=>'click',
		    			'key'=>'item1',
		    		)//第三个一级菜单
    			)
    		
    	);
    	$postJson = urldecode(json_encode($postArr));
    	//echo "$postJson"."<br>";
    	$res = $this->http_curl($url,'post','json',$postJson);
    	var_dump($res);
    }
    /**
     * 单文本
     * @return [type]
     */
    public function sendMsgAll(){
        //1.获取全局access_token
        $access_token = $this->getWxAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$access_token;
        //2.组装群发接口数据array
        $array = array(
            'touser'=>'o4g6-0VC0xbw5CnvWR2RGZtJg8ME',//微信用户的openid
            'text'=>array('content'=>'小宁博客'),//文本内容
            'msgtype'=>'text'//消息类型
        );
        //3.将数组转换成json
        $postJson = json_encode($array);
        //4.调用curl
        $res = $this->http_curl($url,'post','json',$postJson);
        var_dump($res);
    }


    //详细授权
    function getUserDetail(){
        //1.获取到code
        $appid = "wxde8d3eacc9f91cae";
        $redirect_uri = urlencode("http://wx.sunxiaoning.com/index.php/Wx/index/getUserInfo");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:'.$url);
    }
    function getUserInfo(){
        //2.获取到网页授权的access_token
        $appid = "wxde8d3eacc9f91cae";
        $appsecret = "3ae10c48de0ec193a7cc695f098c2817";
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        //3.拉取用户的openid
        $res = $this->http_curl($url,'get');
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        //4.拉取用户的详细信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_curl($url);
        //var_dump($res['openid']);
        session('res',$res);
        if(empty($res['openid'])){
            echo "服务器繁忙，请稍后再试";
        }else{
            $Student = new StudentModel();
            $data = $Student->selStudent($openid);
            if(empty($data)){
                $f = $Student->addStudent($res);
                if($f>0){
                    $Con = "自动回复";
                    $info = $this->reponseOneMsg($res,$Con);

                    ///////此处用于回复模板消息

                    $this->assign('res',$res);
                    $this->display();
                }else{
                     echo "服务器繁忙，请稍后再试";
                }
            }else{
                $this->redirect('Index/exitStudent');
            }
        }
    }
    /**
     * 完善信息
     * @return [type] [description]
     */
        public function exitStudent(){
        if(session('?res')){
            $res = session('res');
            $Student = new StudentModel();
            $coach = new CoachModel();
            $coa = $coach->selCoachs();
            $this->assign('coach',$coa);
            $data = $Student->selStudent($res['openid']);
            if(empty($data['coach'])){
                    $this->assign('data',$data);
                    $this->display();
            }else{
                 $this->assign('data',"已报名");
                 $this->display('exitStu');
            }

        }else{
            echo "请刷新后再试";
        }
    }
    public function exitStu(){
        $data = $_POST;
        $Coach = new CoachModel();
        $coachOpenid = $Coach->findOpenId($data['coach']);
        $Student = new StudentModel();
        $f = $Student->exitStudents($data);
        $res = session('res');
        if($f>0){
            $url = "http://wx.sunxiaoning.com/index.php/wx/index/CoaSelStu";
            $urlstu="http://wx.sunxiaoning.com/index.php/wx/index/exitStudent";
            $this->sendTemplateMsg($coachOpenid,$data['nickname'],$data['username'],$data['phone'],$url);
            $this->sendTemplateMsg($res['openid'],$data['nickname'],$data['username'],$data['phone'],$urlstu);

            $this->assign('data',"报名成功");
        }else{
            $this->assign('data',"已报名");
        }
            $this->display();
    }
    /**
     * 消息模板
     * @return [type]
     */
    public function sendTemplateMsg($user,$nickname,$username,$phone,$urlstucoa){
        //1.获取到access_token
        $access_token = $this->getWxAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        //2.组装数组
        $array = array(
            'touser'=>$user,
            'template_id'=>'C_OmBD-RfzETlbTzvTVLyRyV_lMaW9FdgUam5nFYbxU',
            'url'=>$urlstucoa,
            'data'=>array(
                'nickname'=>array('value'=>$nickname,'color'=>'#173177'),
                'username'=>array('value'=>$username,'color'=>'#173177'),
                'phone'=>array('value'=>$phone,'color'=>'#173177'),
                'date'=>array('value'=>date('Y-m-d H:i:s') ,'color'=>'#173177')
            )

        );
        //3.将数组转换为json
        $postJson = json_encode($array);
        //4.调用curl函数
        $res = $this->http_curl($url,'post','json',$postJson);
        //var_dump($res);
 
    }

    /**
     * @param  url
     * @param  获取方式
     * @param  获取到的格式
     * @param  string
     * @return [type]
     */
    function http_curl($url,$type='get',$res='json',$arr=''){
        //1.初始化curl
        $ch = curl_init();
        //2.设置curl的参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if($type == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        if($res == 'json'){
            if(curl_errno($ch)){ 
                return curl_error($ch);
            }else{
                return json_decode($output,true);
            }
        }
        curl_close($output);
    }


    ////////////////////////////////教练////////////////////////////////
    function getCoachDetail(){
        //1.获取到code
        $appid = "wxde8d3eacc9f91cae";
        $redirect_uri =urlencode("http://wx.sunxiaoning.com/index.php/Wx/index/getCoachInfo");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header('location:'.$url);
    }
    function getCoachInfo(){
        //2.获取到网页授权的access_token
        $appid = "wxde8d3eacc9f91cae";
        $appsecret = "3ae10c48de0ec193a7cc695f098c2817";
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        //3.拉取用户的openid
        $res = $this->http_curl($url,'get');
        $access_token = $res['access_token'];
        $openid = $res['openid'];
        //4.拉取用户的详细信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->http_curl($url);
        //var_dump($res['openid']);
        session('res',$res);
        if(empty($res['openid'])){
            echo "服务器繁忙，请稍后再试";
        }else{
            $Coach = new CoachModel();
            $data = $Coach->selCoach($openid);
            if(empty($data)){
                $f = $Coach->addCoach($res);
                if($f>0){

                    $this->assign('res',$res);
                    $this->display();
                }else{
                     echo "服务器繁忙，请稍后再试";
                }
            }else{
                if($data['state'] == '0'){
                    $this->redirect('Index/exitCoa');
                }else{
                    $this->redirect('Index/CoaSelStu');
                }
            }
        }
    }
    //查看学员
    public function exitCoa(){
        if(session('?res')){
            $res = session('res');
            $Coach = new CoachModel();
            $data = $Coach->selCoach($res['openid']);
            $this->assign('data',$data);
            $this->display();
        }else{
            echo "请刷新后再试";
        }
    }
    public function exitCoach(){
        $data = $_POST;
        $Coach = new CoachModel();
        $f = $Coach->exitCoachs($data);
        if($f>0){
      
            $this->assign('data',"修改成功");
        }else{
            $this->assign('data',"未修改");
        }
            $this->display();
    }

    //查看所有学员
    public function CoaSelStu(){
        $openid = session('res')['openid'];
        $Coach = new CoachModel();
        $id = $Coach->selCoach($openid)['id'];
        $Student = new StudentModel();
        $Stu = $Student->selStu($id);
        $this->assign('data',$Stu);
        $this->display();
    }
    //查看每一个学员的信息
    public function findStu(){
        var_dump("eeeee");
        $id = $_GET['id'];
        $Student = new StudentModel();
        $data = $Student->findStu($id);
        $this->assign('data',$data);
        $this->display();
    }
    //通过学员的状态
    public function ByStu(){
        $id = $_POST['id'];
        $Student = new StudentModel();
        $i = $Student->exitState($id);
        if($i>0){
            echo "成功通过";
        }else{
            echo "状态未改变";
        }
    }
    //录入学员的成绩
    public function score(){
        $id =  $_GET['id'];
        $Student = new StudentModel();
        $Stu = $Student->findStu($id);
        $this->assign('data',$Stu);
        $this->display();
    }
    //接受成绩
    public function exitScore(){
        $data = $_POST;
        $Student = new StudentModel();
        $f = $Student->exitSubject($data);
        if($f>0){
            $this->success("录入成功");
        }else{
            $this->error("录入失败");
        }
    }
}

