<?php
namespace app\index\controller;


use app\index\model\IndexDatabase;
use think\Session;


class Index extends  Base
{
        public function  index()
        {

            $info = Session::get('info');
            $name = $info["student_name"];
            $this->assign("name",$name);
            return $this->fetch();

        }
}
