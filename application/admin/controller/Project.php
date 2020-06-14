<?php

namespace app\admin\controller;

use app\admin\model\classData;
use app\admin\model\projectData;

use app\admin\model\StudentData;
use app\admin\model\SummaryData;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;
use think\Session;
use PHPExcel;
use PHPExcel_IOFactory;

class Project extends Base
{
    public function deleteData(){
        if (Session::get('role_id')<4){
            return "<script> alert('权限不够 '); </script>";
        }
        $data  = Request::instance()->param();
        $id = $data["id"];
        $Base = new projectData();
        $re = $Base->where("project_id",$id)->delete();
        if($re==1){
            return ["code"=>0,"msg"=>"删除成功"];
        }else{
            return ["code"=>1,"msg"=>"删除失败"];
        }

    }


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
        $Base = new projectData();
        $page = 0 ;
        $data  = Request::instance()->param();
        $select_page = "";
        if(isset($data['page']))
        {
        $page = $data['page'];
        }
        if(isset($data['submit_test']))
        {

            $return = $Base->getData_list_where($page,$data["select_project"]);
            $select_page = "&submit_test=1&select_project=".$data["select_project"];

        }
        else
        {
            $return = $Base->select_user_page($page);
        }

        $this->assign("select_page",$select_page);
        $this->assign("list",$return["data"]);
        $this->assign("last_page",$return["last_page"]);//当前页面
        $this->assign("current_page",$return["current_page"]);//总页面
        $this->assign("total",$return["total"]);//总页面
        return  $this->fetch();
    }



//    ----------------------
    public function setting_time()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
            return $this->fetch("setting");
    }
    public function updata()
    {
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $Base = new projectData();
        $data  = Request::instance()->param();
        try {
          $data_view =   $Base->where("project_id", $data['id'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        $this->assign("data",$data_view);
        return $this->fetch();
    }
    public function add()
    {
        if (Session::get('role_id')<=4){
        return "<script> alert('权限不够 '); </script>";
    }
        return $this->fetch();
    }

    public  function  insetproject()
    {

        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        $data  = Request::instance()->param();
        $Base = new projectData();
        $re =  $Base->inset_porject($data);
        if($re == 1 ){
            return "<script> alert('增加成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('增加失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }

    }
    public  function  updatadata()
    {
        $Base = new projectData();
        $data  = Request::instance()->param();
        $re  = $Base->updata_project($data);
        if($re == 1 ){
            return "<script> alert('更新成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('更新失败 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }

    }


    public  function  newSemester(){
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        vendor('PHPExcel.PHPExcel');
        vendor( 'PHPExcel.PHPExcel_IOFactory.PHPExcel_IOFactory');
        vendor( "PHPExcel.PHPExcel.Reader.Excel5");
        $name  = Request::instance()->param("name");
        if($name == ""){
            return "<script> alert('请输入新学期'); </script>";
        }
        $request = request();
        $file = $request->file("file");
        if($file){
            $up_file = $file->validate(['ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($up_file){
                // 成功上传后 获取上传信息
               $re_name =  $up_file->getExtension();
                $path = ROOT_PATH.'public' . DS . 'uploads/'.$up_file->getSaveName();
                if($re_name=="xlsx"){
                    try {
                        $objReadr = PHPExcel_IOFactory::createReader("Excel2007");
                    } catch (\PHPExcel_Reader_Exception $e) {
                    }
                }else{
                    try {
                        $objReadr = PHPExcel_IOFactory::createReader("Excel5");
                    } catch (\PHPExcel_Reader_Exception $e) {
                    }
                }
                try {
                    $Excel_data = $objReadr->load($path);
                } catch (\PHPExcel_Reader_Exception $e) {
                }
                try {
                    $inset_data = $Excel_data->getSheet(0)->toArray();
                } catch (\PHPExcel_Exception $e) {
                }

                $title = array_shift($inset_data);
                $data = [];
                $test_title = ["项目名称","项目类型","是否必修","分数","申请理由"]	;

                if($title!=$test_title){
                        return "<script>alert('请使用正确的文件格式');</script>";
                }
                foreach ($inset_data as $k=>$v){
                        $data[$k]["project"] = $v[0];
                        $data[$k]["proiject_class"] = $v[1];
                        $data[$k]["obligatory"] = $v[2];
                        $data[$k]["fraction"] = $v[3];
                        $data[$k]["introduction"] = $v[4];
                        $data[$k]["semester"] =$name ;
                }

                $db = db("project");
                $re_in = $db->insertAll($data);
                $db_time = db("time");
                $re_time = $db_time->insert(["Current_semester"=>$name]);
                if(file_exists($path)){
//                    unlink($path);
                }
                if($re_in==0){
                    $this->success("导入出现问题","Project/setting_time");
                }elseif ($re_time==0){
                    $this->success("更新时间出现问题","Project/setting_time");
                }
                $this->success("导入成功","Project/setting_time");
            }else{
                // 上传失败获取错误信息
                return"<script>alert('".$file->getError()."');</script>";
            }
        }

    }




    public  function  oldSemester(){
        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        //查询所有的年级 和选修的max
        //查询所有的必修分数汇总
        $pro_Base = new StudentData();
        $max_arr = $pro_Base->select_max();
        vendor('PHPExcel.PHPExcel');
        $PHPExcel = new PHPExcel();
        $select_sm = new projectData();
        $session_sm = Session::get('Semester');
      	
      	
        $Semester=$select_sm
            ->where("semester",$session_sm)
            ->where("obligatory",1)
            ->sum("fraction");


        foreach ($max_arr as $item){
            $SheepName = $item['Professional_grade']."级";

            try {
                $PHPSheep = $PHPExcel->createSheet();
            } catch (\PHPExcel_Exception $e) {
            };

            $this->get_Excel_list($PHPSheep,$item,$Semester,$session_sm);

        }
        $db = db("student");
        $db->where('student_id',"<>","0")->update(["compulsory_score"=>0,"Elective_score"=>0]);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="成绩汇总.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        try {
            $objWriter = PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel2007');
        } catch (\PHPExcel_Reader_Exception $e) {
        }
        try {
            $objWriter->save('php://output');
        } catch (\PHPExcel_Writer_Exception $e) {
        }
    }


    private  function  get_Excel_list($PHPSheep,$info,$Semester,$session_sm){
        $PHPSheep
            ->setCellValue('A1',"学号")
            ->setCellValue("B1","姓名")
            ->setCellValue("C1","班级")
            ->setCellValue("D1","选修总分")
            ->setCellValue("E1","必修总分")
            ->setCellValue("F1","期末总分")
            ->setCellValue("G1","排名");
        $pro_Base = new StudentData();
        $inset_Base = new SummaryData();

        $inset_list = $pro_Base->get_lsit($info["Professional_grade"]);
        $num = 2;
        foreach ($inset_list as $key=>$value){
          if($info['max']==0){
             $score =(($value['compulsory_score']*1.0/$Semester)*0.6)*100;
          }else
          {
            $score =(($value['compulsory_score']*1.0/$Semester)*0.6+($value['Elective_score']*1.0/$info['max'])*0.4)*100;
          }
          
          
            
            $PHPSheep
                ->setCellValue('A'.$num,$value['student_id'])
                ->setCellValue("B".$num,$value['student_name'])
                ->setCellValue("C".$num,$value['class_name'])
                ->setCellValue("D".$num,$value['Elective_score'])
                ->setCellValue("E".$num,$value['compulsory_score'])
                ->setCellValue("F".$num,$score)
                ->setCellValue("G".$num,$key+1);
            $inset_dat = [
                "student_id"=>$value['student_id'],
                "student_name"=>$value['student_name'],
                "class_name"=>$value['class_name'],
                "Elective_score"=>$value['Elective_score'],
                "compulsory_score"=>$value['compulsory_score'],
                "score"=>$score,
                "Semester"=>$session_sm,
            ];

            $inset_Base->inset_into($inset_dat);
            $num++;
        }



    }



    public  function  studentin(){

        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        vendor('PHPExcel.PHPExcel');
        vendor( 'PHPExcel.PHPExcel_IOFactory.PHPExcel_IOFactory');
        vendor( "PHPExcel.PHPExcel.Reader.Excel5");

        $request = request();
        $file = $request->file("file");
        if($file){
            $up_file = $file->validate(['ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($up_file){
                // 成功上传后 获取上传信息
                $re_name =  $up_file->getExtension();
                $path = ROOT_PATH.'public' . DS . 'uploads/'.$up_file->getSaveName();
                if($re_name=="xlsx"){

                        $objReadr = PHPExcel_IOFactory::createReader("Excel2007");

                }else{

                        $objReadr = PHPExcel_IOFactory::createReader("Excel5");

                }

                    $Excel_data = $objReadr->load($path);


                    $inset_data = $Excel_data->getSheet(0)->toArray();

                $title = array_shift($inset_data);
                $data = [];
                $test_title = ["学生姓名","学号","密码","班级","年级"];
                ;

                if($title!=$test_title){
                    return "<script>alert('请使用正确的文件格式');</script>";
                }
                foreach ($inset_data as $k=>$v){
                    $data[$k]["student_name"] = $v[0];
                    $data[$k]["student_id"] = $v[1];
                    $data[$k]["student_pass"] = md5($v[2]);
                    $data[$k]["class_name"] = $v[3];
                    $data[$k]["student_bool"] = 1;
                    $data[$k]["Elective_score"] =0 ;
                    $data[$k]["compulsory_score"] =0 ;
                    $data[$k]["Professional_grade"] =$v[4] ;
                }

                $db = db("student");
                $re_in = $db->insertAll($data);


                if(file_exists($path)){
//                    unlink($path);
                }
                if($re_in==0){
                    $this->success("导入出现问题","Project/setting_time");
                }
                $this->success("导入成功","Project/setting_time");
            }else{
                // 上传失败获取错误信息
                return"<script>alert('".$file->getError()."');</script>";
            }
        }

    }


    public  function  classin(){

        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        vendor('PHPExcel.PHPExcel');
        vendor( 'PHPExcel.PHPExcel_IOFactory.PHPExcel_IOFactory');
        vendor( "PHPExcel.PHPExcel.Reader.Excel5");

        $request = request();
        $file = $request->file("file");
        if($file){
            $up_file = $file->validate(['ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($up_file){
                // 成功上传后 获取上传信息
                $re_name =  $up_file->getExtension();
                $path = ROOT_PATH.'public' . DS . 'uploads/'.$up_file->getSaveName();
                if($re_name=="xlsx"){

                    $objReadr = PHPExcel_IOFactory::createReader("Excel2007");

                }else{

                    $objReadr = PHPExcel_IOFactory::createReader("Excel5");

                }

                $Excel_data = $objReadr->load($path);


                $inset_data = $Excel_data->getSheet(0)->toArray();

                $title = array_shift($inset_data);
                $data = [];
                $test_title = ["班级名称","班主任姓名","分院名称","分院id"];

                ;

                if($title!=$test_title){
                    return "<script>alert('请使用正确的文件格式');</script>";
                }
                foreach ($inset_data as $k=>$v){
                    $data[$k]["class_name"] = $v[0];
                    $data[$k]["class_main_name"] = $v[1];
                    $data[$k]["college_name"] =$v[2];
                    $data[$k]["college_id"] = $v[3];

                }

                $db = db("class");
                $re_in = $db->insertAll($data);


                if(file_exists($path)){
//                    unlink($path);
                }
                if($re_in==0){
                    $this->success("导入出现问题","Project/setting_time");
                }
                $this->success("导入成功","Project/setting_time");
            }else{
                // 上传失败获取错误信息
                return"<script>alert('".$file->getError()."');</script>";
            }
        }

    }



//
    public  function  studentupdata(){

        if (Session::get('role_id')<=4){
            return "<script> alert('权限不够 '); </script>";
        }
        vendor('PHPExcel.PHPExcel');
        vendor( 'PHPExcel.PHPExcel_IOFactory.PHPExcel_IOFactory');
        vendor( "PHPExcel.PHPExcel.Reader.Excel5");

        $request = request();
        $file = $request->file("file");
        if($file){
            $up_file = $file->validate(['ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($up_file){
                // 成功上传后 获取上传信息
                $re_name =  $up_file->getExtension();
                $path = ROOT_PATH.'public' . DS . 'uploads/'.$up_file->getSaveName();
                if($re_name=="xlsx"){

                    $objReadr = PHPExcel_IOFactory::createReader("Excel2007");

                }else{

                    $objReadr = PHPExcel_IOFactory::createReader("Excel5");

                }

                $Excel_data = $objReadr->load($path);


                $inset_data = $Excel_data->getSheet(0)->toArray();

                $title = array_shift($inset_data);
                $test_title = ["学号","学生姓名","新班级","原班级"];

                if($title!=$test_title){
                    return "<script>alert('请使用正确的文件格式');</script>";
                }
                $db = db("student");
                $db = new StudentData();
                foreach ($inset_data as $item){
                    $re_in =$db->where("student_id",$item[0])->update([ 'class_name'=>$item[2],
                        'Professional_grade'=>substr($item[2],0,-2)]);
                }



                if(file_exists($path)){
//                    unlink($path);
                }
                if($re_in==0){
                    $this->success("导入出现问题","Project/setting_time");
                }
                $this->success("导入成功","Project/setting_time");

            }else{
                // 上传失败获取错误信息
                return"<script>alert('".$file->getError()."');</script>";
            }
        }

    }


}
