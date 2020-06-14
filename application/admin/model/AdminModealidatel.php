<?php

namespace app\admin\model;

use think\Model;

class AdminModealidatel extends Model
{
    protected $table="user";
    public function login($data)
    {

        $ret = $this->where("user_name",$data["username"])->find();
        if(!$ret){
            return false;
        }

        if ($ret["password"]==md5($data["password"])){
            session("id",$ret["user_id"]);
            session("role_id",$ret["role_id"]);
            session("info",$ret);
            return true;
        }
        return false;

    }


}
