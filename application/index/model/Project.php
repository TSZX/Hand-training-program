<?php

namespace app\index\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;
use think\Session;

class Project extends Model
{
    //
    protected $table = "project";

    public function getData_list($page,$where_id)
    {


        $data_list =null;
        try {

            $data_list = $this->where("obligatory","<>",1)->whereOr("project_id","NOT IN",$where_id)->paginate(30, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }
        return $data_list;
    }

    public function get_bx($project_id_arr)
    {
        $cont = null;
        try {
            $cont = $this->where("obligatory", 1)->where("semester", Session::get("Semester"))->where("project_id", "NOT IN", $project_id_arr)->count();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        if($cont==null)
        {
            try {
                $cont = $this->count();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
            } catch (Exception $e) {
            }
        }
        return $cont ;
    }

    public function select_Project($id)
    {
        $re = null;
        try {
          $re = $this->where("project_id", $id)->find()->toArray();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        return $re;
    }

}
