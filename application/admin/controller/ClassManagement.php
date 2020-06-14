<?php

namespace app\admin\controller;

use app\admin\model\classData;
use app\admin\model\CollegeData;

use app\admin\model\StudentData;
use think\Request;
use think\Session;

class ClassManagement extends Base
{

    public function index()
    {
       $role_id =  Session::get('role_id');

        $Base = new classData();
        $data  = Request::instance()->param();
        $page = 0 ;
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        if(isset($data['submit_test']))
            {

                $return = $Base->getData_list_where($page,$data["select_class"],$role_id);
            }
        else
            {

                $return = $Base->getData_list($page,$role_id);
            }


        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$return["total"]);//总页面
        return $this->fetch();
    }


    public  function  add(){
        if (Session::get('role_id')<4){
            return "<script> alert('权限不够 '); </script>";
        }
        $college = new CollegeData();
        $list = $college->get_college_id_name();
        $this->assign("list",$list);
        return  $this->fetch();

    }
    public  function  updata(){
        if (Session::get('role_id')<3){
            return "<script> alert('权限不够 ');  </script>";
        }
        $get = Request::instance()->param();
        $Base = new classData();
        $data = $Base->getclass($get);//获得班级数据
        $this->assign("data",$data);
        $college = new CollegeData();//学院获取
        $list = $college->get_college_id_name();
        $this->assign("list",$list);
        return  $this->fetch();
    }
    public  function  insetclass()
    {
        if (Session::get('role_id')<4){
            return "<script> alert('权限不够 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);   </script>";
        }
        $data  = Request::instance()->param();
        $college = new CollegeData();
        $college = $college->get_college_name($data["colloge"]);
        $Base = new classData();
        $re = $Base->insetclass($data,$college["college_name"]);
        if($re == 1 ){
            return "<script> alert('增加成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('增加失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
    public function updatadata()
    {
        if (Session::get('role_id')<3){
        return "<script> alert('权限不够 '); </script>";
        }
        $data  = Request::instance()->param();
        $Base = new classData();
        $re =  $Base->updataclass($data);
        if($re == 1 ){
            return "<script> alert('更改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('更改失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
    public  function  deleteclass()
    {
        if (Session::get('role_id')<5){
            return ["code"=>1,"msg"=>"权限不够"];
        }
        $data  = Request::instance()->param();
        $id = $data["id"];
        $Base = new classData();
        $re = $Base->where("class_id",$id)->delete();
        if($re==1){
            return ["code"=>0,"msg"=>"删除成功"];
        }else{
            return ["code"=>1,"msg"=>"删除失败"];
        }

    }

    public function cat(){
        $data  = Request::instance()->param();
        $id = $data["id"];
        $page = 0 ;
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        $Base = new  StudentData();
        $return = $Base->get_student_list($id,$page);
        $this->assign("list",$return["data"]);
        $this->assign("id",$id);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$return["total"]);//总页面
        return $this->fetch();


    }
    public  function  deleteStudent()
    {
        $data  = Request::instance()->param();
        $id = $data["id"];
        $Base = db("student");
        $re = $Base->where("student_id",$id)->update(["class_name"=>"","Professional_grade"=>""]);
        if($re==1){
            return ["code"=>0,"msg"=>"删除成功"];
        }else{
            return ["code"=>1,"msg"=>"删除失败"];
        }

    }


}
