<?php

namespace app\admin\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Model;

class CollegeData extends Model
{
    protected $table = "college";

    //  $data_list =  $this->field("title")->field("id")->field("img")->paginate(10,false, ['page' => $page])->toArray();

    public function  get_college_id_name()
    {
        try {
            $data_list = $this->field("college_id")->field("college_name")->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        return $data_list;
    }
    public function  get_college_name($id)
    {

            $data_list = $this->field("college_name")->where("college_id",$id)->find();

        return $data_list;
    }
    public function getData_list($page)
    {

        try {
            $data_list = $this->paginate(10, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }
     return $data_list;

    }

    public  function  getCollege($data)
    {
        $data_list = $this->where("college_id",$data["id"])->find()->toArray();
        return $data_list;
    }
    public  function  updataCollege($get_data)
    {
        $re =  $this->where('college_id', $get_data["id"])->update(['college_main_name' => $get_data["admin"]]);
        return $re;
    }
    public  function  insetcollege($get_data)
    {
        $data = ["college_name"=>$get_data["name"],"college_main_name"=>$get_data["admin"]];
        $re =  $this->insert($data);
        return $re;
    }
    public  function  deletecollege($get_data)
    {
        $re =  $this->where('college_id',$get_data["id"])->delete();
        return $re;
    }
}
