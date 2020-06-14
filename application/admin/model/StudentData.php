<?php

namespace app\admin\model;

use think\db\exception\BindParamException;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;
use think\Session;

class StudentData extends Model
{
    protected $table = "student";
    //
    public function select_max()
    {
//        Elective_score
        $re = null;
        $sql = 'select  Professional_grade , max(Elective_score) as max  from student   group by  Professional_grade ';
        try {
           $re =  $this->query($sql);
        } catch (BindParamException $e) {
        } catch (PDOException $e) {
        }
        return $re ;

    }

    public function get_lsit($info){

        $re = null;
        try {
            $re = $this->where("class_name", "LIKE", "%" . $info . "%")->order('compulsory_score desc')->select();
        } catch (DbException $e) {
        }


        return $re;
    }
    public function updata_class($item,$id){
        $re = $this->where("student_id", $item[0])->update([
            'class_name' => $item[3],
            "Professional_grade"=>substr($item[3],0,-2)
        ]);
        return $re;
    }

    public function get_lsit_data($Professional_grade,$page)
    {
        $data_list = $this->where("Professional_grade",$Professional_grade)->order('compulsory_score desc')->paginate(50, false, ['page' => $page])->toArray();
        return $data_list;
    }

    public function get_lsit_null($page)
    {
    }

    public function get_student_list($id,$page)
    {
        $data_list = $this->where('class_name', 'IN', function ($query) use ($id) {
            $query->table('class')->where('class_id',$id)->field('class_name');
        })->paginate(10, false, ['page' => $page])->toArray();
        return $data_list;
    }

}
