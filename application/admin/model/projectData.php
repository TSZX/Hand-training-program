<?php

namespace app\admin\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Model;
use think\Session;

class projectData extends Model
{
    protected $table = "project";

    public function select_user_page($page)
    {

        try {
            $data_list = $this->where("semester", Session::get("Semester"))->paginate(30, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }

        return $data_list;
    }

    public function getData_list_where($page, $select_project)
    {

            $data_list = $this->where("semester",Session::get("Semester"))->where('project','like','%'.$select_project.'%')->paginate(10, false, ['page' => $page])->toArray();

        return $data_list;
    }


    public function inset_porject($get_data)
    {
        try {
            $test_name = $this->where("semester",Session::get("Semester"))->where("project", $get_data["name"])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if(isset($test_name["project"]))
        {
            return 0;
        }


        $data = [
            "fraction"=>$get_data['fraction'],
            "obligatory"=>$get_data['obligatory'],
            "introduction"=>$get_data['text_project'],
            "proiject_class"=>$get_data['project_class'],
            'project'=>$get_data['name'],
            'semester'=>Session::get("Semester")

        ];

        $re =  $this->insert($data);
        return $re;
    }

    public function updata_project($data)
    {
        if($data["text_project"]==="")
        {
            $re =  $this->where('project_id', $data["id"])->update([
                'project' => $data["name"],
                'fraction' => $data["fraction"],

            ]);
        }else
            {
                $re =  $this->where('project_id', $data["id"])->update([
                    'project' => $data["name"],
                    'fraction' => $data["fraction"],
                    'introduction' => $data["text_project"],

                ]);
            }

        return $re;
    }


}
