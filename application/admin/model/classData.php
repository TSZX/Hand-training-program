<?php

namespace app\admin\model;

use think\db\exception\BindParamException;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;
use think\Session;

class classData extends Model
{
    //
    protected $table = "class";
    public function getData_list($page,$role_id)
    {
        if($role_id==2){
            try {
                $data_list = $this->where('class_name','IN',function($query){
                    $query->table('class')->where('class_main_name',Session::get("info")['user_name'])->field('class_name');
                })->paginate(10, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }elseif ($role_id==3){

            try {
                $data_list = $this->where('college_name', 'IN', function ($query) {
                    $query->table('college')->where('college_main_name', Session::get("info")['user_name'])->field('college_name');
                })->paginate(10, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }

        } else{
            try {
                $data_list = $this->paginate(10, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }
        return $data_list;

    }
    public function getData_list_where($page,$where,$role_id)
    {

        if($role_id==2){
            try {
                $data_list = $this->where('class_name','like',$where.'%')->where('class_name','IN',function($query){
                    $query->table('class')->where('class_main_name',Session::get("info")['user_name'])->field('class_name');
                })->paginate(10, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }elseif ($role_id==3){
            try {
                $data_list = $this->where('class_name','like',$where.'%')->where('college_name','IN',function($query){
                    $query->table('college')->where('college_main_name',Session::get("info")['user_name'])->field('college_name');
                })->paginate(10, false, ['page' => $page])->toArray();

            } catch (DbException $e) {
            }
        } else{
            try {
                $data_list = $this->where('class_name','like',$where.'%')->paginate(10, false, ['page' => $page])->toArray();
            } catch (DbException $e) {
            }
        }

        return $data_list;

    }
    public  function  insetclass($get_data,$college_name)
    {

        $test_name = $this->where( "class_name",$get_data["name"])->find();
        if(isset($test_name["class_name"]))
        {
            return 0;
        }
        $data = [
            "class_name"=>$get_data["name"],
            "class_main_name"=>$get_data["admin"],
            "college_id"=>$get_data["colloge"],
            "college_name"=>$college_name
        ];
        $re =  $this->insert($data);
        return $re;
    }

    public function getclass($get)
    {

        try {
            $data_list = $this->where("class_id", $get["id"])->find()->toArray();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        return $data_list;
    }
    public  function  updataclass($get_data)
    {

        $re =  $this->where('class_id', $get_data["id"])->update(['class_main_name' => $get_data["admin"]]);
        return $re;
    }

    public function get_class()
    {
        $sql = "SELECT max(`compulsory_score`), `Professional_grade` FROM `student`  group by `Professional_grade`";
        try {
        $re =  $this->query($sql);
        } catch (BindParamException $e) {
        } catch (PDOException $e) {
        }
        return $re;
    }
}
