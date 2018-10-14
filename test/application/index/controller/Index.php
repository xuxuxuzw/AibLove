<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
class Index extends Controller
{
    public function index()
    {
        session_start();
        $user= isset($_SESSION['think']['user'])?$_SESSION['think']['user']:null;
        $content=input("content", "");
        $model = new \app\index\model\Bbq();
        $where=[
            "where"=>"`id` like '%$content%' or `bbq_from` like '%$content%' or `bbq_content` like '%$content%'  or `bbq_to` like '%$content%' ",
            "order"=>"time desc",
            "page"=>input("page", 1),
            "pagesize"=>input("pagesize", 3)
        ];
        $data=$model->lists($where);

        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = Db::table('bbq')->where("`id` like '%$content%' or `bbq_from` like '%$content%' or `bbq_content` like '%$content%'  or `bbq_to` like '%$content%' ")->paginate(input("pagesize", 3));
        $page = $list->render();
        // 把分页数据赋值给模板变量list
         $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign("user",$user);
        $this->assign("lists",$data);
    	return $this->fetch("/index/index");
    }
    public function save()
    {
        $model = new \app\index\model\Bbq();
        $_POST['time']=date("Y-m-d H:i:s",time());
        $_POST['ip']=$_SERVER["REMOTE_ADDR"];
        $data=$_POST;
        $ret=$model->addOne($data);
        if($ret>0)
        {
            return $this->redirect('index/index');
        }
        else
        {
            return $this->fetch('index/index');
        }
    }
    public function logout()
    {
        Session::clear();
        return $this->redirect('index/index');
    }
}
