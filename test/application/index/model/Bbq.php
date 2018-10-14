<?php
namespace app\index\model;

use think\Model;
use think\Db;
class Bbq extends Model
{
    protected $table = 'bbq';

    //获取所有信息
    public function lists($data)
    {
        $res['count']=Db::table($this->table)
            ->where($data['where'])
            ->count();
        $allPage=ceil( $res['count']/$data['pagesize']);
        if($data['page']<=1  )
        {
            $data['page']=1;
        }
        else if($data['pagesize'] >= $allPage)
        {
            $data['page']=$allPage;
        }
        $res['allPage']=$allPage;
        $res['page']=$data['page'];
        $res['pagesize']=$data['pagesize'];
        $res['code']="1";
        $res['msg']="请求成功";
        $res['data'] = Db::table($this->table)
            ->where($data['where'])
            ->order($data['order'])
            ->limit(($data['page']-1)*$data['pagesize'],$data['pagesize'])
            ->select();
        return $res;
    }
    //新增一条信息
    public function addOne($data)
    {
        return Db::table($this->table)->insertGetId($data);
    }
    //修改一条修改


}