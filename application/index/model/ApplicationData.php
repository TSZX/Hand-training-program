<?php

namespace app\index\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class ApplicationData extends Model
{
    //
    protected $table="application";

    public function get_in_application($student_id)
    {
        $where = [
            'student_id'     => [ 'eq' , $student_id] ,
            'agree' => [ [ 'eq' , 0] , [ 'eq' , 1 ]  , 'or' ] ,
        ];

        try {

            $select = $this->field("project_id")->where($where)->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        $ret = "";

        foreach ( $select as $item) {
            $ret .= $item["project_id"].", ";

        }

       return $ret;
    }

    public function getData_list($page, $trueOrFalse,$id)
    {

        $data_list =null;
        if($trueOrFalse) {//查看未通过
            try {

                $data_list = $this->where("agree","2")->where("student_id",$id)->paginate(20, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }else{
            try {

                $data_list = $this->where("student_id",$id)->paginate(20, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }
//        var_dump($data_list);
        return $data_list;
    }

    public function get_bx($id)
    {
        $cont=0;
        try {
            $cont = $this->where("agree", "2")->where("student_id", $id)->count();
        } catch (Exception $e) {
        }
        return $cont;
    }

    public function in_application( $in_data, $student_id, $project_id,$info)
    {
        $cont = 0 ;
        try {
            $cont = $this->where("agree", "0")->where("student_id", $student_id)->where("project_id", $project_id)->count();
        } catch (Exception $e) {
        }
        if ($cont != 0 ){
            return ["code"=>0,"msg"=>"当前项目已经申请正在审核"];
        }

        $data=[
            "Compulsory_bool" => $in_data["obligatory"],
            "student_id" =>$student_id,
            "agree" =>0,
            "file_url" =>$in_data["url"],
            "reason_for_application" =>$in_data["reason_for_application"],
            "time" =>time(),
            "project_id" =>$in_data["project_id"],
            "student_name" =>$info["student_name"],
            "project_name" =>$in_data["project"],
            "class_name" =>$info["class_name"],
            "function" =>$in_data["fraction"]
        ];



        $re = $this->insert($data);
        if ($re==1){
            return ["code"=>1,"msg"=>"申请成功"];
        }else{
            return ["code"=>0,"msg"=>"申请失败"];
        }
    }

    public function select_Project($id)
    {
        $re = null;
        try {
            $re = $this->where("id", $id)->find()->toArray();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }

        return $re;
    }

    public function updata_app( $info)
    {
        if($info['img_url']==''){
            $data=[
                "reason_for_application" =>$info["sqly"],
                "agree" =>0,
                "time" =>time()
            ];
        }else{
            $data=[
                "reason_for_application" =>$info["sqly"],
                "agree" =>0,
                "file_url" =>$info["img_url"],
                "time" =>time()

            ];
        }



        $re = $this->where("id",$info['id'])->update($data);
        return $re;
//        if ($re==1){
//            return ["code"=>1,"msg"=>"重申成功"];
//        }else{
//            return ["code"=>0,"msg"=>"重申失败"];
//        }
    }

}
