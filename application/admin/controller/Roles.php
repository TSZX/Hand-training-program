<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Roles extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return  $this->fetch();
    }
}
