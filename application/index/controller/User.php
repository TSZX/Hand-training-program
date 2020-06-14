<?php

namespace app\index\controller;


use app\index\model\IndexStudent;
use think\Controller;
use think\Request;
use think\Session;

class User extends Controller
{

    public function index()
    {
        return $this->fetch();
    }
    public function updata()
    {
        $info = Session::get('info');
        $id =  $info["student_id"];
        $get = Request::instance()->param();
        $Base = new IndexStudent();
        $test_pass = $this->isPwd($get["password"]);
        if (!$test_pass){
            return "<script> alert('密码至少8-16个字符，至少1个大写字母，1个小写字母和1个数字 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";
        }
        if($get["password"]!==$get["password_test"])
        {
            return "<script> alert('两次密码不一样 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }
        $re = $Base->updatapassword($id,$get["password"]);//根据id更改管理员
        if($re == 1 ){
            session("info",null);
            return "<script> alert('更改成功 ');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer);  </script>";

        }else {
            return "<script>alert('更改失败 请重新尝试');var mylayer= parent.layer.getFrameIndex(window.name);parent.layer.close(mylayer); </script>";
        }
    }

    private function isPwd($pwd){
        $pattern= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,16}$/ '; // i 不区分大小写
        if(preg_match($pattern,$pwd)){
            return true;
        }else{
            return false;
        }
    }


}
