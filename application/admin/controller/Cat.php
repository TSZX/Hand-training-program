<?php

namespace app\admin\controller;

use app\admin\model\CatgoryModel;

use app\admin\model\classData;
use app\admin\model\StudentData;
use app\admin\model\SummaryData;
use app\admin\model\TimeData;
use app\index\model\Indexcom;
use app\index\model\IndexSemester;
use app\index\model\IndexStudent;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;
use think\Session;

class Cat extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     * @throws \think\exception\DbException
     */
    public function index()
    {

        $db = new CatgoryModel();

        $list =  $db ->where('class_name','IN',function($query){
                $query->table('class')->where('class_main_name',Session::get("info")['user_name'])->field('class_name');
            })
            ->paginate();
        if (!$list){
            $list =  $db ->where('college_name','IN',function($query){
                $query->table('class')->where('college_main_name',Session::get("info")['user_name'])->field('college_name');
            })
                ->paginate();
        }
        if (!$list){
            $list = $db->paginate();
        }


        $list = $db->paginate();
        $this->assign("list",$list);
        $this->assign("total",$list->total());
        return  $this->fetch();

    }


    public  function begin(){
        $db = new CatgoryModel();
        $user =  Db::table('class')->where('class_main_name',Session::get("info")["user_name"])->find();
        $list = $db->where('agree',0)->where('class_name',"IN",$user['class_name'])->paginate();//->where('class_name',$user['class_name'])
        $this->assign("list",$list);
        $this->assign("total",$list->total());
        return  $this->fetch("begin");
    }




    public  function  fraction(){
        $com = Session::get("Semester");
        $data  = Request::instance()->param();
        $sem_list = db("time");
        $re_list = $sem_list->select();
        $class_base  = new classData();
        $class = $class_base->get_class();
        $com_view = $com;
        $Professional_grade_view = "";
        $page = 0 ;
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        if($com == isset($data["com"])?$data["com"]: $com){
            $Base = new StudentData();
            if (empty($data["Professional_grade"])){
                $this->assign("semlist",$re_list);//总页面
                $this->assign("class",$class);//总
                return  $this->fetch("scoring2");
            }else{
                $Professional_grade_view = $data["Professional_grade"];
                $return =  $Base->get_lsit_data($data["Professional_grade"],$page);
            }

        }else{
            $Base = new SummaryData();
            if (empty($data["Professional_grade"])){
                $this->success("请选择年级","cat/fraction");
            }else{
                $com_view = $data["com"];
                $Professional_grade_view = $data["Professional_grade"];
                $return =  $Base->get_lsit_data_con($data["com"],$data["Professional_grade"],$page);
            }

        }
        $this->assign("com_view",$com_view);
        $this->assign("Professional_grade",$Professional_grade_view);
        $this->assign("semlist",$re_list);//总页面
        $this->assign("class",$class);//总
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面


        return  $this->fetch("scoring");
    }



    public function save(Request $request)
    {
        //
        $data  = $request->param();
    }

    public  function  data(){
        $id =  Request::instance()->param();
        return  $id;
    }
    public function delete()
    {
        //
        $db = new CatgoryModel();
        $id =  Request::instance()->param('id');
        $re =  $db->delete_re((int)$id);

        return $re;

    }

    public  function  return_pub(){
        $db = new CatgoryModel();
        $id =  Request::instance()->param('id');
        $re =  $db->return_pub((int)$id);
        return $re ;
    }
    public  function  pass(){
        $db = new CatgoryModel();
        $id =  Request::instance()->param('id');
        $re =  $db->pass((int)$id);
        return $re ;
    }
    public  function  show(){

        $db = new CatgoryModel();
        $id =  Request::instance()->param('id');
        $list = $db->where("id",$id)->find();
        $this->assign("data",$list);
        return  $this->fetch();

    }
}
