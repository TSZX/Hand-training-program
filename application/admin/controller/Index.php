<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;

class Index extends Base
{
    //
    public function index(){

        $info = Session::get("info");
        $role_id = Session::get("role_id");
        $this->assign("name",$info["user_name"]);
        $this->assign("role",$role_id);
        return $this->fetch();
    }

    /**
     * @return View
     */
    public function see_notes()
    {

    }

}
