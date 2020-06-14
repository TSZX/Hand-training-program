<?php


namespace app\index\validate;


use think\Validate;

class UserValidata  extends Validate
{
    protected  $rule = [
        "password"=>"require",
    ];
    protected  $message=[
        "password.require" => "密码不能为空",
    ];
}
