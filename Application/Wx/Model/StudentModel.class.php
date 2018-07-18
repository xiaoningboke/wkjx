<?php
namespace Wx\Model;
use Think\Model;
class StudentModel extends Model {
    /**
     * 用户首次报名，数据添加到数据库
     * @param [type] $res [description]
     */
    public function addStudent($res){
    	//var_dump($res['openid']);
        $Student = M("Student");
        $data['openid'] = $res['openid'];
        $data['nickname'] = $res['nickname'];
        $data['sex'] = $res['sex'];
        $data['headimgurl'] = $res['headimgurl'];
        $f = $Student->add($data);
        return $f;
   }
   /**
    * 查询某一位学生
    * @param  [type] $openid [description]
    * @return [type]         [description]
    */
   public function selStudent($openid){
        $Student = M("Student");
        $url = "openid='".$openid."'";
        $data = $Student->where("$url")->find();
        //var_dump($openid);
        //var_dump($data);
        return $data;
   }
   function exitStudents($data){
        $id = $data['id'];
        $Student = M("Student");
        $Student->nickname=$data['nickname'];
        $Student->username=$data['username'];
        $Student->phone=$data['phone'];
        $Student->email=$data['email'];
        $Student->address=$data['address'];
        $Student->age=$data['age'];
        $Student->coach=$data['coach'];
        $f = $Student->where("id=$id")->save($data);
        return $f;
   }
   //根据教练的id查询该教练的所有学生
   function selStu($Co_id){
        $Student = M("Student");
        $list = $Student->where("coach=$Co_id")->order('id desc')->select();
        return $list;
   }
    public function findStu($id){
     $Student = M("Student");
     $url = "id='".$id."'";
     $data = $Student->where("$url")->find();
    return $data;
   }
   //修改学员状态
   public function exitState($id){
    $Student = M("Student");
    $Student->state = '已通过';
    $i = $Student->where("id = $id")->save(); 
    return $i;
   }
   //接受学员信息的修改
   public function exitSubject($data){
        $id = $data['id'];
        $Student = M("Student");
        $Student->subjectone=$data['subjectone'];
        $Student->subjecttwo=$data['subjecttwo'];
        $Student->subjectthree=$data['subjectthree'];
        $Student->subjectfour=$data['subjectfour'];
        $f = $Student->where("id=$id")->save($data);
        return $f;
   }

}
