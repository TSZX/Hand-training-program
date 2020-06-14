<?php

namespace app\index\controller;

use app\index\model\ApplicationData;
use app\index\model\Project;
use think\Request;
use think\Session;

class Xmsq extends Base
{


    public function index()
    {
        //
        $info = Session::get('info');
        $student_id = $info["student_id"];
        $page = 0 ;
        $data  = Request::instance()->param();
        if(isset($data['page']))
        {
            $page = $data['page'];
        }

        $Base = new Project();
        $student_app = new ApplicationData();
        $project_id_arr =$student_app->get_in_application($student_id);

        $return = $Base->getData_list($page,$project_id_arr);
        $cont = $Base->get_bx($project_id_arr);
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$cont);//总数值
        return $this->fetch();

    }
    public  function  insetProjiect()
    {
        $data  = Request::instance()->param();
        $Base = new Project();
        $return = $Base->select_Project($data['id']);
        $this->assign("list",$return);
        return $this->fetch();
    }

    public  function inset_project()
    {
        $data  = Request::instance()->param();
        $project_id = $data["project_id"];
        $project_data = new Project();
        $in_data = $project_data->select_Project($project_id);
        $in_data["reason_for_application"] = $data["sqly"];
        $in_data["url"] = $data["img_url"];
        $Base = new ApplicationData();
        $info = Session::get('info');
        $student_id = $info["student_id"];

        $re  = $Base->in_application($in_data,$student_id,$project_id,$info);
        return $re;
    }

}
