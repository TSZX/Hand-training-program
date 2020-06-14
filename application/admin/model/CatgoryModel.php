<?php

namespace app\admin\model;

use think\Db;
use think\Exception;
use think\Model;

class CatgoryModel extends Model
{
    protected $table="application";
    // 退回已经通过的记录
    function  delete_re($id){

        $ret = $this->where("id",$id)->find();
        if(!$ret){
            return  ['code'=>0,'msg'=>'没有这条记录 '];
        }
        $this->where("id",$id)->update(['agree'=>2]);
        $re_num = 0;

        if ($ret['Compulsory_bool']==1){

            try {
                $re_num = Db::table('student')->where('student_id', $ret['student_id'])->setDec('compulsory_score', $ret['function']);
                $re_num = $this->where('id', $id)->update("tc_data",time());
            } catch (Exception $e) {
            }
        }else if($ret['Compulsory_bool']==0){
            $re_num =   Db::table('student')->where('student_id', $ret['student_id'])->setDec('Elective_score', $ret['function']);
            $re_num = $this->where('id', $id)->update("tc_data",time());
        }
        return ['code'=>$re_num,'msg'=>"退回成功 "];
//        return $ret;


    }

    //退回已经未通过的记录
    function  return_pub($id){

        $ret = $this->where("id",$id)->find();
        if(!$ret){
            return  ['code'=>0,'msg'=>'没有这条记录 '];
        }
        $re =  $this->where("id",$id)->update(['agree'=>2]);


        if ($re == 1){
            return ['code'=>$re,'msg'=>"退回成功 "];
        }


        return ['code'=>$re,'msg'=>"失败 "];


    }

    //通过一条记录
    function  pass($id){

        $ret = $this->where("id",$id)->find();
        if(!$ret){
            return  ['code'=>0,'msg'=>'没有这条记录 '];
        }

        $re_num = 0;

        if ($ret['Compulsory_bool']==1){
            $this->where("id",$id)->update(['agree'=>1]);
            try {
                $re_num = Db::table('student')->where('student_id', $ret['student_id'])->setInc('compulsory_score', $ret['function']);
                $re_num = $this->where('id', $id)->update("tc_data",time());
            } catch (Exception $e) {
            }

        }else if($ret['Compulsory_bool']==0){
            $this->where("id",$id)->update(['agree'=>1]);
            try {
                $re_num = Db::table('student')->where('student_id', $ret['student_id'])->setInc('Elective_score', $ret['function']);
                $re_num = $this->where('id', $id)->update("tc_data",time());
            } catch (Exception $e) {
            }
        }
        if ($re_num == 1){
            return ['code'=>$re_num,'msg'=>"成功 "];
        }


        return ['code'=>$re_num,'msg'=>"失败 "];



    }


    public function get_lsit_data_con($com, $Professional_grade, $page)
    {
        $data_list = $this->where("Semester",$com)->where("class_name","LIKE",$Professional_grade."%")->order('compulsory_score desc')->paginate(50, false, ['page' => $page])->toArray();
        return $data_list;
    }
}
