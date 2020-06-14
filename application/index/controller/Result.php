<?php

namespace app\index\controller;

use app\index\model\ApplicationData;
use app\index\model\Project;
use think\Controller;
use think\Request;
use think\Session;

class Result extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $TrueFalse = false;
        $info = Session::get('info');
        $student_id = $info["student_id"];
        $page = 0 ;
        $data  = Request::instance()->param();
        if(isset($data['page']))
        {
            $page = $data['page'];
        }
        $this->assign("tf",1);
        if (isset($data['TrueFalse']))
        {
            if ($data['TrueFalse']==0)
            {
                $TrueFalse=true;
                $this->assign("tf",0);
            }

        }
        $Base = new ApplicationData();
        $return = null;
        if(isset($data['submit_test']))
        {
//            $return = $Base->getData_list_where($data["select_project"]);
        }else {


            $return = $Base->getData_list($page,$TrueFalse,$student_id);
        }
        $cont = $Base->get_bx($student_id);
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$cont);//总数值

        return $this->fetch();
    }

    public function updatain(){
        $data  = Request::instance()->param();
        $project_info = new Project();
        $Base = new ApplicationData();
        $return = $Base->select_Project($data['id']);
        $return_pro = $project_info->select_Project($return['project_id']);

        $this->assign("list",$return);
        $this->assign("info",$return_pro);
        return $this->fetch();

    }
    public function updataapi(){
        $data  = Request::instance()->param();
        $Base = new ApplicationData();


        $re = $Base->updata_app($data);
        if($re == 1 ){
            return "<script> alert('修改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); location.reload()  </script>";

        }else {
            return "<script>alert('修改失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }
}

