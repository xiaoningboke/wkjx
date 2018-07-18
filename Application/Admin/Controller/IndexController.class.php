<?php
namespace Admin\Controller;
use Think\Controller;
use Wx\Model\CoachModel;
class IndexController extends Controller {
    public function index(){
      $this->display();
    }
    /**
     * 教练信息操作
     */
    public function Refund()
    {
        $user=M('coach');
        if($_GET['p']==NULL){
             $p=1;
        }else{
             $p=$_GET['p'];
        }
         $list=$user->where("state != 2")->order('id desc')->page($p.',10')->select();
         $this->assign('list',$list);
         $count = $user->where("state = 0")->count();
         $Page = new \Think\Page($count,25);
         $show = $Page->show();
         $this->assign('page',$show);
         $this->display();
    }
    public function examine(){
        $id = $_POST['id'];
        $coach = M('coach');
        $f = $coach-> where("id=$id")->setField('state',1);
        if($f>0){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function refuse(){
        $id = $_POST[id];
        $coach = M('coach');
        $f = $coach-> where("id=$id")->setField('state',2);
         if($f>0){
            echo 1;
        }else{
            echo 0;
        }
    }


     public function exitCoach(){
        $id = $_GET[id];
        $Coach = M("Coach");
        $data = $Coach->where("id=$id")->find();
        $this->assign('data',$data);
        $this->display();
    }
        
}