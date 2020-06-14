<?php

namespace app\index\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class IndexStudent extends Model
{
    //
    protected $table="student";
    public function login($data)
    {

        try {
            $ret = $this->where("student_id", $data["username"])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if(!$ret){
            return false;
        }

        if ($ret["student_pass"]==md5($data["password"])){
            session("info",$ret);
            return true;
        }
        return false;

    }

    public function getinfo($student_id)
    {
        $return = null;
        try {
           $return =  $this->where("student_id", $student_id)->find()->toArray();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        return $return ;
    }

    public function updatapassword($id, $password)
    {
        $re =  $this->where('student_id', $id)->update([
            'student_pass' => md5($password)
        ]);
        return $re;
    }


    public function get_lsit($info , $semester,$page){

        $select_field = [
            "student_name",
            "compulsory_score",
            "Elective_score",
            "class_name",
        ];
        $re = null;
        try {
            $re = $this->field($select_field)->where("class_name", "LIKE", "%" . substr($info["class_name"], 0, -2) . "%")->order('compulsory_score desc')->paginate(20, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }


        return $re;
    }
}
