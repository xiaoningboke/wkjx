<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        var_dump($this->weather("北京"));
    }
    public function weather($city){
		//1.初始化curl
		$ch = curl_init();
		$url = 'https://www.sojson.com/open/api/weather/json.shtml?city='.$city;
		//2.设置curl的参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//3.采集
		$output = curl_exec($ch);
		//4.关闭
		curl_close($ch);
		$wt = (array) json_decode($output,true);
		$wet = $wt["data"]["forecast"][0]["type"];
		return $wet;
    }
}