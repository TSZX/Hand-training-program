<?php


namespace app\Index\validate;


use think\Validate;

class LoginValidate extends Validate
{
    protected  $rule = [
        "username"=>"require",
        "password"=>"require",
        "code"=>"require",

    ];
    protected  $message=[
        "username.require" => "用户名不能为空",
        "password.require" => "密码不能为空",
        "code.require" => "验证码不能为空",

    ];
}
