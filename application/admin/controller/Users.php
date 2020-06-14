<?php

namespace app\admin\controller;

use app\admin\model\AdminModealidatel;
use app\admin\model\projectData;
use app\admin\model\roleData;
use app\admin\model\userData;
use app\index\model\IndexStudent;
use think\Controller;
use think\Request;
use think\Session;

class Users extends Base
{

    public function deleteData(){
        if (Session::get('role_id')<4){
            return "<script> alert('权限不够 '); </script>";
        }
        $data  = Request::instance()->param();
        $id = $data["id"];
        $Base = new AdminModealidatel();
        $re = $Base->where("user_id",$id)->delete();
        if($re==1){
            return ["code"=>0,"msg"=>"删除成功"];
        }else{
            return ["code"=>1,"msg"=>"删除失败"];
        }
    }
    public function index()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $Base = new userData();
        $page = 0 ;
        $data  = Request::instance()->param();
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        if(isset($data['submit_test']))
        {

            $return = $Base->getData_list_where($page,$data["select_class"]);
        }
        else
        {
            $return = $Base->select_user_page($page);
        }
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$return["total"]);//总页面
        return  $this->fetch();
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
        $get  = Request::instance()->param();
        $Base = new userData();
        $data = $Base->getuser($get);//获取数据
        $this->assign("data",$data);//总页面
        return  $this->fetch();
    }


    public  function  insetuser(){
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $data  = Request::instance()->param();
        $Base = new userData();
        $role = new roleData();
        $re = 0 ;
        if($data['password']===$data['password2'])
        {

            $re = $Base->insetuser($data,$role->get_role_name($data["adminRole"]));
        }
        if($re == 1 ){
            return "<script> alert('增加成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('增加失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }

    }

    public function updatadata()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $Base = new userData();
        $role = new roleData();
        $data  = Request::instance()->param();
        $re = 0 ;
        if($data['password']===$data['password2'])
        {

            $re = $Base->updatauser($data,$role->get_role_name($data["adminRole"]));
        }
        if($re == 1 ){
            return "<script> alert('修改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('修改失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
    public function updataindex(){
        return $this->fetch();
    }
    public function updataUser()
    {
        $id = Session::get("id");

        $get = Request::instance()->param();
        $Base = new userData();
        $test_pass = $this->isPwd($get["password"]);
        if (!$test_pass){
            return "<script> alert('密码至少8-16个字符，至少1个大写字母，1个小写字母和1个数字 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";
        }
        if($get["password"]!==$get["password_test"])
        {
            return "<script> alert('两次密码不一样 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }
        $re = $Base->updatapassword($id,$get["password"]);//根据id更改管理员
        if($re == 1 ){
            session("info",null);
            return "<script> alert('更改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('更改失败 请重新尝试');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }

    private function isPwd($pwd){
        $pattern= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/ '; // i 不区分大小写
        if(preg_match($pattern,$pwd)){
            return true;
        }else{
            return false;
        }
    }
}
