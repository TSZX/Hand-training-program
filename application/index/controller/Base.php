<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    //
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        if (!session("info")){
            $this->redirect(url("Login/index"));
        }
//        if (session("role_id")){
//            $this->redirect(url("Login/index"));
//        }
    }
}
