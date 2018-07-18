<?php
namespace Wx\Model;
use Think\Model;
class CoachModel extends Model {
    /**
     * 用户首次报名，数据添加到数据库
     * @param [type] $res [description]
     */
    public function addCoach($res){
    	//var_dump($res['openid']);
        $Coach = M("Coach");
        $data['openid'] = $res['openid'];
        $data['nickname'] = $res['nickname'];
        $data['sex'] = $res['sex'];
        $data['headimgurl'] = $res['headimgurl'];
        $f = $Coach->add($data);
        return $f;
   }
   /**
    * 查询某一位教练
    * @param  [type] $openid [description]
    * @return [type]         [description]
    */
   public function selCoach($openid){
        $Coach = M("Coach");
        $url = "openid='".$openid."'";
        $data = $Coach->where("$url")->find();
        return $data;
   }
   function exitCoachs($data){
        $id = $data['id'];
        $Coach = M("Coach");
        $Coach->nickname=$data['nickname'];
        $Coach->username=$data['username'];
        $Coach->phone=$data['phone'];
        $Coach->email=$data['email'];
        $Coach->address=$data['address'];
        $Coach->age=$data['age'];
        $Coach->introduction=$data['introduction'];
        $f = $Coach->where("id=$id")->save($data);
        return $f;
   }
   //查询所有教练
   public function selCoachs(){
        $Coach = M("Coach");
        $list = $Coach->where("state=1")->select();
        return $list;
   }
   //查询教练的openID
   public function findOpenId($id){
        $Coach = M("Coach");
        $openid = $Coach->where("id=$id")->find();
        return $openid['openid'];
   }
}
