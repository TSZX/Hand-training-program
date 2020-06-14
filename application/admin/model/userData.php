<?php

namespace app\admin\model;

use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

class userData extends Model
{
    protected $table = "user";
    public  function  select_user_page($page)
    {

        try {
            $data_list = $this->paginate(10, false, ['page' => $page])->toArray();
        } catch (DbException $e) {
        }
        return $data_list;
    }
     public function getData_list_where($page,$where)
    {

        $data_list = null;
        try {
            $data_list = $this->where('user_name','like',$where.'%')->paginate(50, false, ['page' => $page])->toArray();
        } catch (DbException $e) {

        }

        return $data_list;

    }

    /**
     * @param $get_data
     * @param $role_name
     * @return int|string
     */
    public  function  insetuser($get_data, $role_name)
    {

        try {
            $test_name = $this->where("user_name", $get_data["adminName"])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if(isset($test_name["user_name"]))
        {
            return 0;
        }

        $data = [
            "user_name"=>$get_data["adminName"],
            "password"=>md5($get_data["password"]),
            "role_id"=>$get_data["adminRole"],
            "roli_name"=>$role_name
        ];
        $re =  $this->insert($data);
        return $re;
    }

    public function updatauser($get_data,$role_name)
    {

        $re =  $this->where('user_id', $get_data["id"])->update([
            'password' => md5($get_data["password"]),
            "roli_name"=>$role_name,
            "role_id"=>$get_data["adminRole"]

            ]);
        return $re;
    }


    public function getuser($get_data)
    {
        try {
            $re = $this->where('user_id', $get_data["id"])->find()->toArray();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        return $re;
    }

    public function updatapassword($id, $password)
    {
        $re =  $this->where('user_id', $id)->update([
            'password' => md5($password)
        ]);
        return $re;
    }


}
