<?php

namespace app\admin\model;

use think\Exception;
use think\exception\DbException;
use think\Model;

class roleData extends Model
{
     protected $table = "role";
    public  function  get_role_name($role_id)
    {
        var_dump($role_id);
        try {
            $data_list = $this->where("role_id",$role_id)->find()->toArray();
            var_dump($data_list);
        } catch (DbException $e) {
        } catch (Exception $e) {
        }
        return $data_list["Role_name"];
    }
}
