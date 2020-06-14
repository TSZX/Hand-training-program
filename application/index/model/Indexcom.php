<?php

namespace app\index\model;

use think\exception\DbException;
use think\Model;

class Indexcom extends Model
{
    //
    protected $table="summary";
//


    public function get_lsit($info , $semester,$page){
        $select_field = [
            "student_name",
            "compulsory_score",
            "Elective_score",
            "class_name",
            "score"

        ];
        $re = null;
        try {
            $re = $this->field($select_field)->where("semester",$semester)->where("class_name","LIKE",substr($info["class_name"],0,-2)."%")->order('score desc,compulsory_score desc')->paginate(20, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }

        return $re;
    }
}
