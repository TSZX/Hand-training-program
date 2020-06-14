<?php

namespace app\admin\model;

use think\Model;

class SummaryData extends Model
{
    //
    protected $table = "summary";

    public function inset_into(array $inset_dat)
    {
        $re = $this->insert($inset_dat);
        return $re;
    }

    public function get_lsit_data_con($com, $Professional_grade, $page)
    {
        $data_list = $this->where("Semester",$com)->where("class_name","LIKE",$Professional_grade."%")->order('compulsory_score desc')->paginate(50, false, ['page' => $page])->toArray();
        return $data_list;
    }
}
