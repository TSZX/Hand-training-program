<?php

namespace app\admin\controller;


use app\admin\model\CollegeData;
use think\Request;
use think\Session;

//学院管理 类
class College extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */

    public function index()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $page = 0 ;
        $data  = Request::instance()->param();
        if(isset($data['page']))
        {
            $page = $data['page'];
        }

        $Base = new CollegeData();
        $return = $Base->getData_list($page);
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$return["total"]);//总页面

        return $this->fetch();
    }
    public  function  add(){
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }

        return  $this->fetch();
    }
    public  function  updata(){
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $get = Request::instance()->param();
        $Base = new CollegeData();
        $data = $Base->getCollege($get);//获取数据
        $this->assign("data",$data);//总页面
        return  $this->fetch();//"updata"
    }

    public function  updatadata()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $get = Request::instance()->param();
        $Base = new CollegeData();
        $re = $Base->updataCollege($get);//根据id更改管理员
        if($re == 1 ){
            return "<script> alert('更改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('更改失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
    public  function  insetCollege()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }

        $get = Request::instance()->param();
        $Base = new CollegeData();
        $re = $Base->insetcollege($get);//根据提交的表单增加学院 及其管理员
        if($re == 1 ){

            return "<script> alert('新增成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('新增失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
    public  function  deleteCollege()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $get = Request::instance()->param();
        $Base = new CollegeData();
        $re = $Base->deletecollege($get);//根据删除的表单增加学院 及其管理员
        if($re == 1 ){
            $this->redirect(url("college/index"));
        }else {

            $this->redirect(url("college/index"));
        }

    }
}
